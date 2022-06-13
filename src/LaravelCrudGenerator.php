<?php

namespace Aytacmalkoc\LaravelCrudGenerator;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LaravelCrudGenerator
{
    protected string $name;

    protected array $views = ['index', 'show', 'create', 'edit'];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function create()
    {
        $this->createController();
        $this->createModel();
        $this->createViews();
        $this->createRequest();
        $this->createMigration();
        $this->createObserver();
        $this->createRoute();
    }

    protected function getStub($name): bool|string
    {
        return file_get_contents(resource_path("views/laravel-crud-generator/stubs/{$name}.stub"));
    }

    protected function createTemplate(array $find, array $replace, string $stubName): string
    {
        return str_replace($find, $replace, $this->getStub($stubName));
    }

    protected function createController(): void
    {
        $template = $this->createTemplate(
            [
                '{{className}}',
                '{{classNameLower}}'
            ],
            [
                $this->name,
                strtolower($this->name)
            ],
            'Controller'
        );

        file_put_contents(app_path("Http/Controllers/{$this->name}Controller.php"), $template);
    }

    protected function createModel(): void
    {
        $template = $this->createTemplate(
            [
                '{{className}}',
            ],
            [
                $this->name,
            ],
            'Model'
        );

        file_put_contents(app_path("Models/{$this->name}.php"), $template);
    }

    protected function createViews(): void
    {
        $path = resource_path('views/') . strtolower($this->name);
        $template = $this->getStub('View');

        foreach ($this->views as $view)
        {
            if (!file_exists($path))
            {
                mkdir($path);
            }

            file_put_contents("{$path}/{$view}.blade.php", $template);
        }
    }

    protected function createRequest(): void
    {
        $template = $this->createTemplate(
            [
                '{{className}}',
            ],
            [
                $this->name,
            ],
            'Request'
        );

        $path = app_path('Http/Requests');

        if (!file_exists($path))
        {
            mkdir($path, 0777);
        }

        file_put_contents("$path/{$this->name}Request.php", $template);
    }

    protected function createMigration(): void
    {
        $plural = Str::plural(strtolower($this->name));

        Artisan::call("make:migration create_{$plural}_table --create");
        Artisan::call("make:factory {$this->name}Factory");
        Artisan::call("make:seeder {$this->name}Seeder");
    }

    protected function createObserver(): void
    {
        $template = $this->createTemplate(
            [
                '{{className}}',
                '{{classNameLower}}'
            ],
            [
                $this->name,
                strtolower($this->name)
            ],
            'Observer'
        );

        $path = app_path("Observers");

        if (!file_exists($path))
        {
            mkdir($path, 0777);
        }

        file_put_contents("{$path}/{$this->name}Observer.php", $template);
    }

    protected function createRoute()
    {
        $name = strtolower($this->name);
        $controller = 'App\Http\Controllers\\' . $this->name . 'Controller::class';

        $route = "Route::resource('/{$name}', $controller);";

        File::append(base_path('routes/web.php'), $route);
    }
}
