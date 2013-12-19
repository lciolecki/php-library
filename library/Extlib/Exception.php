<?php

namespace Extlib;

/**
 * Exception class
 *
 * @category    Extlib
 * @author      Lukasz Ciolecki <ciolecki.lukasz@gmail.com> 
 * @copyright   Copyright (c) Lukasz Ciolecki (mart)
 */
class Exception extends \Exception
{
    /**
     * Exceptions details
     * 
     * @var mixed
     */
    protected $details = nulll;

    /**
     * Instance of construct
     * 
     * @param stroing $message
     * @param int $code
     * @param \Exception $previous
     * @param mixed $details
     */
    public function __construct($message, $code = 500, \Exception $previous = null, $details = null)
    {
        if (null !== $details) {
            $this->details = $details;
        }

        parent::__construct($message, $code, $previous);
    }

    /**
     * Method return exception details
     * 
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Method set exception details
     * 
     * @param mixed $details
     * @return \Extlib\Exception
     */
    public function setDetails($details)
    {
        $this->details = $details;
        return $this;
    }
}
