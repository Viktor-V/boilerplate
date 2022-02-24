<?php

namespace Ui\Cli\Command;

use App\Admin\Application\UseCase\Command\Create\CreateCommand;
use App\Common\Application\Command\CommandBusInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

#[AsCommand(
    name: self::COMMAND_NAME,
    description: self::COMMAND_DESCRIPTION
)]
class CreateBackofficeAdminCommand extends Command
{
    private const COMMAND_NAME = 'backoffice:admin:create';
    private const COMMAND_DESCRIPTION = 'Create backoffice admin';

    public function __construct(
        private CommandBusInterface $bus,
        string $name = self::COMMAND_NAME
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Admin email')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $password = $io->askHidden('Please enter admin password');

            $this->bus->dispatch(new CreateCommand(
                Uuid::uuid4()->toString(),
                $input->getArgument('email'),
                (string) $password
            ));
        } catch (Throwable $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        }

        $io->success('Admin successful created.');

        return Command::SUCCESS;
    }
}
