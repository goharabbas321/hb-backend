<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Facades\Module;

class SwaggerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Start fresh to remove old disabled modules
        $annotationPaths = [base_path('app')];

        // Get only enabled modules
        $modules = Module::allEnabled();

        foreach ($modules as $moduleName => $module) {
            $path = base_path("modules/{$moduleName}/app/Http/Controllers/API");

            if (is_dir($path)) {
                $annotationPaths[] = $path;
            }
        }

        // Override Swagger config dynamically
        config(['l5-swagger.documentations.default.paths.annotations' => $annotationPaths]);
    }
}
