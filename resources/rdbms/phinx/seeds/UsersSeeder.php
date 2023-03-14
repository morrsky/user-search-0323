<?php

use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
{
    const TABLE_NAME = "users";

    public function run(): void
    {
        $data = [
            [
                'id' => '8a8e519b-8768-48d9-90c0-81569d3ded9b',
                'name' => 'Matt Damon',
            ],
            [
                'id' => '68c68470-f25f-4ce4-bbf4-05f50bd82fc4',
                'name' => 'Johny Bravo',
            ],
            [
                'id' => '60bb0ca5-25d1-43bd-98e5-6a878c00a0d8',
                'name' => 'Rafael Nadal',
            ],
        ];

        $table = $this->table(self::TABLE_NAME);

        $table->insert($data)
            ->saveData();
    }
}
