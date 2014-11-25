<?php
namespace Application\Model;
 
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\ResultSet\AbstractResultSet;
 
class SinkTable
{
    protected $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
 
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function saveSink(Sink $sink)
    {
    	$data = array(
    			'user_id' => $sink->user_id,
    			'id'  => $sink->id,
    	        'name'   => $sink->name,
    	);
    	$this->tableGateway->insert($data);
    }
      
}
    