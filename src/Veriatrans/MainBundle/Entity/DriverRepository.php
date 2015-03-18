<?php
/**
 * Created by PhpStorm.
 * User: dorin
 * Date: 3/17/15
 * Time: 8:32 PM
 */

namespace Veriatrans\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Tools\Pagination\Paginator;

class DriverRepository extends EntityRepository
{
    /**
     * @param int $PageNumber
     * @param int $DisplayLength
     * @param string $OrderColumn
     * @param string $OrderBy
     * @return array
     * @author Aftenii Dorin
     */
    public function get($DisplayStart=1, $DisplayLength = 10, $OrderColumn = 'id' , $OrderBy = 'ASC' )
    {
        $qb = $this->createQueryBuilder('t');

        $qb
            ->where('t.isDeleted = :isDeleted')
            ->setParameter('isDeleted', false)
            //->andWhere('t.isDone = false')
            ->setFirstResult($DisplayStart)
            ->setMaxResults($DisplayLength)
            ->orderBy("t.$OrderColumn", $OrderBy)
        ;


        return $qb->getQuery()->getArrayResult();
    }

    /**
     * http://doctrine-orm.readthedocs.org/en/latest/reference/query-builder.html#the-expr-class
     * @param array $FieldAndValue
     * @param integer $id
     */
    public function updateOneCell(array $fieldAndValue, $id){
        reset($fieldAndValue);
        $key = key($fieldAndValue);
        $qb = $this->createQueryBuilder('t');
        $q = $qb->update()
            ->set('t.'.$key, '?1')
            ->where('t.id = ?2')
            ->setParameter(1, $fieldAndValue[$key])
            ->setParameter(2, $id)
            ->getQuery();
        return $q->execute();
    }

    public function getColumnsLength($table,$database){
        $connection = $this->_em->getConnection();
        $statement = $connection->prepare("SELECT COLUMN_NAME AS Field, COLUMN_TYPE AS Type FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = :database AND TABLE_NAME = :table");
        $statement->bindValue('database', $database);
        $statement->bindValue('table', $table);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function delete($id){
        $tableName = $this->_em->getClassMetadata('VeriatransMainBundle:Driver')->getTableName();
        $connection = $this->_em->getConnection();
        $statement = $connection->prepare("DELETE FROM $tableName WHERE id = :id");
        $statement->bindValue('id', $id);
        $result = $statement->execute();
        return $statement->rowCount();
    }

    public function create(array $fieldsAndValues){
        $tableName = $this->_em->getClassMetadata('VeriatransMainBundle:Driver')->getTableName();
        $connection = $this->_em->getConnection();
        $statement = $connection->insert($tableName,$fieldsAndValues);
        return $connection->lastInsertId();
    }
}
