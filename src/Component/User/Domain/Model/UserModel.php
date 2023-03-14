<?php

declare(strict_types=1);

namespace Component\User\Domain\Model;

use App\Domain\Model\AbstractModel;

class UserModel extends AbstractModel
{
    private $id;

    private $name;

    public function __construct()
    {

    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

}
