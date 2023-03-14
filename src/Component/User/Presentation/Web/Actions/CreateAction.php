<?php

declare(strict_types=1);

namespace Component\User\Presentation\Web\Actions;

use Component\User\Application\Service\UserService;
use Twig\Environment;

class CreateAction
{

    public function __construct(protected UserService $service, private Environment $twig)
    {

    }

    public function __invoke()
    {
        $errorMsg=null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $result = $this->service->create($_POST);

            if( is_array($result)) {

                header('Location: /');

                exit;
            } else {
                // string with error message returned
                $errorMsg=$result;
            }
        }

        echo $this->twig->render('templates\create.twig', ['error'=>$errorMsg]);
    }
}
