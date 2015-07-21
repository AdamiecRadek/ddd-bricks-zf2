<?php
/**
 * @author: Radek Adamiec
 * Date: 22.05.15
 * Time: 11:00
 */

namespace AdamiecRadek\DDDBricksZF2\Repository\Sql\Exception;


use Exception;

/**
 * Class InvalidConfigProvidedException
 *
 * @package AdamiecRadek\Repository\Sql\Exception
 */
class InvalidConfigProvidedException extends \InvalidArgumentException
{
    /**
     * @param string     $message
     * @param int        $code
     * @param \Exception $previous
     */
    public function __construct($message = "You need to provide valid config for this repository", $code = 500,
                                Exception $previous = NULL)
    {
        parent::__construct($message, $code, $previous);
    }

}