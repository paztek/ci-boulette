<?php
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use CiBoulette\Model\Commit;
use CiBoulette\Model\Push;

$webhookApp = $app['controllers_factory'];

$webhookApp->post('/webhook', function(Request $request) use ($app) {
    $em = $app['orm.em'];

	$app['monolog']->addDebug('[WEBHOOK]Receiving Hook.');
	
    $payload = json_decode($request->request->get('payload'), true);
	
	// ob_start();
	// var_dump($payload);
	// $payload_dump = ob_get_contents();
	// ob_end_clean();
	// $app['monolog']->addDebug(sprintf("[WEBHOOK]%s", $payload_dump));
	
    $repositoryUrl = $payload['repository']['url'];
	
	$app['monolog']->addInfo(sprintf("[WEBHOOK]Receiving hook from '%s'.", $repositoryUrl));
	
    try {
        // We find the corresponding repository
        $repository = $em->getRepository('CiBoulette\Model\Repository')->findOneByUrl($repositoryUrl);

		$app['monolog']->addInfo(sprintf("[WEBHOOK]Hook source is '%s'.", $repository));
		
        // Push creation
        $push = new Push();
        $push->setRef($payload['ref']);
        $push->setTimestamp(new \DateTime());
        $push->setRepository($repository);

        $em->persist($push);

        $commitsData = $payload['commits'];

        // Creation of the commits
        foreach ($payload['commits'] as $i => $commitData) {
            $commit = new Commit();
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

        // We try to find the commit referenced as 'before'. It may not exist.
        try {
            $commit = $em->getRepository('CiBoulette\Model\Commit')->findOneByHash($payload['before']);
            $push->setBefore($commit);
        } catch (Exception $exception) {
            // Nothing to do
        }

        $em->flush();

    } catch (Exception $exception) {
        // The corresponding repository wasn't found.
		$app['monolog']->addError(sprintf("[WEBHOOK]Repository '%s' is not found.", $repositoryUrl));
        return new Response('', 201);
    }

    return new Response('', 201);
});

return $webhookApp;