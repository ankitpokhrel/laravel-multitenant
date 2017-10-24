<?php

namespace App\Console\Migration;

use App\Library\Venture;

trait MigrationTrait
{
    /**
     * Set schema.
     *
     * @param string $schema
     */
    protected function connectUsingSchema(string $schema)
    {
        config(['database.connections.pgsql.schema' => $schema]);

        $this->getLaravel()['db']->purge();
    }

    /**
     * Get valid schemas from option.
     *
     * @param string $schemas
     *
     * @return array
     */
    protected function getValidSchemas(string $schemas)
    {
        $schemas = explode(',', $schemas);

        return array_intersect(Venture::ALL_VENTURES, $schemas);
    }

    /**
     * Run migrations in given ventures.
     *
     * @param array $ventures
     *
     * @return void
     */
    protected function runFor(array $ventures)
    {
        $defaultSchema = config('database.connections.pgsql.schema');

        foreach ($ventures as $venture) {
            $this->connectUsingSchema($venture);

            $this->comment("\nSchema: " . $venture);

            parent::handle();
        }

        // Reset schema.
        $this->connectUsingSchema($defaultSchema);
    }
}
