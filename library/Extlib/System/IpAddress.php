<?php

namespace Extlib\System;

/**
 * Ip address system element
 *
 * @category        Extlib
 * @package         Extlib\System
 * @author          Lukasz Ciolecki <ciolecki.lukasz@gmail.com> 
 * @copyright       Copyright (c) Lukasz Ciolecki (mart)
 */
class IpAddress
{
    /**
     * Default ip address - localhost
     */
    const DEFAULT_IP_ADDRESS = '127.0.0.1';

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
        if (null === $this->address) {
            $this->detect();
        }

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
        if (!filter_var($address, FILTER_VALIDATE_IP)) {
            throw new \InvalidArgumentException("$address is not valid format of ip address.");
        }

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
        return \filter_var($this->getAddress(), FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }

    /**
     * Check if ip address is version 6
     * 
     * @return boolean
     */
    public function isIPv6()
    {
        return \filter_var($this->getAddress(), FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
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
    
    /**
     * Method detec ip address from request - default is 127.0.0.1 (localhost)
     * 
     * @return \Extlib\System\IpAddress
     */
    private function detect()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $this->address = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $this->address = trim(end(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])));
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $this->address = $_SERVER['REMOTE_ADDR'];
        } else {
            $this->address = self::DEFAULT_IP_ADDRESS;
        }

        return $this;
    }
}
