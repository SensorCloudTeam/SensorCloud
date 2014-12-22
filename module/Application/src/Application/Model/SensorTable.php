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
        $select = new Select();
        $select->from('sensor')
               ->columns(array(
                    'maxsensorid' => new \Zend\Db\Sql\Expression('MAX(sensor_id)')))
               ->where(array('sink_id' => $sink_id));
        
        $resultSet = $this->sensortableGateway->selectWith($select);
        $row = $resultSet->current();
        $sensor_id = $row->maxsensorid + 1;
        
        $line = "_";
        $id = $sink_id.$line.$sensor_id;
        
    	$data = array(
    	        'id' => $id,
    	        'sensor_id' => $sensor_id,
    	        'sink_id' => $sink_id,
    			'name'  => $sensor->name,
    	        'type_id'  => $sensor->type_id,
    	        'post'  =>  $sensor->post,
    	);
    	$this->sensortableGateway->insert($data);
    }
    
    public function postSensor($id){
        $data = array(
            'post' => '1',
        );
        
    	$this->sensortableGateway->update($data,array('id' => $id));
    }
    
    public function canclepostSensor($id){
    	 $data = array(
            'post' => '0',
        );
        
    	$this->sensortableGateway->update($data,array('id' => $id));
    }
    
    public function deleteSensor($id){
        $this->sensortableGateway->delete(array('id' => $id));
    }
      
}
    