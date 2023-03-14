<?php

declare(strict_types=1);

namespace Component\User\Presentation\Console;

use Component\User\Infrastructure\Persistence\UserRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Output\OutputInterface;
use Component\User\Application\Service\UserService;

class CreateCommand
{
    public function __construct(protected UserService $service)
    {

    }

    public function __invoke($name, OutputInterface $output,)
    {
        $output->writeln('<comment>Create User:</comment>');

        $result = $this->service->create(['user_name'=>$name]);

        if( is_array($result)) {
            $output->writeln(sprintf("User #%s added",$result['id']));
        } else {
            // string with error message returned
            $output->writeln("There was some problem. User NOT added. " . $result);
        }


    }
}