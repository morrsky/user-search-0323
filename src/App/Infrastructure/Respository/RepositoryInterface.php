<?php

declare(strict_types=1);

namespace App\Infrastructure\Respository;

use App\Domain\Model\AbstractModel;
use App\Infrastructure\Adapter\AdapterInterface;

interface RepositoryInterface
{
    public function getAdapter(): AdapterInterface;

    public function fetchAll(): array;

    public function fetchById(string $id): ?AbstractModel;

    public function insert($data): ?int;
}
