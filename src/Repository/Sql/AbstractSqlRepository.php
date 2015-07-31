<?php

/**
 * @author: Radek Adamiec
 * Date: 22.05.15
 * Time: 10:59
 */

namespace AdamiecRadek\DDDBricksZF2\Repository\Sql;

use AdamiecRadek\DDDBricksZF2\Repository\Exception\NoRecordFoundException;
use AdamiecRadek\DDDBricksZF2\Repository\Sql\Exception\InvalidConfigProvidedException;
use AGmakonts\DddBricks\Repository\AbstractRepository;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

/**
 * Class AbstractSqlRepository.
 */
abstract class AbstractSqlRepository extends AbstractRepository
{
    /**
     * @var \Zend\Db\Adapter\Adapter
     */
    protected $dbAdapter;

    /**
     * @var \Zend\Db\Sql\Sql
     */
    protected $sql;

    /**
     * @param array $config
     */
    protected function __construct(array $config = null)
    {
        if (false === $this->checkConfigForConstructor($config)) {
            throw new InvalidConfigProvidedException();
        }
        $this->setDatabaseProperties($config);
    }

    /**
     * @param       $where
     * @param array $options
     *
     * @throws NoRecordFoundException
     *
     * @return \SplObjectStorage
     */
    protected function getEntitiesByWhere($where = null, array $options = array())
    {
        $select = $this->getSelect();

        if (null !== $where) {
            $select->where($where);
        }

        $statement = $this->getSql()->prepareStatementForSqlObject($select);
        $result = $statement->execute(
            $options
        );

        if ($result->count() === 0) {
            throw new NoRecordFoundException();
        }
        $entitiesSplObjectStorage = $this->processResult($result);
        $entitiesSplObjectStorage->rewind();

        return $entitiesSplObjectStorage;
    }

    /**
     * @param null  $where
     * @param array $options
     *
     * @return bool
     */
    protected function checkIfEntityExists($where = null, array $options = array())
    {
        $select = $this->getSelectForEntityCheck();
        if (null !== $where) {
            $select->where($where);
        }

        $statement = $this->getSql()->prepareStatementForSqlObject($select);
        $result = $statement->execute(
            $options
        );

        if ($result->count() === 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return Select
     */
    abstract protected function getSelectForEntityCheck();

    /**
     * @return Select
     */
    abstract protected function getSelect();

    /**
     * @return Sql
     */
    protected function getSql()
    {
        return $this->sql;
    }

    /**
     * @param \Zend\Db\Adapter\Driver\ResultInterface $results
     *
     * @return \SplObjectStorage
     */
    abstract protected function processResult(ResultInterface $results);

    /**
     * @param array $config
     *
     * @return bool
     */
    protected function checkConfigForConstructor(array $config = array())
    {
        return (true === (count($config) > 0) &&
            true === $config[0] instanceof Adapter);
    }

    /**
     * @param array $config
     */
    protected function setDatabaseProperties(array $config = null)
    {
        $this->dbAdapter = $config[0];

        $this->sql = new Sql($this->dbAdapter);
    }
}
