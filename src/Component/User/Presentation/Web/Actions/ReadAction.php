<?php

declare(strict_types=1);

namespace Component\User\Presentation\Web\Actions;

use Component\User\Application\Service\UserService;
use Twig\Environment;

class ReadAction
{

    public function __construct(private UserService $service, private Environment $twig)
    {

    }

    public function __invoke($id)
    {
        echo $this->twig->render('templates\details.twig', [
            'user' => $this->service->getUserById($id),
        ]);
    }
}
