<?php
/**
 * @author: Radek Adamiec
 * Date: 22.05.15
 * Time: 11:03
 */

namespace AdamiecRadek\Repository\Exception;


use Exception;

/**
 * Class NoRecordFoundException
 *
 * @package Repository\Exception
 */
class NoRecordFoundException extends \RuntimeException
{
    /**
     * @param string     $message
     * @param int        $code
     * @param \Exception $previous
     */
    public function __construct($message = "No record found", $code = 404, Exception $previous = NULL)
    {
        parent::__construct($message, $code, $previous);
    }


}