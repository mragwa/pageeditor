<?php

namespace AnywhereMedia\PageEditor;

use Illuminate\Support\ServiceProvider;
use Illuminate\Events\Dispatcher;
use TCG\Voyager\Facades\Voyager;

class PageEditorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'pageeditor');
        Voyager::addAction(Actions\PageEditor::class);
        include __DIR__.'/Routes/routes.php';

        $this->strapMigrations();
    }

    protected function strapMigrations()
    {
        // Load migrations
        $this->loadMigrationsFrom(__DIR__. '/Migrations');
    }
}
