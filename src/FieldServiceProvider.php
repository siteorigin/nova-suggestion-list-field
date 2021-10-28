<?php

namespace Siteorigin\NovaSuggestionList;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Siteorigin\NovaSuggestionList\Contracts\Suggester;
use Siteorigin\NovaSuggestionList\Suggesters\GPT3Suggester;

class FieldServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-suggestion-list', __DIR__.'/../dist/js/field.js');
            Nova::style('nova-suggestion-list', __DIR__.'/../dist/css/field.css');
        });

        $this->app->booted(function () {
            $this->routes();
        });
    }

    protected function routes()
    {
        Route::middleware(['nova'])
             ->prefix('nova-vendor/suggestion-list')
             ->group(__DIR__.'/../routes/api.php');
    }

    public function register()
    {
        $this->app->bind(Suggester::class, GPT3Suggester::class);
    }
}
