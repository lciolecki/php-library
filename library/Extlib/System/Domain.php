<?php

namespace Extlib\System;

/**
 * Domain address system element
 *
 * @category        Extlib
 * @package         Extlib\System
 * @author          Lukasz Ciolecki <ciolecki.lukasz@gmail.com> 
 * @copyright       Copyright (c) Lukasz Ciolecki (mart)
 */
class Domain extends Url
{
    /**
     * Default domain name - localhost
     */
    const DEFAULT_DOMAIN = 'http://localhost';

    /**
     * Instance of construct
     * 
     * @param string $address
     */
    public function __construct($address = self::DEFAULT_DOMAIN)
    {
        if (null === $address && isset($_SERVER['HTTP_HOST'])) {
            $address = isset($_SERVER['HTTPS']) ? 'https:' : 'http:' . '//' . $_SERVER['HTTP_HOST'];
        }

        parent::__construct($address);
    }
}
