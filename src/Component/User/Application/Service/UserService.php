<?php

declare(strict_types=1);

namespace Component\User\Application\Service;

use Assert\Assertion;
use Component\User\Infrastructure\Persistence\UserRepository;
use Ramsey\Uuid\Uuid;

class UserService
{

    public function __construct(protected UserRepository $repository)
    {

    }

    public function getUsers()
    {
        return $this->repository->fetchAll();
    }


    public function getUserById($id)
    {
        return $this->repository->fetchById($id);
    }

    public function create($data)
    {
        $data = $this->sanitizeData($data);
        $data = $this->validateData($data);

        if(is_string($data)) {
            return $data;
        }

        $data = [
            'id' => Uuid::uuid4()->toString(),
            'name'=>$data['user_name']
        ];

        $result = $this->repository->insert($data);

        return $data;
    }
    protected function sanitizeData($input)
    {
        $data['user_name'] = filter_var($input['user_name'], FILTER_SANITIZE_ENCODED);

        return $data;
    }

    protected function validateData($inputData)
    {
        try {
            Assertion::minLength($inputData['user_name'],3);
            Assertion::string($inputData['user_name']);
        } catch(\Assert\AssertionFailedException $e) {
            return $e->getMessage();
        }

        return $inputData;
    }

}
