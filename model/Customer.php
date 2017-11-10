<?php
declare(strict_types=1);

include_once("Elegant/Model.php");

class Customer extends Model {

	//public $id; id is being autoincremented no need to set.  we need auto incremeting detection ideas
	// public $name;
	// public $address;
	/* 
		Every instance of a model should have properties like table_name, primary key, etc;
		Before the parent::__construct().
	*/
	public function __construct()  
	{  
			// by convention Elegant assumes the model representing the table in the database is all lower case and plural
			parent::__construct($this);

	}

	public function create ($name, $address)
	{ 
		$this->name = $name;
		$this->address = $address;
		return $this->save();
	}

	public function updateById($id,$name, $address)
	{
		$this->name = $name;
		$this->address = $address;
		return $this->where('id', '=', 5)->save();
	}

	public function removeById($id)
	{
		return $this->where('id', '=', $id)->delete();
	}


	public function getCustomerOrder($id)
	{
	
        $primary_key = 'CustomerID';
        $foreign_key = 'CustomerID';
        return $this->oneToMany('orders', $primary_key, $foreign_key)->where($this->table_name.'.'.$primary_key, '=', $id)->get();
	}
	
	public function getCustomerOrders()
	{
	
        $primary_key = 'CustomerID';
        $foreign_key = 'CustomerID';
        return $this->oneToMany('orders', $primary_key, $foreign_key)->get();
	}
	

	


	
}

?>