<?php
namespace Application\Model;
 
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\ResultSet\AbstractResultSet;
 
class UserTable
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
 
    public function isExist($username)
    {
        $rowset = $this->tableGateway->select(array('id' => $username));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return true;
    }
    
    public function saveUser(User $user)
    {
    	$data = array(
    			'email' => $user->email,
    			'id'  => $user->username,
    	        'password' => sha1($user->password),
    	        'poster'   => $user->poster,
    	);
    	$this->tableGateway->insert($data);
    }
    
    public function rightPass($username,$password)
    {
        $rowset = $this->tableGateway->select(array('id'=>$username));
        $row = (array)$rowset->current();
        if(sha1($password) == $row['password']){
            return true;
        }
        else{
            return false;
        }
        
    }
    
}
    