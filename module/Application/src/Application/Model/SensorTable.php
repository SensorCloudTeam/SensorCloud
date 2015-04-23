<?php
namespace Application\Model;

use Zend\Db\Sql\Select;

class SensorTable
{
    protected $sensortableGateway;
    protected $sinktableGateway;
    protected $typetableGateway;
 
    public function __construct($sensortableGateway,$sinktableGateway, $typetableGateway)
    {
        $this->sensortableGateway = $sensortableGateway;
        $this->sinktableGateway = $sinktableGateway;
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
    
    public function fetchAllPosted($sink_id)
    {
    	$select = new Select();
    	$select->from('sensor')
    	       ->join('type', 'type.id = sensor.type_id', array('type' => 'name'))
    	       ->where(array('sink_id' => $sink_id,'post'=>'1'));
    
    	$resultSet = $this->sensortableGateway->selectWith($select);
    	return $resultSet;
    }
    
    public function getsensornum($username)
    {
    	$select = new Select();
    	
    	$select->from('sensor')
    	       ->columns(array(
    			       'count' => new \Zend\Db\Sql\Expression('COUNT(sensor.id)')))
    	       ->join('sink', 'sink.id = sensor.sink_id', array())
           	   ->where(array('sink.user_id' => $username));
     
    	$resultSet = $this->sensortableGateway->selectWith($select);
    	$row = $resultSet->current();
    
    	return $row->count;
    }
    
    public function getpostnum($username)
    {
        $select = new Select();
         
        $select->from('sensor')
        ->columns(array(
        		'count' => new \Zend\Db\Sql\Expression('COUNT(sensor.id)')))
        		->join('sink', 'sink.id = sensor.sink_id', array())
        		->where(array('sink.user_id' => $username,'post' => '1'));
         
        $resultSet = $this->sensortableGateway->selectWith($select);
        $row = $resultSet->current();
        
        return $row->count;
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
      
    public function getMsg($sensor_id,$filter,$threshold_value)
    {
	    $select = new Select();
	    $select->from('sensor')
    	       ->join('type', 'type.id = sensor.type_id', array('type' => 'name','symbol' =>'unit_symbol'))
    	       ->where(array('sensor.id' => $sensor_id));
	    
	    switch ($filter){
	    	case 0:
	    	    break;
	    	case 1:
	    	    $select->where->greaterThan('value', $threshold_value);
	    	    break;
	    	case 2:
	    	    $select->where->lessThan('value', $threshold_value);
	    	    break;
	    	case 3:
	    	    $select->where->greaterThanOrEqualTo('value', $threshold_value);
	    	    break;
	    	case 4:
	    	    $select->where->lessThanOrEqualTo('value', $threshold_value);
	    	    break;
	    	case 5:
	    	    $select->where->equalTo('value', $threshold_value);
	    	    break;	   
	    	case 6:
	    	    $select->where->notEqualTo('value', $threshold_value);
	    	    break; 	    
	    }
	    
    	$resultSet = $this->sensortableGateway->selectWith($select);
        $row = $resultSet->current();
        if(!$row){
            $message = "当前没有您需要的数据";
        }else{
            $title = "SensorCloud订阅数据:";
            $sensor_name = $row->name;
            $sensor_type = $row->type;
            $sensor_value = $row->value;
            $sensor_symbol = $row->symbol;
            $sensor_time = $row->data_time;
            
            $message = $title."\n".$sensor_name.' '.$sensor_type.': '.$sensor_value.$sensor_symbol."\n"."数据最近更新时间:".$sensor_time."\n"."\n"."From：SensorCloud传感云平台"."\n"."上海市中山北路3663号 华东师范大学 软件学院";       
        }
        return $message;
    }
}
    