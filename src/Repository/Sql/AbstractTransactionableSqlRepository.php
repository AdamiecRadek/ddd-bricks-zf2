<?php

/**
 * @author: Radek Adamiec
 * Date: 22.05.15
 * Time: 11:06
 */

namespace AdamiecRadek\DDDBricksZF2\Repository\Sql;

use AGmakonts\DddBricks\Repository\TransactionableRepository;

/**
 * Class AbstractTransactionableSqlRepository.
 */
abstract class AbstractTransactionableSqlRepository extends AbstractSqlRepository implements TransactionableRepository
{
    /**
     * Determines whether or not transaction is enabled.
     *
     * @var bool
     */
    protected $transactionStarted = false;

    /**
     * Begin transaction.
     *
     * @return mixed
     */
    public function beginTransaction()
    {
        try {
            $this->dbAdapter->getDriver()->getConnection()->beginTransaction();
            $this->transactionStarted = true;
        } catch (\Exception $exception) {
            // silence
        }
    }

    /**
     * Finish transaction and commit changes.
     *
     * @return mixed
     */
    public function commitTransaction()
    {
        if (true === $this->transactionStarted) {
            $this->dbAdapter->getDriver()->getConnection()->commit();
            $this->transactionStarted = false;
        }
    }

    /**
     * Finish transaction and rollback changes.
     *
     * @return mixed
     */
    public function rollbackTransaction()
    {
        if (true === $this->transactionStarted) {
            $this->dbAdapter->getDriver()->getConnection()->rollback();
            $this->transactionStarted = false;
        }
    }
}
