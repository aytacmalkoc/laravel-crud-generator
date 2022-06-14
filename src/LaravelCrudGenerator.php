<?php

namespace Aytacmalkoc\LaravelCrudGenerator;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LaravelCrudGenerator
{
    protected string $name;

    protected bool $auth;

    protected array $paths;

    protected array $views = ['index', 'show', 'create', 'edit'];

    public function __construct(string $name, bool $auth = false)
    {
        $this->name = $name;
        $this->auth = $auth;

        $this->paths = [
            'controller' => controller_path($this->name . 'Controller.php'),
            'model' => model_path($this->name . 'Model.php'),
            'request' => request_path($this->name . 'Request.php'),
            'migration' => 'create_' . strtolower($this->name) . '_table',
            'seeder' => $this->name . 'Seeder',
            'factory' => $this->name . 'Factory',
            'observer' => observer_path($this->name . 'Observer')
        ];
    }

    public function create()
    {
        $this->createController();
        $this->createModel();
        $this->createViews();
        $this->createRequest();
        $this->createObserver();
        $this->createMigration();
        $this->createRoute();
    }

    protected function getStub($name): bool|string
    {
        return file_get_contents(__DIR__ . "/stubs/{$name}.stub");
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

        file_put_contents($this->paths['controller'], $template);
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

        file_put_contents($this->paths['model'], $template);
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
                '{{auth}}'
            ],
            [
                $this->name,
                $this->auth
            ],
            'Request'
        );

        if (!file_exists(request_path()))
        {
            mkdir(request_path(), 0777);
        }

        file_put_contents($this->paths['request'], $template);
    }

    protected function createMigration(): void
    {
        $plural = Str::plural(strtolower($this->name));

        Artisan::call("make:migration {$this->paths['migration']} --create");
    }

    protected function createSeeder()
    {
        Artisan::call("make:seeder {$this->paths['seeder']}");
    }

    protected function createFactory()
    {
        Artisan::call("make:factory {$this->paths['factory']}");
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

        if (!file_exists(observer_path()))
        {
            mkdir(observer_path(), 0777);
        }

        file_put_contents($this->paths['observer'], $template);
    }

    protected function createRoute()
    {
        $name = strtolower($this->name);
        $controller = 'App\Http\Controllers\\' . $this->name . 'Controller::class';

        $route = "Route::resource('/{$name}', $controller);\n";

        if ($this->auth)
        {
            $route = Str::replaceLast(";", "->middleware('auth');", $route);
        }

        File::append(base_path('routes/web.php'), $route);
    }
}
