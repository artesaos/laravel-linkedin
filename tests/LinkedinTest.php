<?php

/**
 * Linkedin API for Laravel Framework
 *
 * @author    Mauri de Souza Nunes <mauri870@gmail.com>
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace Artesaos\LinkedIn\Tests;
use Artesaos\LinkedIn\Facades\LinkedIn;

class LinkedinTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function test_bindings()
    {
        $bindings = [$this->app['linkedin'], $this->app['LinkedIn']];

        foreach($bindings as $binding) {
          $this->assertInstanceOf(
              \Happyr\LinkedIn\LinkedIn::class,
              $binding
          );
        }
    }

    /**
     * @test
     */
    public function test_facade()
    {
        $this->assertEquals(
            LinkedIn::isAuthenticated(),
            false
        );
    }
}
