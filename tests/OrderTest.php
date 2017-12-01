<?php
//in command line run: 
// phpunit -d memory_limit=2048M --bootstrap model/Customer.php tests/CustomerTest.php --testdox
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
include_once('model/Customer.php');

class CustomerTest extends TestCase
{


    public function test_one_to_many_where_where_where_save()
    {
/*
UPDATE orders LEFT JOIN orderdetails ON orders.OrderID = orderdetails.OrderID
SET orders.ShipperID = 2, orderdetails.Quantity = 2 
WHERE orders.OrderID = 10249
AND orderdetails.OrderID = 10249 
AND orderdetails.OrderDetailID = 4

UPDATE orders LEFT JOIN orderdetails ON orders.OrderID=orderdetails.OrderID 
SET ShipperID = :ShipperID, Quantity = :Quantity 
WHERE orders.OrderID=:OrderID  
AND orderdetails.OrderID=:OrderID  
AND orderdetails.OrderDetailID=:OrderDetailID
*/
        $order = new Order();
        $order_one_to_many_orderdetails = $order->oneToMany('orderdetails','OrderID', 'OrderID');
        $order->ShipperID = 2;
        $order->Quantity  = 2;
        $result = $order_one_to_many_orderdetails->where('orders.OrderID','=', 10249)
                                ->where('orderdetails.OrderID','=', 10249)
                                ->where('orderdetails.OrderDetailID','=', 4)
                                ->save();

        $this->assertTrue($result);
    }

    public function test_reset_customers_table()
    {
        include_once('Elegant/Database.php');
        $db_handler = new Database();
        $q = file_get_contents('sql/resetCustomers.sql');
        $db_handler->query($q);
        $this->assertTrue( $db_handler->execute() );
    }
    
}