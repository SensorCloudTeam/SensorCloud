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
 
    public function fetchAll($username)
    {
        $select = new Select();
        $select->from('subscription')
               ->join('sensor', 'subscription.sensor_id = sensor.id', array('sensor_name' => 'name'))
               ->join('type', 'type.id = sensor.type_id', array('type' => 'name'))
               ->join('sink', 'sink.id = sensor.sink_id', array('sensor_location' => 'location','puser_id'))
               ->where(array('user_id' => $username));
        
        $resultSet = $this->subscriptiontableGateway->selectWith($select);
        
        return $resultSet;
    }
    
    public function deleteSubscription($id){
    	$this->subscriptiontableGateway->delete(array('id' => $id));
    }
      
}
    