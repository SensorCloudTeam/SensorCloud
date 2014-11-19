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
    			'name'  => $user->uname,
    	        'password' => sha1($user->password),
    	        'poster'   => $user->poster,
    	);
    
    	$name = $user->uname;
    	if (!$name == null) {
    	
    		$this->tableGateway->insert($data);
    	} else {
    		if ($this->getUser($name)) {
    			$this->tableGateway->update($data, array('name' => $name));
    		} else {
    			throw new \Exception('Form email does not exist');
    		}
    	}
    }
    
    public function deleteUser($email)
    {
    	$this->tableGateway->delete(array('email' => $email));
    }
}
    