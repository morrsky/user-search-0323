<?php

declare(strict_types=1);

namespace Component\User\Infrastructure\Persistence;

use App\Domain\Model\AbstractModel;
use App\Infrastructure\Adapter\AdapterInterface;
use App\Infrastructure\Respository\RepositoryInterface;
use Component\User\Domain\Model\UserModel;

class UserRepository implements RepositoryInterface
{
    protected string $model = UserModel::class;

    protected string $table = "users";

    protected string $pKey = "id";

    public function __construct(protected AdapterInterface $adapter)
    {

    }

    public function getAdapter(): AdapterInterface
    {
        return $this->adapter;
    }

    public function fetchAll(): array
    {
        return $this->getAdapter()->select($this->table)->fetchAll(\PDO::FETCH_CLASS, $this->model);
    }

    public function fetchById(string $id): ?AbstractModel
    {
        $pkeyBind = sprintf( "%s=:%s",$this->pKey,$this->pKey);

        $user = $this->getAdapter()->select($this->table,
            [$this->pKey=>$id], $pkeyBind)
            ->fetchOne(\PDO::FETCH_CLASS,$this->model);

        return ($user)??null;
    }

    public function insert($data): ?int
    {
        $result = $this->getAdapter()->insert(
            $this->table,
            [
                "id"=>$data['id'],
                'name'=>$data['name']
            ]
        );

        return $result;
    }
}
