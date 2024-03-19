<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:reinitialize-project',
    description: 'Add a short description for your command',
)]
class InitProjectCommand extends Command
{

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        //Remove the database
        $command = $this->getApplication()?->find('d:d:d');
        $arguments = [
            '--force'  => true,
        ];
        $commandInput = new ArrayInput($arguments);
        $command->run($commandInput, $output);
        //Create the database
        $command = $this->getApplication()?->find('d:d:c');
        $command->run($input, $output);
        // Create the schema
        $command = $this->getApplication()?->find('d:s:c');
        $command->run($input, $output);

        //Load FIXTURES
        $command = $this->getApplication()?->find('d:f:l');
        $command->run($input, $output);

        // Create User Admin
        $command = $this->getApplication()?->find('a:c');
        $command->run($input, $output);

        $io->success('You have successfully initialized your project.');

        return Command::SUCCESS;
    }
}
