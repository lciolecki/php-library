<?php

namespace ExtlibTest;

use Extlib\System;

/**
 * Tests for Extlib\System
 * 
 * @author      Lukasz Ciolecki <ciolecki.lukasz@gmail.com>
 * @copyright   Copyright (c) 2013 Lukasz Ciolecki (mart)
 */
class SystemTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test method
     */
    public function test()
    {
        date_default_timezone_set('Europe/Warsaw');
        
        $system = System::getInstance();
        $this->assertTrue($system->getIpAddress()->getAddress() === System::DEFAULT_IP);
        $this->assertTrue($system->getIpAddress()->getAddress(true) === ip2long(System::DEFAULT_IP));
    }
}
