<?php
/**
 * User: dorin
 * Date: 3/17/15
 * Time: 8:32 PM
 * @author Aftenii Dorin
 */

namespace Veriatrans\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Tools\Pagination\Paginator;

class DriverRouteRepository extends EntityRepository
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
        $connection = $this->_em->getConnection();
        $statement = $connection->prepare("SELECT dr.id, CompanyName AS clientID, KaiiNumber AS containerID, currentKm, date, CountryCode AS destinationID, concat(FirstName,' ',LastName) AS driverID, highwayPaiment,loadedWeight,orderNumber,pastKm,Model AS truckID
                                            FROM DriverRoute AS dr
                                            INNER JOIN Client AS c ON c.id = dr.ClientID
                                            INNER JOIN Container AS ct ON ct.id = dr.ContainerID
                                            INNER JOIN Destination AS ds ON ds.id = dr.DestinationID
                                            INNER JOIN Driver AS d ON d.id = dr.DriverID
                                            INNER JOIN Truck AS t ON t.id = dr.TruckID
                                            WHERE dr.IsDeleted = 0
                                            ORDER BY dr.$OrderColumn $OrderBy
                                            LIMIT $DisplayStart, $DisplayLength");
        $statement->execute();
        return $statement->fetchAll();
    }

    /**
     * @param $table
     * @param $database
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    private function isValidJoinTable($database, $table){
        $connection = $this->_em->getConnection();
        $statement = $connection->prepare("SELECT *
                                            FROM information_schema.tables
                                            WHERE LOWER(table_schema) = LOWER('$database')
                                                AND LOWER(table_name) = LOWER('$table')
                                            ");
        $statement->execute();
        return $statement->rowCount();
    }

    public function retrieveJoinData($database, $table, $columns){
        $isValidJoinColumn          = $this->isValidJoinTable( $database, $table );
        if ( !$isValidJoinColumn ) {
            return false;
        }

        $connection = $this->_em->getConnection();
        $statement = $connection->prepare("SELECT id, ".implode(',',$columns)." FROM ".ucfirst($table)." ORDER BY ".implode(',',$columns)." ASC");
        $statement->execute();
        return $statement->fetchAll();
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
        $tableName = $this->_em->getClassMetadata('VeriatransMainBundle:DriverRoute')->getTableName();
        $connection = $this->_em->getConnection();
        $statement = $connection->prepare("DELETE FROM $tableName WHERE id = :id");
        $statement->bindValue('id', $id);
        $statement->execute();
        return $statement->rowCount();
    }

    public function create(array $fieldsAndValues){
        $tableName = $this->_em->getClassMetadata('VeriatransMainBundle:DriverRoute')->getTableName();
        $connection = $this->_em->getConnection();
        $statement = $connection->insert($tableName,$fieldsAndValues);
        return $connection->lastInsertId();
    }
}
