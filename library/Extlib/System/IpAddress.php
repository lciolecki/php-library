<?php

namespace Extlib\System;

/**
 * Ip address system element
 *
 * @category    Extlib
 * @package     Extlib\System
 * @author      Lukasz Ciolecki <ciolecki.lukasz@gmail.com> 
 * @copyright   Copyright (c) Lukasz Ciolecki (mart)
 */
class IpAddress
{
    /**
     * Ip address
     * 
     * @var string 
     */
    protected $address = null;

    /**
     * Return string representation of ip address
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
    public function __construct($address = null)
    {
        if (null !== $address) {
            $this->setAddress($address);
        }
    }

    /**
     * Return ip address 
     * 
     * @param boolean $ip2long
     * @return mixed
     */
    public function getAddress($ip2long = false)
    {
        if ($ip2long) {
            return ip2long($this->address);
        }

        return $this->address;
    }

    /**
     * Set ip address
     * 
     * @param string $address
     * @return \Extlib\System\IpAddress
     */
    public function setAddress($address)
    {
        $address = trim($address);

        $this->address = $address;
        return $this;
    }
    
    /**
     * Check if ip address is version 4
     * 
     * @return boolean
     */
    public function isIPv4()
    {
        return (boolean) \filter_var($this->getAddress(), FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }

    /**
     * Check if ip address is version 6
     * 
     * @return boolean
     */
    public function isIPv6()
    {
        return (boolean) \filter_var($this->getAddress(), FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
    }
    
    /**
     * Compares two ip address
     * 
     * @param \Extlib\System\IpAddress $address
     * @return boolean
     */
    public function equals(IpAddress $address)
    {
        return $this->getAddress(true) === $address->getAddress(true);
    }

    static public function isValid($address)
    {
        if (!filter_var($address, FILTER_VALIDATE_IP)) {
            throw new \InvalidArgumentException("$address is not valid format of ip address.");
        }        
    }
}
