<?php

namespace ExtlibTest;

use Extlib\Utils;

/**
 * Tests for Extlib\Utils
 * 
 * @author      Lukasz Ciolecki <ciolecki.lukasz@gmail.com>
 * @copyright   Copyright (c) 2013 Lukasz Ciolecki (mart)
 */
class UtilsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Instance of construct
     */
    public function __construct($name = NULL, array $data = array(), $dataName = '')
    {
        date_default_timezone_set('Europe/Warsaw');
        parent::__construct($name, $data, $dataName);
    }

    /**
     * Tests for priceNetto method
     */
    public function testPriceNetto()
    {
        $utils = Utils::getInstance();
        
        $this->assertEquals($utils->priceNetto(123.00, 23), 100.00);
        $this->assertEquals($utils->priceNetto(133.33, 8), 123.45);
        $this->assertEquals($utils->priceNetto(146.91, 19), 123.45);
        $this->assertEquals($utils->priceNetto(146.00, 0), 146.00);
    }
    
    /**
     * Tests for priceBrutto method
     */
    public function testPriceBrutto()
    {
        $utils = Utils::getInstance();
        
        $this->assertEquals($utils->priceBrutto(100.00, 23), 123.00);
        $this->assertEquals($utils->priceBrutto(123.45, 8), 133.33);
        $this->assertEquals($utils->priceBrutto(123.45, 19), 146.91);
        $this->assertEquals($utils->priceBrutto(146.00, 0), 146.00);
    }
}
