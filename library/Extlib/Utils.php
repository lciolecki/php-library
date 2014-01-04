<?php

namespace Extlib;

use Extlib\System\IpAddress,
    Extlib\System\Url;

/**
 * Utils class
 *
 * @category    Extlib
 * @author      Lukasz Ciolecki <ciolecki.lukasz@gmail.com> 
 * @copyright   Copyright (c) Lukasz Ciolecki (mart)
 */
final class Utils
{
    /**
     * Sign code namespace
     */
    const SIGN_NAMESPACE = 'sing';

    /**
     * Instance of ip address obejct
     * 
     * @var \Extlib\System\IpAddress
     */
    protected $ipAddress = null;

    /**
     * Instance of url address
     * 
     * @var Extlib\System\Url
     */
    protected $urlAddress = null;

    /**
     * Instance of system
     * 
     * @var \Extlib\System
     */
    protected $system = null;

    /**
     * Istance of utils object
     *
     * @var Utils 
     */
    static private $instance = null;

    /**
     * Instance of construct
     */
    private function __construct()
    {
        $this->system = \Extlib\System::getInstance();
        $this->ipAddress = new IpAddress();
        $this->urlAddress = new Url();
    }
    
    /**
     * Alias for getDomain from Extlib\System\IpAddress
     * 
     * @param string $address
     * @param boolean $scheme
     * @return string
     */
    public function getDomainUrl($address, $scheme = false)
    {
        $this->urlAddress->setAddress($address);
        return $this->urlAddress->getDomain($scheme);
    }

    /**
     * Alias for getMd5Address from Extlib\System\IpAddress
     * 
     * @param string $addres
     * @param boolean $scheme
     * @param boolean $www
     * @return string
     */
    public function getMd5Url($address, $scheme = true, $www = true)
    {
        $this->urlAddress->setAddress($address);
        return $this->urlAddress->getMd5Address($scheme, $www);
    }

    /**
     * Get instance of utils
     * 
     * @return Utils
     */
    static public function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new Utils();
        }

        return self::$instance;
    }

    /**
     * Return short text
     * 
     * @param string $text
     * @param integer $length
     * 
     * @return string
     */
    public function shortText($text, $length)
    {
        $text = trim($text);
        $charset = mb_detect_encoding($text);

        if (mb_strlen($text, $charset) > $length) {
            $text = mb_substr($text, 0, $length, $charset) . '...';
        } else {
            $text = $text;
        }

        return $text;
    }

    /**
     * Return security link for mod_secdownload lighttpd.
     * http://redmine.lighttpd.net/projects/1/wiki/Docs_ModSecDownload
     * 
     * @param string $domain
     * @param string $path
     * @param string $prefix
     * @param string $secret
     * @return string
     */
    public function generateSecurityLink($domain, $path, $prefix, $secret)
    {
        $path = trim($path, Url::SEPARATOR);
        $prefix = trim($prefix, Url::SEPARATOR);
        $domain = rtrim($domain, Url::SEPARATOR);

        $hex = sprintf("%08x", time());
        $md5 = md5($secret . $path . $hex);

        return sprintf('%s/%s/%s/%s/%s', $domain, $prefix, $md5, $hex, $path);
    }

    /**
     * Generate sample secret code for sign any request, etc..
     * 
     * @param array $params
     * @param string $secret
     * @return string
     */
    public function generateSignCode(array $params, $secret)
    {
        ksort($params);

        if (isset($params[self::SIGN_NAMESPACE])) {
            unset($params[self::SIGN_NAMESPACE]);
        }

        return md5(implode('', $params) . $secret);
    }

    /**
     * Check sign code for request
     * 
     * @param array $params
     * @param string $secret
     * @return boolean
     */
    public function checkSignCode(array $params, $secret)
    {
        if (false === isset($params[self::SIGN_NAMESPACE])) {
            return false;
        }

        return $params[self::SIGN_NAMESPACE] === $this->generateSignCode($params, $secret);
    }

    /**
     * Create "nice" date
     * 
     * @param \DateTime $date
     * @return string
     */
    public function niceDate(\DateTime $date)
    {
        $now = $this->system->getDate();

        if ($now->format('Y-m-d') === $date->format('Y-m-d')) {
            return $date->format('H:i');
        } elseif ($now->format('Y-m') === $date->format('Y-m') && $date->format('d') + 1 == $now->format('d')) {
            return sprintf($this->translate('yesterday, %s'), $date->format('H:i'));
        }

        return $date->format('d-m-Y');
    }

    /**
     * Translate function 
     * 
     * @param string $message
     * @return string
     */
    public function translate($message)
    {
        return $message;
    }

    /**
     * Count price netto from brutto by tax
     * 
     * @param double $price
     * @param int $tax
     * @return double
     * @throws \Extlib\Exception
     */
    public function priceNetto($brutto, $tax)
    {
        $tax = round((double) $tax / 100.0, 2);

        if ($tax < 0.00) {
            throw new Exception(sprintf('Tax must be greater than or equal to 0, given %s.', $tax));
        }

        if ($tax === 0.00) {
            return $brutto;
        }

        $result = $brutto / ($tax + 1);
        
        return round($result, 2, PHP_ROUND_HALF_UP);
    }
    
    /**
     * Count price butto from netto by tax
     * 
     * @param double $netto
     * @param int $tax
     * @return double
     * @throws \Extlib\Exception
     */
    public function priceBrutto($netto, $tax)
    {
        $tax = round((double) $tax / 100.0, 2);

        if ($tax < 0.00) {
            throw new Exception(sprintf('Tax must be greater than or equal to 0, given %s.', $tax));
        }
        
        if ($tax === 0.00) {
            return $netto;
        }
        
        $result = $netto * ($tax + 1);
        
        return round($result, 2, PHP_ROUND_HALF_UP);       
    }
    
    /**
     * Count quartile from collections by number quartile
     * http://www.stat.gov.pl/gus/definicje_PLK_HTML.htm?id=POJ-7498.htm
     * 
     * @param array $collections
     * @param int $number
     * @return float
     */
    public function quartile(array $collections, $number)
    {
        sort($collections);
        $cnt = count($collections);

        if ($cnt === 0) {
            return 0;
        } elseif ($cnt === 1) {
            return $collections[0];
        }

        switch ($number) {
            case 2:
                $part = (int) $cnt / 2;
                if ($cnt % 2 === 0) {
                    return ($collections[$part - 1] + $collections[$part]) / 2;
                } else {
                    return $collections[round($cnt / 2) - 1];
                }
            default:
                if ($cnt % 2 === 0) {
                    return $collections[(round($number * $cnt / 4)) - 1];
                } else {
                    return $collections[(round($number * ($cnt + 1) / 4)) - 1];
                }
                break;
        }
    }
}
