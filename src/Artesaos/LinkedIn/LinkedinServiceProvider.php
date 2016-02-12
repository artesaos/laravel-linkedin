<?php
/**
 * Linkedin API for Laravel Framework
 *
 * @author    Mauri de Souza Nunes <mauri870@gmail.com>
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace Artesaos\LinkedIn;

use Illuminate\Support\ServiceProvider;

class LinkedinServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        //Publish config file
        if(function_exists('config_path')){
            //If is not a Lumen App...
            $this->publishes([
                __DIR__ . '/config/linkedin.php' => config_path('linkedin.php'),
            ]);

            $this->mergeConfigFrom(
                __DIR__ . '/config/linkedin.php','linkedin'
            );
        }
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //Bind the facade and pass api construct parameters
        $this->app->bind('LinkedIn', function(){
            $api_key = config('linkedin.api_key');
            $api_secret = config('linkedin.api_secret');

            return new LinkedInLaravel($api_key, $api_secret);
        });
    }
}