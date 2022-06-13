<?php

namespace Aytacmalkoc\LaravelCrudGenerator\Console\Commands;

use Aytacmalkoc\LaravelCrudGenerator\LaravelCrudGenerator;
use Illuminate\Console\Command;

class CrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud {name : Name of the class}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create CRUD operations';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $generator = new LaravelCrudGenerator($this->argument('name'));

        $generator->create();

        return 0;
    }
}
