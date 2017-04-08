<?php
/**
 * Linkedin API for Laravel Framework
 *
 * @author    Mauri de Souza Nunes <mauri870@gmail.com>
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace Artesaos\LinkedIn;

use Http\Adapter\Guzzle6\Client;
use Illuminate\Support\ServiceProvider;
use Http\Adapter\Guzzle6\Client as HttpClient;
use Http\Message\MessageFactory\GuzzleMessageFactory as HttpGuzzleMessageFactory;

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
                __DIR__ . '/config/linkedin.php', 'linkedin'
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
        $this->app->singleton('LinkedIn', function(){
            $linkedIn = new LinkedInLaravel(config('linkedin.api_key'), config('linkedin.api_secret'));
            $linkedIn->setHttpClient(new Client());
            $linkedIn->setHttpMessageFactory(new HttpGuzzleMessageFactory());

            return $linkedIn;
        });

        $this->app->alias('LinkedIn', 'linkedin');
    }
}
