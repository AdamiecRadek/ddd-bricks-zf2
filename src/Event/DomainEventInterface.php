<?php
/**
 * @author: Radek Adamiec
 * Date: 22.05.15
 * Time: 10:46
 */

namespace AdamiecRadek\Event;


/**
 * Interface DomainEventInterface
 *
 * @package AdamiecRadek\Event
 */
interface DomainEventInterface
{
    /**
     * @return string
     */
    public static function eventName();
}