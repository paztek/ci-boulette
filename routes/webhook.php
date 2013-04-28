<?php
use CiBoulette\Model\Execution;

use Doctrine\ORM\NoResultException;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Process\Process;

use CiBoulette\Model\Commit;
use CiBoulette\Model\Push;

$webhookApp = $app['controllers_factory'];

$webhookApp->post('/webhook', function(Request $request) use ($app) {
    $em = $app['orm.em'];

	$app['monolog']->addDebug('[WEBHOOK]Receiving Hook.');

    $payload = json_decode($request->request->get('payload'), true);

    $repositoryUrl = $payload['repository']['url'];

	$app['monolog']->addInfo(sprintf("[WEBHOOK]Receiving hook from '%s'.", $repositoryUrl));

    try {
        // We find the corresponding repository
        $repository = $em->getRepository('CiBoulette\Model\Repository')->findOneByUrl($repositoryUrl);
        if ($repository === null) {
            throw new NoResultException('Repository not found : ' . $repositoryUrl);
        }

		$app['monolog']->addInfo(sprintf("[WEBHOOK]Hook source is '%s'.", $repository));

        // Push creation
        $push = new Push();
        $push->setRef($payload['ref']);
        $push->setTimestamp(new \DateTime());
        $push->setRepository($repository);

        $em->persist($push);

        $commitsData = $payload['commits'];

        $app['monolog']->addDebug(sprintf("[WEBHOOK]Commits to compute : %d", count($commitsData)));

        // Creation of the commits
        foreach ($commitsData as $i => $commitData) {
            $app['monolog']->addDebug(sprintf("[WEBHOOK]Computing Commit %d ID %s", $i, $commitData['id']));
            try {
                $commit = $em->getRepository('CiBoulette\Model\Commit')->find($commitData['id']);
            } catch (NoResultException $exception) {
                $commit = new Commit();
            }
            $commit->setHash($commitData['id']);
            $commit->setMessage($commitData['message']);
            $commit->setTimestamp(new \DateTime($commitData['timestamp']));
            $commit->setUrl($commitData['url']);
            $commit->setAuthor($commitData['author']['name']);
            $commit->setPush($push);

            $em->persist($commit);

            // If the commit is the last one (reference by the 'after' key, we set the additional relation with the push object
            if ($commit->getHash() == $payload['after']) {
                $push->setAfter($commit);
            }
        }

        $app['monolog']->addDebug("[WEBHOOK]Find before...");

        // We try to find the commit referenced as 'before'. It may not exist.
        try {
            $commit = $em->getRepository('CiBoulette\Model\Commit')->find($payload['before']);
            $push->setBefore($commit);
        } catch (Exception $exception) {
            // Nothing to do
        }

        $app['monolog']->addDebug("[WEBHOOK]Saving push...");
        $em->flush();

        if ($repository->isActive()) {
            // Check if we can cd to working dir
            $process = new Process('cd ' . $repository->getWorkingDir());
            $process->run();

            if ($process->isSuccessful()) {
                // Process commands associated with the repository
                $commands = $repository->getCommands();

                foreach ($commands as $command) {
                    if (!$command->isActive()) {
                        continue;
                    }
                    $app['monolog']->addDebug(sprintf("[WEBHOOK]Running command %s", $command));
                    $process = new Process($command->getCommand(), $repository->getWorkingDir(), array(
                        'WORK_URL' => $repository->getUrl(),
                        'WORK_REF' => $push->getRef(),
                        'WORK_AFTER' => $push->getAfter()
                    ));
                    $process->run();

                    $execution =  new Execution();

                    $em->persist($execution);

                    $execution->setTimestamp(new \DateTime());
                    $execution->setPush($push);
                    $execution->setCommand($command);
                    $execution->setRunnedCommand($command->getCommand());
                    $execution->setSuccessful($process->isSuccessFul());
                    if ($process->isSuccessful()) {
                        $execution->setShellResult($process->getOutput());
                    } else {
                        $execution->setShellResult($process->getErrorOutput());
                        $app['monolog']->addError(sprintf("[WEBHOOK]Command %s failed. Stopping executions", $command));
                        break;
                    }
                }

                $em->flush();
            }
            else
                $app['monolog']->addError(sprintf("[WEBHOOK]Unable to cd to working dir '%s'", $repository->getWorkingDir()));

        } else {
            $app['monolog']->addInfo(sprintf("[WEBHOOK]Repository '%s' is inactive : no command executed.", $repository));
        }

    } catch (NoResultException $exception) {
        // The corresponding repository wasn't found.
        $app['monolog']->addError(sprintf("[WEBHOOK]Repository '%s' is not found.", $repositoryUrl));

    } catch (Exception $exception) {
        $app['monolog']->addError(sprintf("[WEBHOOK]Unknown exception: %s", $exception->getMessage()));
        return new Response('', 201);
    }

    return new Response('', 201);
});

return $webhookApp;