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
    
    public function isRegisted($email)
    {
    	$rowset = $this->tableGateway->select(array('email' => $email));
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
    	        'reg_time' => $user->reg_time,
    	        'poster'   => $user->poster,
    	);
    	$this->tableGateway->insert($data);
    }
    
    public function getEmail($username)
    {
        $rowset = $this->tableGateway->select(array('id' => $username));
        
        $row = $rowset->current();
        if (!$row) {
        	return null;
        }
        return $row->email;
    }
    
    public function getPass($username)
    {
    	$rowset = $this->tableGateway->select(array('id' => $username));
    
    	$row = $rowset->current();
    	if (!$row) {
    		return null;
    	}
    	return $row->password;
    }
    public function getTime($username)
    {
    	$rowset = $this->tableGateway->select(array('id' => $username));
    	$row = $rowset->current();
    	if (!$row) {
    		return null;
    	}
    	return $row->reg_time;
    }
    
    public function getPoster($username)
    {
    	$rowset = $this->tableGateway->select(array('id' => $username));
    	$row = $rowset->current();
    	if (!$row) {
    		return null;
    	}
    	return $row->poster;
    }
    
    public function changePass($username,$password){
        $data = array(
            'password' => sha1($password),
        );
        $this->tableGateway->update($data,array('id'=> $username));
    }
    
}
    