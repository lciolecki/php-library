<?php

namespace Extlib\System;

use Extlib\System;

/**
 * Cookie system element
 *
 * @category    Extlib
 * @package     Extlib\System
 * @author      Lukasz Ciolecki <ciolecki.lukasz@gmail.com> 
 * @copyright   Copyright (c) Lukasz Ciolecki (mart)
 */
final class Cookie
{
    /* COOKIE SIMPLE EXPIRIES */
    const COOKIE_EXPIRES_ONE_HOUR = 3600;
    const COOKIE_EXPIRES_ONE_DAY = 86400;
    const COOKIE_EXPIRES_ONE_WEEK = 604800;
    const COOKIE_EXPIRES_ONE_MONTH = 2592000;
    const COOKIE_EXPIRES_ONE_YEAR = 31104000;

    /**
     * Option cookie: namespace
     *  
     * @var string
     */
    protected $namespace = 'system';

    /**
     * Option cookie: lifetime
     *
     * @var string 
     */
    protected $lifetime = self::COOKIE_EXPIRES_ONE_YEAR;

    /**
     * Option cookie: path
     *
     * @var cookie
     */
    protected $path = null;

    /**
     * Option cookie: domain
     *
     * @var string
     */
    protected $domain = null;

    /**
     * Option cookie: secure
     *
     * @var boolean
     */
    protected $secure = false;

    /**
     * Option cookie: htmlonly
     *
     * @var boolean
     */
    protected $httponly = false;

    /**
     * Instanc of cookie
     * 
     * @var stdClass 
     */
    protected $instance = null;

    /**
     * Modified time of cookie
     *
     * @var \DateTime 
     */
    protected $modifiedTime = null;

    /**
     * Current date
     * 
     * @var \DateTime
     */
    protected $date = null;

    /**
     * Instance of construct
     * 
     * @param string $namespace
     * @param int $lifetime
     * @param string $path
     * @param string $secure
     * @param string $httponly
     */
    public function __construct($namespace = null, $lifetime = self::COOKIE_EXPIRES_ONE_YEAR, $path = null, $secure = false, $httponly = false)
    {
        $this->lifetime = $lifetime;
        $this->date = System::getInstance()->getDate();

        if (null !== $namespace) {
            $this->namespace = $namespace;
        }

        if (null !== $path) {
            $this->path = $path;
        }

        if (false !== $secure) {
            $this->secure = $secure;
        }

        if (false !== $httponly) {
            $this->httponly = $httponly;
        }

        if (self::isExist($this->namespace)) {
            $this->instance = unserialize(base64_decode(self::get($this->namespace)));
        } else {
            $this->instance = new \stdClass();
        }
    }

    /**
     * Save cookie data 
     * 
     * @return \Extlib\Cookie
     */
    public function save()
    {
        $this->modifiedTime = new \DateTime('now');

        self::set(
            $this->namespace, 
            base64_encode(serialize($this->instance)), 
            $this->modifiedTime->getTimestamp() + $this->lifetime, 
            $this->path, 
            $this->domain, 
            $this->secure
        );

        return $this;
    }

    /**
     * Magic __set method, set value of propery
     * 
     * @param string $name
     * @param mixed $value
     * @return \Extlib\Cookie
     */
    public function __set($name, $value)
    {
        $this->instance->{$name} = $value;
        return $this->save();
    }

    /**
     * Magic __get, return value of property
     * 
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        if ($this->has($name)) {
            return $this->instance->{$name};
        }

        return null;
    }

    /**
     * Check is property exists
     * 
     * @param string $name
     * @return boolean
     */
    public function has($name)
    {
        return (bool) isset($this->instance->{$name});
    }

    /**
     * Proxy for setCookie function
     *
     * @param string $namespace
     * @param mixed $value
     * @param integer $expire
     * @param string $path
     * @param string $domain
     * @param boolean $secure
     */
    static function set($namespace, $value, $expire = 0, $path = null, $domain = null, $secure = false, $httponly = false)
    {
        setcookie($namespace, $value, $expire, $path, $domain, $secure, $httponly);
    }

    /**
     * Method return data from $_COOKIE by namespace
     *
     * @param string $namespace
     * @return mixed
     */
    static function get($namespace)
    {
        if (self::isExist($namespace)) {
            return $_COOKIE[$namespace];
        }

        return null;
    }

    /**
     * Clear cookie by namespace
     *
     * @param string $namespace
     */
    static function clear($namespace)
    {
        \setCookie($namespace, null, 1);
    }

    /**
     * Chceck is cookie exists
     * 
     * @param string $namespace 
     * @return boolean
     */
    static function isExist($namespace)
    {
        return isset($_COOKIE[$namespace]);
    }
}
