<?php
namespace App\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Elasticsearch\ClientBuilder as ESClientBuilder;

class ElasticsearchServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('es', function(){
            // get elasticsearch servers list
            $builder = ESClientBuilder::create()->setHosts(config('database.elasticsearch.hosts'));
            // for dev env, print the detail to logs
            if (app()->environment() === 'local') {
                $builder->setLogger(app('log')->driver());
            }
            return $builder->build();
        });
    }

    public function provides()
    {
        return [ESClientBuilder::class];
    }
}
