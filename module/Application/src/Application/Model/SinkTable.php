<?php
namespace Application\Model;
 
use Zend\Db\TableGateway\TableGateway;
 
class SinkTable
{
    protected $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
 
    public function fetchAll($username)
    {
        $resultSet = $this->tableGateway->select(array('puser_id' => $username));
        return $resultSet;
    }
    
    public function addSink(Sink $sink)
    {
    	$data = array(
    			'puser_id' => $sink->user_id,
    			'id'  => $sink->id,
    	        'name'   => $sink->name,
    	);
    	$this->tableGateway->insert($data);
    }
    
    public function deleteSink($id){
        $this->tableGateway->delete(array('id' => $id));
    }
      
}
    