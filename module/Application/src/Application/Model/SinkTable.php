<?php
namespace Application\Model;
 
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
 
class SinkTable
{
    protected $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
 
    public function fetchAll($username)
    {
        $resultSet = $this->tableGateway->select(array('user_id' => $username));
        return $resultSet;
    }
    
    public function fetchAllSinks()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    } 
    
    public function getsinknum($username)
    {
        $select = new Select();
        $select->from('sink')
        ->columns(array(
        		'count' => new \Zend\Db\Sql\Expression('COUNT(id)')))
        		->where(array('user_id' => $username));
        
        $resultSet = $this->tableGateway->selectWith($select);
        $row = $resultSet->current();
        
        return $row->count;
    }
    
    public function getName($sink_id)
    {
        $rowset = $this->tableGateway->select(array('id' => $sink_id));
    
    	$row = $rowset->current();
    	if (!$row) {
    		return null;
    	}
    	return $row->name;
    }
    
    public function addSink(Sink $sink)
    {
    	$data = array(
    			'user_id' => $sink->user_id,
    			'id'  => $sink->id,
    	        'name'   => $sink->name,
    	        'longitude' =>"121.412158",
    	        'latitude' =>"31.23613",
    	);
    	$this->tableGateway->insert($data);
    }
    
    public function deleteSink($id){
        $this->tableGateway->delete(array('id' => $id));
    }
      
}
    