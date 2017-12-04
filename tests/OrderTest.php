<?php
//in command line run: 
// phpunit -d memory_limit=2048M --bootstrap model/Order.php tests/OrderTest.php --testdox
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
include_once('model/Order.php');

class OrderTest extends TestCase
{


/*  YOU MAY ONLY INSERT INTO ONE  TABLE AT A TIME a one_to_many insert is unesscessary 
    public function test_one_to_many_save()
    {
        TODO
        BEGIN;
            INSERT INTO orders (CustomerID, EmployeeID, ShipperID, OrderDate)
                VALUES(89, 6, 3, NOW());
            INSERT INTO orderdetails (OrderID, ProductID, Quantity) 
                VALUES(LAST_INSERT_ID(), 4, 150); //LAST_INSERT_ID() may not be reliable
        COMMIT;

        $order = new Order();
        $order_one_to_many_orderdetails = $order->oneToMany('orderdetails','OrderID', 'OrderID');
        $order->CustomerID = 89;
        $order->EmployeeID = 6;
        $order->ShipperID  = 3;
        $order->OrderDate  = 'NOW()';
        $order->OrderID    = 'LAST_INSERT_ID()'; //LAST_INSERT_ID() may not be reliable
        $order->ProductID  = 4;
        $order->Quantity   = 150;
        $result = $order_one_to_many_orderdetails->save();

        $this->assertTrue($result);

    }

    */

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
        $order->ShipperID = 3;
        $order->Quantity  = 3;
        $result = $order_one_to_many_orderdetails->where('orders.OrderID','=', 10249)
                                ->where('orderdetails.OrderID','=', 10249)
                                ->where('orderdetails.OrderDetailID','=', 4)
                                ->save();

        $this->assertTrue($result);
    }

   
    public function test_reset_customers_and_orders_table()
    {
        include_once('Elegant/Database.php');
        $db_handler = new Database();
        $q = file_get_contents('sql/resetCustomers.sql');
        $db_handler->query($q);
        $this->assertTrue( $db_handler->execute() );
    }
   
    
}
