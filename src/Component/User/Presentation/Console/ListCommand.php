<?php

declare(strict_types=1);

namespace Component\User\Presentation\Console;

use Component\User\Application\Service\UserService;
use Component\User\Infrastructure\Persistence\UserRepository;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand
{
    public function __construct(protected UserService $service)
    {

    }

    public function __invoke(OutputInterface $output,)
    {
        $output->writeln('<comment>List of users:</comment>');

        $users = $this->service->getUsers();

        foreach ($users as $user) {
            $output->writeln(sprintf(
                'User #%s: <info>%s</info>',
                $user->getId(),
                $user->getName()
            ));
        }
    }
}