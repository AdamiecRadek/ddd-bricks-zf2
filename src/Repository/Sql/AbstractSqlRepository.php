<?php
/**
 * @author: Radek Adamiec
 * Date: 22.05.15
 * Time: 10:59
 */

namespace AdamiecRadek\Repository\Sql;


use AdamiecRadek\Repository\Exception\NoRecordFoundException;
use AdamiecRadek\Repository\Sql\Exception\InvalidConfigProvidedException;
use AGmakonts\DddBricks\Repository\AbstractRepository;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

/**
 * Class AbstractSqlRepository
 *
 * @package AdamiecRadek\Repository\Sql
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
    protected function __construct(array $config = NULL)
    {
        if (FALSE === $this->checkConfigForConstructor($config)) {

            throw new InvalidConfigProvidedException();
        }
        $this->setDatabaseProperties($config);
    }

    /**
     * @param       $where
     * @param array $options
     *
     * @return \SplObjectStorage
     * @throws NoRecordFoundException
     */
    protected function getEntitiesByWhere($where = NULL, array $options = [])
    {
        $select = $this->getSelect();

        if (NULL !== $where) {
            $select->where($where);
        }

        $statement = $this->getSql()->prepareStatementForSqlObject($select);
        $result    = $statement->execute(
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
    protected function checkIfEntityExists($where = NULL, array $options = [])
    {
        $select = $this->getSelectForEntityCheck();
        if (NULL !== $where) {
            $select->where($where);
        }

        $statement = $this->getSql()->prepareStatementForSqlObject($select);
        $result    = $statement->execute(
            $options
        );

        if ($result->count() === 0) {
            return FALSE;
        } else {
            return TRUE;
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
        return (TRUE === (count($config) > 0) &&
            TRUE === $config[0] instanceof Adapter);
    }

    /**
     * @param array $config
     */
    protected function setDatabaseProperties(array $config = NULL)
    {
        $this->dbAdapter = $config[0];

        $this->sql = new Sql($this->dbAdapter);
    }
}