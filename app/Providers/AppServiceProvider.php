<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

        use App\Channels\WhatsAppChannel;
use App\Services\WhatsAppService;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\URL;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {


    $this->app->resolving(ChannelManager::class, function ($manager) {
        $manager->extend('whatsapp', function () {
            return new WhatsAppChannel(app(WhatsAppService::class));
        });
    });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
        \URL::forceScheme('https');
    }
    }
}
