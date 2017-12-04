<?php
//in command line run: 
// phpunit -d memory_limit=2048M --bootstrap model/Order.php tests/OrderTest.php --testdox
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
include_once('model/Order.php');

class OrderTest extends TestCase
{

    public function test_one_to_many_where_where_where_save()
    {
        /*

            In QUERY BUILDER:

            UPDATE orders LEFT JOIN orderdetails ON orders.OrderID=orderdetails.OrderID 
            SET ShipperID = :ShipperID, Quantity = :Quantity 
            WHERE orders.OrderID=:OrderID  
            AND orderdetails.OrderID=:OrderID  
            AND orderdetails.OrderDetailID=:OrderDetailID
---------------------------------------------------------------------------------------------------
            In MODEL:

            UPDATE orders LEFT JOIN orderdetails ON orders.OrderID = orderdetails.OrderID
            SET orders.ShipperID = 2, orderdetails.Quantity = 2 
            WHERE orders.OrderID = 10249
            AND orderdetails.OrderID = 10249 
            AND orderdetails.OrderDetailID = 4

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

    public function test_get_order_details_for_test_above()
    {
        $order = new Order();
        $order_id = 10249;
        $this->assertTrue( sizeof( $orders = $order->getOrderDetails($order_id) )   >   0 );
        $this->assertEquals($orders[0]->OrderID,        10249);
        $this->assertEquals($orders[0]->OrderDetailID,      4);
        $this->assertEquals($orders[0]->Quantity,           3);
        $this->assertEquals($orders[0]->ShipperID,          3);
    }
   
    public function test_reset_customers_and_orders_table()
    {
        include_once('Elegant/Database.php');
        $db_handler = new Database();
        $q = file_get_contents('sql/resetOrdersAndDetails.sql');
        $db_handler->query($q);
        $this->assertTrue( $db_handler->execute() );
    }

    public function test_one_to_many_where_where_save()
    {

        $order = new Order();

        $order->ShipperID = 4;        
        $order_one_to_many_orderdetails = $order->oneToMany('orderdetails','OrderID', 'OrderID');
        $order->Quantity  = 46; // oneToMany made the property Quantity from orderdetails table available
                               // note: if ambigeous updates are attempted such as $order->OrderID. 
                               // This is not allowed in Elegant.  Work around is to use orderdetails model and orders instead.

        $result = $order_one_to_many_orderdetails//->where('orders.OrderID','=', 10249)
                                ->where('orderdetails.OrderID','=', 10249)
                                ->where('orderdetails.OrderDetailID','=', 4)
                                ->save();

        $this->assertTrue($result);
    }

    public function test_one_to_many_where_where_get()
    {

        $order = new Order();
        $order_one_to_many_orderdetails = $order->oneToMany('orderdetails','OrderID', 'OrderID');
        
        $orders = $order_one_to_many_orderdetails
                                ->where('orderdetails.OrderID','=', 10249)
                                ->where('orderdetails.OrderDetailID','=', 4)
                                ->get();

        $this->assertEquals($orders[0]->OrderID,        10249);
        $this->assertEquals($orders[0]->OrderDetailID,      4);
        $this->assertEquals($orders[0]->Quantity,           46);
        $this->assertEquals($orders[0]->ShipperID,          4);
    }



    public function test_reset_customers_and_orders_tables_again()
    {
        include_once('Elegant/Database.php');
        $db_handler = new Database();
        $q = file_get_contents('sql/resetOrdersAndDetails.sql');
        $db_handler->query($q);
        $this->assertTrue( $db_handler->execute() );
    }

    public function test_originally_we_have_ShipperID_equals_1_and_Quantity_equals_9()
    {
        $order = new Order();
        $order_id = 10249;
        $this->assertTrue( sizeof( $orders = $order->getOrderDetails($order_id) )   >   0 );
        $this->assertEquals($orders[0]->OrderID,        10249);
        $this->assertEquals($orders[0]->OrderDetailID,      4);
        $this->assertEquals($orders[0]->Quantity,           9);
        $this->assertEquals($orders[0]->ShipperID,          1);
    }
   
    
}
