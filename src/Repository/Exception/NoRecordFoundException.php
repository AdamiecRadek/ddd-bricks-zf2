<?php

/**
 * @author: Radek Adamiec
 * Date: 22.05.15
 * Time: 11:03
 */

namespace AdamiecRadek\DDDBricksZF2\Repository\Exception;

use Exception;

/**
 * Class NoRecordFoundException.
 */
class NoRecordFoundException extends \RuntimeException
{
    /**
     * @param string     $message
     * @param int        $code
     * @param \Exception $previous
     */
    public function __construct($message = 'No record found', $code = 404, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
