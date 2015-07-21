<?php
/**
 * @author: Radek Adamiec
 * Date: 22.05.15
 * Time: 11:06
 */

namespace AdamiecRadek\DDDBricksZF2\Repository\Sql;


use AGmakonts\DddBricks\Repository\TransactionableRepository;

/**
 * Class AbstractTransactionableSqlRepository
 *
 * @package AdamiecRadek\Repository\Sql
 */
abstract class AbstractTransactionableSqlRepository extends AbstractSqlRepository implements TransactionableRepository
{


    /**
     * Determines whether or not transaction is enabled
     *
     * @var bool
     */
    protected $transactionStarted = FALSE;

    /**
     * Begin transaction
     *
     * @return mixed
     */
    public function beginTransaction()
    {
        try {
            $this->dbAdapter->getDriver()->getConnection()->beginTransaction();
            $this->transactionStarted = TRUE;
        } catch (\Exception $exception) {
            // silence
        }
    }

    /**
     * Finish transaction and commit changes
     *
     * @return mixed
     */
    public function commitTransaction()
    {
        if (TRUE === $this->transactionStarted) {
            $this->dbAdapter->getDriver()->getConnection()->commit();
            $this->transactionStarted = FALSE;
        }
    }

    /**
     * Finish transaction and rollback changes.
     *
     * @return mixed
     */
    public function rollbackTransaction()
    {
        if (TRUE === $this->transactionStarted) {
            $this->dbAdapter->getDriver()->getConnection()->rollback();
            $this->transactionStarted = FALSE;
        }
    }
}