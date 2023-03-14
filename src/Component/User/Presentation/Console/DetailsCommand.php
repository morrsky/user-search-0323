<?php

declare(strict_types=1);

namespace Component\User\Presentation\Console;

use Component\User\Application\Service\UserService;
use Component\User\Infrastructure\Persistence\UserRepository;
use Symfony\Component\Console\Output\OutputInterface;

class DetailsCommand
{
    public function __construct(protected UserService $service)
    {

    }

    public function __invoke($id, OutputInterface $output,)
    {
        $user = $this->service->getUserById($id);

        $output->writeln('<info>' . $user->getId() . '</info>');
        $output->writeln($user->getName());
    }
}