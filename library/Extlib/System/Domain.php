<?php

namespace Extlib\System;

/**
 * Url address system element
 *
 * @category        Extlib
 * @package         Extlib\System
 * @author          Lukasz Ciolecki <ciolecki.lukasz@gmail.com> 
 * @copyright       Copyright (c) Lukasz Ciolecki (mart)
 */
class Url
{
    /**
     * Url address
     * 
     * @var string 
     */
    protected $address = null;

    /**
     * Arra of elements from parse_url method
     * 
     * @var array
     */
    protected $parse = array();
    
    /**
     * Return string representation of url address
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getAddress();
    }

    /**
     * Instance of construct
     * 
     * @param string $address
     */
    public function __construct($address)
    {
        $this->setAddress($address);
    }

    /**
     * Return url address 
     * 
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set url address
     * 
     * @param string $address
     * @return \Extlib\System\Url
     */
    public function setAddress($address)
    {
        if (!filter_var($address, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException("$address is not valid format of url address.");
        }

        $this->address = $address;
        $this->parse = parse_url($address);
        return $this;
    }   

    /**
     * Compares two url address
     * 
     * @param \Extlib\System\Url $address
     * @return boolean
     */
    public function equals(Url $address)
    {
        return $this->getAddress() === $address->getAddress();
    }
}
