<?php

namespace Extlib\System;

/**
 * Url address system element
 *
 * @category    Extlib
 * @package     Extlib\System
 * @author      Lukasz Ciolecki <ciolecki.lukasz@gmail.com> 
 * @copyright   Copyright (c) Lukasz Ciolecki (mart)
 */
class Url
{
    /**
     * Namespaces of url elements
     */
    const PARSE_SCHEME = 'scheme';
    const PARSE_HOST = 'host';
    const PARSE_PORT = 'port';
    const PARSE_USER = 'user';
    const PARSE_PASSWORD = 'pass';
    const PARSE_PATH = 'path';
    const PARSE_QUERY = 'query';
    const PARSE_FRAGMENT = 'fragment';
    
    /**
     * Url separator
     */
    const SEPARATOR = '/';
    
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
    public function __construct($address = null)
    {
        if (null !== $address) {
            $this->setAddress($address);
        }
    }

    /**
     * Return url address
     * 
     * @param boolean $scheme
     * @param boolean $www
     * @return string
     */
    public function getAddress($scheme = true, $www = true)
    {
        return $this->normalize($scheme, $www);
    }

    /**
     * Set url address
     * 
     * @param string $address
     * @return \Extlib\System\Url
     */
    public function setAddress($address)
    {
        $address = trim($address, self::SEPARATOR);
        if (!filter_var($address, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException("$address is not valid format of url address.");
        }

        $this->address = $address;
        $this->parse = parse_url($address);
        return $this;
    }   
   
    /**
     * Get parse
     * 
     * @return array
     */
    public function getParse()
    {
        return $this->parse;
    }
    
    /**
     * Set parse
     * 
     * @param array $parse
     * @return \Extlib\System\Url
     */
    public function setParse(array $parse)
    {
        $this->parse = $parse;
        return $this;
    }
    
    /**
     * Return value from array of url elements by namespace
     * 
     * @param string $url
     * @return string | int
     */
    public function get($namespace)
    {
        if (isset($this->parse[$namespace])) {
            return $this->parse[$namespace];
        }
        
        return null;
    }
    
    /**
     * Return domain name from url 
     * 
     * @param boolean $scheme
     * @return string
     */
    public function getDomain($scheme = false)
    {
        if ($scheme) {
            return sprintf('%s.%s', $this->get(self::PARSE_SCHEME), $this->get(self::PARSE_HOST));
        }
        
        return $this->get(self::PARSE_HOST);
    }
     
    /**
     * Return normalize address url
     * 
     * @param boolean $scheme
     * @param boolean $www
     * @return string
     */
    protected function normalize($scheme = true, $www = true)
    {
        $address = $this->address;
        if ($scheme && null === $this->get(self::PARSE_SCHEME)) {
            $address = sprintf('http://%s', $this->address);
        } elseif (!$scheme && $this->get(self::PARSE_SCHEME)) {
            $address = str_replace($this->get(self::PARSE_SCHEME) . '://', '', $this->address);
        }

        if (false === $www && 0 === strpos($this->get(self::PARSE_HOST), 'www.')) {
            $address = substr($this->address, 4);
        }

        return $address;
    }
    
    /**
     * Return md5 address url
     * 
     * @param boolean $scheme
     * @param boolean $www
     * @return string
     */
    public function getMd5Address($scheme = true, $www = true)
    {
        return md5($this->normalize($scheme, $www));
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
