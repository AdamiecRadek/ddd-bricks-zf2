<?php
/**
 * @author: Radek Adamiec
 * Date: 22.05.15
 * Time: 10:50
 */

namespace AdamiecRadek\Event;

/**
 * Class AbstractDomainCreationEvent
 *
 * @package AdamiecRadek\Event
 */
abstract class AbstractDomainCreationEvent extends AbstractDomainEvent
{
    /**
     * @return \AGmakonts\STL\AbstractValueObject
     */
    public function targetIdentity()
    {
        return $this->getTarget()->identity();

    }

    /**
     * Get parameters passed to the event
     */
    public function getParams()
    {
        throw new \BadMethodCallException('Cannot access params in Creation event');
    }
}