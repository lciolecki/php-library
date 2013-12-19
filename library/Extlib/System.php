<?php

namespace Extlib;

use Extlib\System\IpAddress,
    Extlib\System\Url;

/**
 * System class
 *
 * @category    Extlib
 * @author      Lukasz Ciolecki <ciolecki.lukasz@gmail.com> 
 * @copyright   Copyright (c) Lukasz Ciolecki (mart)
 */
final class System
{
    /**
     * Default system value
     */
    const DEFAULT_IP = '127.0.0.1';
    const DEFAULT_DOMAIN = 'http://localhost';

    /**
     * Instanc of singleton
     *
     * @var \Extlib\System 
     */
    static private $instance = null;

    /**
     * Actual time
     *
     * @var \DateTime 
     */
    protected $date = null;

    /**
     * Instance of ip address
     *
     * @var \Extlib\System\IpAddress 
     */
    protected $ipAddress = null;

    /**
     * Instance of domain
     * 
     * @var \Extlib\System\Url
     */
    protected $domain = null;

    /**
     * Instance of \Extlib\Browser
     *
     * @var \Extlib\Browser 
     */
    protected $browser = null;
    
    /**
     * Instance of super global - $this->server
     * 
     * @var array
     */
    protected $server = null;

    /**
     * Instance of construct
     */
    private function __construct()
    {
        $this->server = filter_input_array(INPUT_SERVER);
        $this->date = new \DateTime('now');

        $ipAddress = self::DEFAULT_IP;
        if (isset($this->server['HTTP_CLIENT_IP'])) {
            $ipAddress = $this->server['HTTP_CLIENT_IP'];
        } elseif (isset($this->server['HTTP_X_FORWARDED_FOR'])) {
            $ipAddress = trim(end(explode(',', $this->server['HTTP_X_FORWARDED_FOR'])));
        } elseif (isset($this->server['REMOTE_ADDR'])) {
            $ipAddress = $this->server['REMOTE_ADDR'];
        } 

        $this->setIpAddress(new IpAddress($ipAddress));

        $domain = self::DEFAULT_DOMAIN;
        if (isset($this->server['HTTP_HOST'])) {
            $domain = isset($this->server['HTTPS']) 
                    ? 'https:' : 'http:' . '//' 
                    . $this->server['HTTP_HOST'];
        } 
        
        $this->setDomain(new Url($domain));
    }

    /**
     *  Get instance of System
     * 
     * @return \Extlib\System
     */
    static public function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new System();
        }

        return self::$instance;
    }

    /**
     * Get ip address
     * 
     * @return \Extlib\System\IpAddress
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * Set ip address
     * 
     * @param \Extlib\System\IpAddress $ipAddress
     * @return \Extlib\System
     */
    public function setIpAddress(\Extlib\System\IpAddress $ipAddress)
    {
        $this->ipAddress = $ipAddress;
        return $this;
    }

    /**
     * Set date
     * 
     * @param \DateTime $date
     * @return \Extlib\System
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Get date
     * 
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set domain
     * 
     * @param \Extlib\System\Url $domain
     * @return \Extlib\System
     */
    public function setDomain(\Extlib\System\Url $domain)
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * Get domain
     * 
     * @return \Extlib\System\Url
     */
    public function getDomain()
    {
        return $this->domain;
    }
}
