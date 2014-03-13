<?php

namespace Extlib\Http;

/**
 * Http response class from http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
 *
 * @category    Extlib
 * @author      Lukasz Ciolecki <ciolecki.lukasz@gmail.com> 
 * @copyright   Copyright (c) Lukasz Ciolecki (mart)
 */
class Response
{
    // Informational 1xx
    const CODE_CONTINUE = 100;
    const CODE_SWITCHING_PROTOCOLS = 101;
    const CODE_PROCESSING = 102;
    
    // Success 2xx
    const CODE_OK = 200;
    const CODE_CREATED = 201;
    const CODE_ACCEPTED = 202;
    const CODE_NONAUTHORITATIVE_INFORMATION = 203;
    const CODE_NO_CONTENT = 204;
    const CODE_RESET_CONTENT = 205;
    const CODE_PARTIAL_CONTENT = 206;
    const CODE_MULTI_STATUS = 207;
    const CODE_ALREADY_REPORTED = 208;
    const CODE_IM_USED = 226;
    
    // Redirection 3xx
    const CODE_MULTIPLE_CHOICES = 300;
    const CODE_MOVED_PERMANENTLY = 301;
    const CODE_FOUND = 302;
    const CODE_SEE_OTHER = 303;
    const CODE_NOT_MODIFIED = 304;
    const CODE_USE_PROXY = 305;
    const CODE_SWITCH_PROXY = 306;
    const CODE_TEMPORARY_REDIRECT = 307;
    const CODE_PERMANENT_REDIRECT = 308;
    
    // Client Error 4xx
    const CODE_BAD_REQUEST = 400;
    const CODE_UNAUTHORIZED = 401;
    const CODE_PAYMENT_REQUIRED = 402;
    const CODE_FORBIDDEN = 403;
    const CODE_NOT_FOUND = 404;
    const CODE_METHOD_NOT_ALLOWED = 405;
    const CODE_NOT_ACCEPTABLE = 406;
    const CODE_PROXY_AUTHENTICATION_REQUIRED = 407;
    const CODE_REQUEST_TIMEOUT = 408;
    const CODE_CONFLICT = 409;
    const CODE_GONE = 410;
    const CODE_LENGTH_REQUIRED = 411;
    const CODE_PRECONDITION_FAILED = 412;
    const CODE_REQUEST_ENTITY_TOO_LARGE = 413;
    const CODE_REQUEST_URI_TOO_LONG = 414;
    const CODE_UNSUPORTED_MEDIA_TYPE = 415;
    const CODE_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const CODE_EXPECTATION_FAILED = 417;
    
    // Server Error 5xx
    const CODE_INTERNAL_SERVER_ERROR = 500;
    const CODE_NOT_IMPLEMENTED = 501;
    const CODE_BAD_GATWAY = 502;
    const CODE_SERVICE_UNAVAILABLE = 503;
    const CODE_GATEWAY_TIMEOUT = 504;
    const CODE_HTTP_VERSION_NOT_SUPPORTED = 505;
    const CODE_VARIANT_ALSO_NEGOTIATES = 506;
    const CODE_INSUFFICIENT_STORAGE = 507;
    const CODE_LOOP_DETECTED = 508;
    const CODE_BANDWIDTH_LIMIT_EXCEEDED = 509;
    const CODE_NOT_EXTENDED = 510;
    const CODE_NETWORK_AUTHENTICATION = 511;
    const CODE_ORIGIN_ERROR = 520;
    const CODE_CONNECTION_TIME_OUT = 522;
    const CODE_PROXY_DECLINED_REQUEST = 523;
    const CODE_A_TIMEOUT_OCCURED = 524;
    const CODE_NETWORK_READ_TIMEOUT_ERROR = 598;
    const CODE_NETWORK_CONNECT_TIMEOUT_ERROR = 599;

    static public $messages = array(
        self::CODE_CONTINUE => 'Continue',
        self::CODE_SWITCHING_PROTOCOLS => 'Switching Protocols',
        self::CODE_PROCESSING => 'Processing',
        self::CODE_OK => 'OK',
        self::CODE_CREATED => 'Created',
        self::CODE_ACCEPTED => 'Accepted',
        self::CODE_NONAUTHORITATIVE_INFORMATION => ' Non-Authoritative Information',
        self::CODE_NO_CONTENT => 'No Content',
        self::CODE_RESET_CONTENT => 'Reset Content',
        self::CODE_PARTIAL_CONTENT => 'Partial Content',
        self::CODE_MULTI_STATUS => 'Multi-Status',
        self::CODE_ALREADY_REPORTED => 'Already Reported',
        self::CODE_IM_USED => 'IM Used',
        self::CODE_MULTIPLE_CHOICES => 'Multiple Choices',
        self::CODE_MOVED_PERMANENTLY => 'Moved Permanently',
        self::CODE_FOUND => 'Found',
        self::CODE_SEE_OTHER => 'See Other',
        self::CODE_NOT_MODIFIED => 'Not Modified',
        self::CODE_USE_PROXY => 'Use Proxy',
        self::CODE_SWITCH_PROXY => 'Switch Proxy',
        self::CODE_TEMPORARY_REDIRECT => 'Temporary Redirect',
        self::CODE_PERMANENT_REDIRECT => 'Permanent Redirect',
        self::CODE_BAD_REQUEST => 'Bad Request',
        self::CODE_UNAUTHORIZED => 'Unauthorized',
        self::CODE_PAYMENT_REQUIRED => 'Payment Required',
        self::CODE_FORBIDDEN => 'Forbidden',
        self::CODE_NOT_FOUND => 'Not Found',
        self::CODE_METHOD_NOT_ALLOWED => 'Method Not Allowed',
        self::CODE_NOT_ACCEPTABLE => 'Not Acceptable',
        self::CODE_PROXY_AUTHENTICATION_REQUIRED => 'Proxy Authentication Required',
        self::CODE_REQUEST_TIMEOUT => 'Request Timeout',
        self::CODE_CONFLICT => 'Conflict',
        self::CODE_GONE => 'Gone',
        self::CODE_LENGTH_REQUIRED => 'Length Required',
        self::CODE_PRECONDITION_FAILED => 'Precondition Failed',
        self::CODE_REQUEST_ENTITY_TOO_LARGE => 'Request Entity Too Large',
        self::CODE_REQUEST_URI_TOO_LONG => 'Request-URI Too Long',
        self::CODE_UNSUPORTED_MEDIA_TYPE => 'Unsupported Media Type',
        self::CODE_REQUESTED_RANGE_NOT_SATISFIABLE => 'Requested Range Not Satisfiable',
        self::CODE_EXPECTATION_FAILED => 'Expectation Failed',
        self::CODE_INTERNAL_SERVER_ERROR => 'Internal Server Error',
        self::CODE_NOT_IMPLEMENTED => 'Not Implemented',
        self::CODE_BAD_GATWAY => 'Bad Gateway',
        self::CODE_SERVICE_UNAVAILABLE => 'Service Unavailable',
        self::CODE_GATEWAY_TIMEOUT => 'Gateway Timeout',
        self::CODE_HTTP_VERSION_NOT_SUPPORTED => 'HTTP Version Not Supported',
        self::CODE_BANDWIDTH_LIMIT_EXCEEDED => 'Bandwidth Limit Exceeded'
    );    
    
    /**
     * Get code message
     * 
     * @param int $code
     * @return string
     */
    static public function getMessage($code = self::CODE_INTERNAL_SERVER_ERROR)
    {
        if (isset(self::$messages[$code])) {
            return self::$messages[$code];
        }
        
        return self::$messages[self::CODE_INTERNAL_SERVER_ERROR];
    }
}
