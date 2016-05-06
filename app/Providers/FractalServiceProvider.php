<?php
/**
 * Created by tav0
 * Date: 5/05/16
 * Time: 11:51 AM
 */

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

class FractalServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('League\Fractal\Manager', function($app) {
            $fractal = new \League\Fractal\Manager;

            $serializer = new \League\Fractal\Serializer\ArraySerializer;

            $fractal->setSerializer($serializer);

            return $fractal;
        });

        $this->app->bind('Dingo\Api\Transformer\Adapter\Fractal', function($app) {
            $fractal = $app->make('\League\Fractal\Manager');

            return new \Dingo\Api\Transformer\Adapter\Fractal($fractal);
        });
    }
}