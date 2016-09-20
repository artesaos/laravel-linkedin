<?php

namespace Artesaos\LinkedIn\Tests;

use Orchestra\Testbench\TestCase;
use Artesaos\LinkedIn\LinkedinServiceProvider;
use Artesaos\LinkedIn\Facades\LinkedIn;

abstract class AbstractTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
      return [LinkedinServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'LinkedIn' => LinkedIn::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('linkedin.api_key', 'yourapikey');
        $app['config']->set('linkedin.api_secret', 'yourapisecret');
    }
}
