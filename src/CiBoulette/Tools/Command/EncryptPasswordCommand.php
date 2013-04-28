<?php

namespace CiBoulette\Tools\Command;

use Symfony\Component\Console\Command\Command;

use Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;

class EncryptPasswordCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('admin:encrypt-password')
            ->setDescription('Returns th encrypted version from a plaintext password')
            ->setDefinition(array(
                    new InputArgument(
                            'password', InputArgument::REQUIRED, 'The password to encrypt')))
            ->setHelp('Returns the encrypted password from a plaintext password');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $encoder = $this->getHelper('encoder')->getEncoder();

        $plaintext = $input->getArgument('password');

        $output->writeln('Encrypted password :');
        $output->writeln($encoder->encodePassword($plaintext, ''));
    }
}