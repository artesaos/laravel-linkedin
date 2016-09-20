<?php
/**
 * Linkedin API for Laravel Framework
 *
 * @author    Mauri de Souza Nunes <mauri870@gmail.com>
 * @copyright Copyright (c) 2015, Mauri de Souza Nunes <github.com/mauri870>
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace Artesaos\LinkedIn\Facades;

use Illuminate\Support\Facades\Facade;

class LinkedIn extends Facade {

    protected static function getFacadeAccessor() {
        return 'linkedin';
    }
}
