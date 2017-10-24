<?php

namespace App\Console\Migration;

use App\Library\Venture;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Database\Console\Migrations\MigrateCommand as BaseMigrateCommand;

class MigrateCommand extends BaseMigrateCommand
{
    use MigrationTrait;

    public function __construct(Migrator $migrator)
    {
        $this->signature .= "
                {--all : Run migrations in all available schemas.}
                {--schema= : Run migrations in given schemas.}
        ";

        parent::__construct($migrator);
    }

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        if ($this->option('all')) {
            $this->runFor(Venture::ALL_VENTURES);
        } elseif ($schemas = $this->option('schema')) {
            $this->runFor($this->getValidSchemas($schemas));
        } else {
            parent::handle();
        }
    }
}
