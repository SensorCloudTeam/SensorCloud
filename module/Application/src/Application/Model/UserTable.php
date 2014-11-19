<?php
namespace Application\Model;
 
use Zend\Db\TableGateway\TableGateway;
 
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
 
    public function getUser($uname)
    {
        $rowset = $this->tableGateway->select(array('name' => $uname));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $uname");
        }
        return $row;
    }
    
    public function saveUser(User $user)
    {
    	$data = array(
    			'email' => $user->email,
    			'id'  => $user->username,
    	        'password' => sha1($user->password),
    	        'poster'   => $user->poster,
    	);
    
    	$username = $user->username;
    	if (!$username == null) {
    	
    		$this->tableGateway->insert($data);
    	} else {
    		if ($this->getUser($username)) {
    			$this->tableGateway->update($data, array('id' => $username));
    		} else {
    			throw new \Exception('Form username does not exist');
    		}
    	}
    }
    
    public function deleteUser($username)
    {
    	$this->tableGateway->delete(array('id' => $username));
    }
}
    