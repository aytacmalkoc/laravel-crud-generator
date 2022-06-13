<?php

namespace Aytacmalkoc\LaravelCrudGenerator\Tests;

use Tests\TestCase;

class ConsoleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_make_crud_command()
    {
        $this->artisan('make:crud', ['name' => 'Test'])->assertSuccessful();
    }
}
