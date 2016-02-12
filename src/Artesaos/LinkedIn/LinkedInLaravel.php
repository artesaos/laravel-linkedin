<?php
/**
 * Linkedin API for Laravel Framework
 *
 * @author    Mauri de Souza Nunes <mauri870@gmail.com>
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace Artesaos\LinkedIn;

use Happyr\LinkedIn\LinkedIn;

class LinkedInLaravel extends LinkedIn
{

    /**
     * LinkedInLaravel constructor.
     *
     * @param string $app_id
     * @param string $app_secret
     */
    public function __construct($app_id, $app_secret)
    {
        parent::__construct($app_id, $app_secret);
    }
}