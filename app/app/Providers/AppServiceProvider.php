<?php

namespace App\Providers;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->bindSearchClient();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
    private function bindSearchClient()
    {
        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHttpClient(new HttpClient(['verify' => false ]))
                ->build();
        });
    }
}
