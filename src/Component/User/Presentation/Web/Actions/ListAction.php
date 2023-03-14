<?php

declare(strict_types=1);

namespace Component\User\Presentation\Web\Actions;

use Component\User\Application\Service\UserService;
use Twig\Environment;

class ListAction
{

    public function __construct(private UserService $service, private Environment $twig)
    {

    }

    public function __invoke()
    {
        echo $this->twig->render('templates\list.twig', [
            'users' => $this->service->getUsers(),
        ]);
    }
}
