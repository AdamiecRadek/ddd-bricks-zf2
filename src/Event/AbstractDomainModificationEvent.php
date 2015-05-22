<?php
/**
 * @author: Radek Adamiec
 * Date: 22.05.15
 * Time: 10:53
 */

namespace AdamiecRadek\Event;

use AGmakonts\DddBricks\Entity\EntityInterface;
use AGmakonts\STL\ValueObjectInterface;

/**
 * Class AbstractDomainModificationEvent
 *
 * @package AdamiecRadek\Event
 */
abstract class AbstractDomainModificationEvent extends AbstractDomainEvent
{
    /**
     * @var \AGmakonts\STL\ValueObjectInterface
     */
    private $oldValue;

    /**
     * @var \AGmakonts\STL\ValueObjectInterface
     */
    private $newValue;

    /**
     * @param \AGmakonts\DddBricks\Entity\EntityInterface $target
     * @param \AGmakonts\STL\ValueObjectInterface         $oldValue
     * @param \AGmakonts\STL\ValueObjectInterface         $newValue
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(EntityInterface $target, ValueObjectInterface $oldValue, ValueObjectInterface $newValue)
    {

        if ($oldValue === $newValue) {
            throw new \InvalidArgumentException('There is no difference in values!');
        }

        $this->oldValue = $oldValue;
        $this->newValue = $newValue;

        parent::__construct($target);
    }

    /**
     * Get parameters passed to the event
     *
     * @return array<string,\AGmakonts\STL\ValueObjectInterface>
     */
    public function getParams()
    {
        return [
            'oldValue' => $this->oldValue(),
            'newValue' => $this->newValue(),
        ];
    }

    /**
     * @return \AGmakonts\STL\ValueObjectInterface
     */
    public function oldValue()
    {
        return $this->oldValue;
    }

    /**
     * @return \AGmakonts\STL\ValueObjectInterface
     */
    public function newValue()
    {
        return $this->newValue;
    }
}