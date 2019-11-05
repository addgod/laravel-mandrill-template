<?php

namespace Addgod\MandrillTemplate;

use Illuminate\Support\ServiceProvider;

class MandrillTemplateServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/mandrill-template.php', 'mandrill-template');

        $this->publishes([
            __DIR__ . '/../config/mandrill-template.php' => config_path('mandrill-template.php'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MandrillTemplate::class, function () {
            return new MandrillTemplate();
        });

        $this->app->alias(MandrillTemplate::class, 'mandrill-template');
    }
}
