<?php
namespace Application\Model;

use Zend\Db\Sql\Select;

class SensorTable
{
    protected $sensortableGateway;
    protected $typetableGateway;
 
    public function __construct($sensortableGateway, $typetableGateway)
    {
        $this->sensortableGateway = $sensortableGateway;
        $this->typetableGateway = $typetableGateway;
    }
 
    public function fetchAll($sink_id)
    {
        $select = new Select();
        $select->from('sensor')
               ->join('type', 'type.id = sensor.type_id', array('type' => 'name'))
               ->where(array('sink_id' => $sink_id));
        
        $resultSet = $this->sensortableGateway->selectWith($select);
        return $resultSet;
    }
    
    public function addSensor($sensor,$sink_id)
    {
        
    	$data = array(
    	        'id' => $id,
    	        'sensor_id' => $sensor_id,
    	        'sink_id' => $sink_id,
    			'name'  => $sensor->name,
    	        'type_id'  => $sensor->type_id,
    	);
    	$this->tableGateway->insert($data);
    }
    
    public function deleteSensor($id){
        $this->sensortableGateway->delete(array('id' => $id));
    }
      
}
    