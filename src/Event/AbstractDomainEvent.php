<?php
/**
 * @author: Radek Adamiec
 * Date: 22.05.15
 * Time: 10:45
 */

namespace AdamiecRadek\Event;


use AGmakonts\DddBricks\Entity\EntityInterface;
use AGmakonts\STL\DateTime\DateTime;
use AGmakonts\STL\String\String;
use Rhumsaa\Uuid\Uuid;
use Zend\EventManager\EventInterface;

/**
 * Class AbstractDomainEvent
 *
 * @package AdamiecRadek\Event
 */
abstract class AbstractDomainEvent implements EventInterface, DomainEventInterface
{
    /**
     * @var \AGmakonts\DddBricks\Entity\EntityInterface
     */
    private $target;

    /**
     * @var boolean
     */
    private $propagationIsStopped;

    /**
     * @var \AGmakonts\STL\Number\Integer
     */
    private $occurrenceTime;

    /**
     * @var \AGmakonts\STL\String\String
     */
    private $identifier;


    /**
     * @param \AGmakonts\DddBricks\Entity\EntityInterface $target
     */
    public function __construct(EntityInterface $target)
    {
        $this->target         = $target;
        $this->occurrenceTime = DateTime::get();
        $this->identifier     = String::get(Uuid::uuid4()->toString());
    }


    /**
     * @return \AGmakonts\STL\Number\Integer
     */
    public function occurrenceTime()
    {
        return $this->occurrenceTime;

    }

    /**
     * @return \AGmakonts\STL\String\String
     */
    public function identifier()
    {
        return $this->identifier;

    }


    /**
     * Get target/context from which event was triggered
     *
     * @return \AGmakonts\DddBricks\Entity\EntityInterface
     */
    public function getTarget()
    {
        return $this->target;
    }


    /**
     * Set the event name
     *
     * @param  string $name
     *
     * @return NoType
     */
    final public function setName($name)
    {
        throw new \BadMethodCallException('Cannot change domain event name');
    }

    /**
     * Set the event target/context
     *
     * @param  null|string|object $target
     *
     * @return NoType
     */
    final public function setTarget($target)
    {
        throw new \BadMethodCallException('Cannot change domain event target');
    }


    /**
     * Set event parameters
     *
     * @param  string $params
     *
     * @return NoType
     */
    final public function setParams($params)
    {
        throw new \BadMethodCallException('Cannot change domain event params');
    }

    /**
     * Set a single parameter by key
     *
     * @param  string $name
     * @param  mixed  $value
     *
     * @return NoType
     */
    final public function setParam($name, $value)
    {
        throw new \BadMethodCallException('Cannot change domain event param');
    }

    /**
     * Get a single parameter by name
     *
     * @param  string $name
     * @param  mixed  $default Default value to return if parameter does not exist
     *
     * @return NoType
     */
    final public function getParam($name, $default = NULL)
    {
        throw new \BadMethodCallException('Cannot get domain event params individually');
    }

    /**
     * Indicate whether or not the parent EventManagerInterface should stop propagating events
     *
     * @param  bool $flag
     *
     * @return NoType
     */
    public function stopPropagation($flag = TRUE)
    {
        $this->propagationIsStopped = $flag;
    }

    /**
     * Has this event indicated event propagation should stop?
     *
     * @return bool
     */
    public function propagationIsStopped()
    {
        return $this->propagationIsStopped;
    }

    /**
     * Get event name
     *
     * @return string
     */
    public function getName()
    {
        return static::eventName();
    }

}