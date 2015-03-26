<?php
/**
 * User: dorin
 * Date: 24.03.2015
 * Time: 17:04
 */

namespace Veriatrans\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Tools\Pagination\Paginator;

class EventRepository extends EntityRepository
{
    /**
     * @param int $PageNumber
     * @param int $DisplayLength
     * @param string $OrderColumn
     * @param string $OrderBy
     * @return array
     * @author Aftenii Dorin
     */
    public function get($arrayTableAndRow, $DisplayStart=1, $DisplayLength = 10, $OrderColumn = 'id' , $OrderBy = 'ASC' )
    {
        $result = array();
        $alertBeforeDays = '';
        $connection = $this->_em->getConnection();
        foreach($arrayTableAndRow AS $table=>$settings){
            $expiry = '';
            $column = '';
            $description = '';
            $subDescriptionSql = '';
            $sqlQuery = 'SELECT ';
            foreach($settings AS $settings1){
                foreach($settings1 AS $state=>$stateValue){
                    switch($state){
                        case 'expiry':      $expiry = $stateValue; break;
                        case 'description': $description = $stateValue; break;
                        case '%s':          $subDescriptionSql = empty($stateValue) ? '' : "',$table.".join(",' ',$table.",$stateValue);
                                            break;
                        default:            $column = $state; //$alertBeforeDays = $stateValue;
                    }
                }
            }

            if(strpos($description,'%s') !== false){
                $description = "concat('".str_replace('%s',$subDescriptionSql.",'",$description)."')";
            }

            //$column as Date
            if(!empty($expiry)){
                $column = "DATE_ADD( from_unixtime( $column, '%Y-%m-%d' ) , INTERVAL 2 YEAR )";
            }else{
                $column = "from_unixtime( $column, '%Y-%m-%d' )";
            }
            /*if(!empty($alertBeforeDays)){
                $nowAddBeforeDays = "UNIX_TIMESTAMP(DATE_ADD( NOW( ) , INTERVAL $alertBeforeDays ))";
            }*/

            $sqlQuery .= "e.id, $description as Description, DATEDIFF($column,NOW()) as ExpireDays, e.ModifiedAt, e.IsViewed FROM Event e
                                JOIN $table ON $table.id = e.ItemID AND e.TableName = '$table'
                                WHERE NOW( )
                                BETWEEN DATE_SUB( $column , INTERVAL 1 MONTH )
                                AND $column AND $table.IsDeleted = 0 LIMIT $DisplayStart, $DisplayLength";
            $statement = $connection->prepare($sqlQuery);
            $statement->execute();
            $result = array_merge($result,$statement->fetchAll());
        }
        return $result;
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
        $tableName = $this->_em->getClassMetadata('VeriatransMainBundle:Event')->getTableName();
        $connection = $this->_em->getConnection();
        $statement = $connection->prepare("DELETE FROM $tableName WHERE id = :id");
        $statement->bindValue('id', $id);
        $result = $statement->execute();
        return $statement->rowCount();
    }

    public function create(array $fieldsAndValues){
        $tableName = $this->_em->getClassMetadata('VeriatransMainBundle:Event')->getTableName();
        $connection = $this->_em->getConnection();
        $statement = $connection->insert($tableName,$fieldsAndValues);
        return $connection->lastInsertId();
    }
}
