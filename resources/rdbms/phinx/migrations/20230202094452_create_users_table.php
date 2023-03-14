<?php


use Phinx\Migration\AbstractMigration;

final class CreateUsersTable extends AbstractMigration
{
    public const TABLE_NAME = "users";

    public function up(): void
    {
        $this->table(self::TABLE_NAME)->drop()->save();

        // Define table name and columns for the primary key
        $table = $this->table(self::TABLE_NAME, ['id' => false, 'primary_key' => ['id']]);

        // Set table columns
        $table->addColumn('id', 'uuid', ['limit' => 64, 'null' => false])
            ->addColumn('name', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP']);

        // Add timestamps
        $table->addTimestamps('created_at', false, true);

        // Add indexes
        $table->addIndex('name', ['type' => 'index', 'unique' => false]);

        // Save table structure
        $table->save();
    }
}
