<?php

namespace CiBoulette\Tools\Console;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;

class ConsoleRunner
{
    public static function run(HelperSet $helperSet, $commands = array())
    {
        $cli = new Application('Doctrine Command Line Interface', \Doctrine\ORM\Version::VERSION);
        $cli->setCatchExceptions(true);
        $cli->setHelperSet($helperSet);
        self::addCommands($cli);
        $cli->addCommands($commands);
        $cli->run();
    }

    public static function addCommands(Application $cli)
    {
        $cli->addCommands(array(
                new \CiBoulette\Tools\Command\EncryptPasswordCommand()
        ));
    }
}