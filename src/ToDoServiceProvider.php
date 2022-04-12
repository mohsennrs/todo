<?php

namespace Hattori\ToDo;
use Illuminate\Support\ServiceProvider;

class ToDoServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {

        // $this->publishes([
        //     __DIR__.'/Config/todo.php' => config_path('todo.php'),
        // ]);

        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadFactoriesFrom(__DIR__.'/Database/factories');
        $this->loadRoutesFrom(__DIR__.'/Routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        // $this->mergeConfigFrom(__DIR__.'/Config/todo.php', 'todo.php');

        // Register the service the package provides.
        

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        // $this->publishes([
        //     __DIR__.'/Config/todo.php' => config_path('todo.php'),
        // ], 'todo.config');

    }
}
