<?php
declare(strict_types=1);

include_once("Elegant/Model.php");

class J1 extends Model {

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
			$this->table_name = 'j1';
			parent::__construct($this);

	}

	
	


	
}

?>