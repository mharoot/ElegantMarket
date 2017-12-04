<?php
declare(strict_types=1);
include_once("Elegant/Model.php");
class Order extends Model {
	public function __construct()  
	{  
			parent::__construct($this);
	}
	
	public function getOrderDetails($order_id)
	{
		return $this->oneToMany('orderdetails', 'OrderID', 'OrderID')
			 ->where($this->table_name.'.OrderID', '=', $order_id)
			 ->get();
	}
}