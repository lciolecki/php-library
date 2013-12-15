<?php

namespace ExtlibTest\System;

use Extlib\System\IpAddress;

/**
 * Tests for Extlib\System\IpAddress
 * 
 * @author      Lukasz Ciolecki <ciolecki.lukasz@gmail.com>
 * @copyright   Copyright (c) 2013 Lukasz Ciolecki (mart)
 */
class IpAddressTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test method
     */
    public function test()
    {
        //Valid data
        $valid = new IpAddress();
        try {
            $valid->setAddress('158.90.157.102');
        } catch (\InvalidArgumentException $ex) {
            
        }

        $this->assertTrue($valid->getAddress() === '158.90.157.102');

        //Invalid data thorw Exception, get method return base ip address - localhost
        $invalid = new IpAddress();
        try {
            $invalid->setAddress('158.90.157.131.0');
        } catch (\InvalidArgumentException $ex) {
            $this->assertTrue($invalid->getAddress() === IpAddress::DEFAULT_IP_ADDRESS);
        }

        //Checking ip address: is v4, v6, equals another object IpAddress
        $ip = new IpAddress('192.168.1.1 ');
        $this->assertEquals(true, $ip->isIPv4());
        $this->assertEquals(false, $ip->isIPv6());
        $this->assertEquals(true, $ip->equals(new IpAddress('192.168.1.1')));
        $this->assertEquals(false, $ip->equals(new IpAddress('158.90.157.102')));
    }
}
