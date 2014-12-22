<?php
namespace Application\Model;
 
use Zend\Db\Sql\Select;

class SubscriptionTable
{
    protected $subscriptiontableGateway;
    protected $sensortableGateway;
    protected $typetableGateway;
    protected $sinktableGateway;
 
    public function __construct($subscriptiontableGateway, $sensortableGateway,$typetableGateway,$sinktableGateway)
    {
        $this->subscriptiontableGateway = $subscriptiontableGateway;
        $this->sensortableGateway = $sensortableGateway;
        $this->typetableGateway = $typetableGateway;
        $this->sinktableGateway = $sinktableGateway;
    }
 
    public function fetchAllSink()
    {
        $resultSet = $this->sinktableGateway->select();
        
        return $resultSet;
    }
    
    public function getSink($sink_id)
    {
        $resultSet = $this->sinktableGateway->select(array('id' => $sink_id));
        $row = $resultSet->current();
        if (!$row) {
        	return null;
        }
        return $row;
    }
    
    public function fetchAllSensor($sink_id)
    {
    	$resultSet = $this->sensortableGateway->select(array('sink_id'=>$sink_id));
    
    	return $resultSet;
    }
    
    public function fetch($username)
    {
        $select = new Select();
        $select->from('subscription')
               ->join('sensor', 'subscription.sensor_id = sensor.id', array('sensor_name' => 'name'))
               ->join('type', 'type.id = sensor.type_id', array('type' => 'name'))
               ->join('sink', 'sink.id = sensor.sink_id', array('lon' => 'longitude','lat' => 'latitude','puser_id'))
               ->where(array('user_id' => $username));
        
        $resultSet = $this->subscriptiontableGateway->selectWith($select);
        
        return $resultSet;
    }
    
    public function deleteSubscription($id){
    	$this->subscriptiontableGateway->delete(array('id' => $id));
    }
      
}
    