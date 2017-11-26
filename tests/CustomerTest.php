<?php
//in command line run: 
//phpunit --bootstrap model/Customer.php tests/CustomerTest.php --testdox
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
include_once('model/Customer.php');

class CustomerTest extends TestCase
{

    // public function test_all() 
    // {
    //     $customer = new Customer();
    //     $results = $customer->all();
    //     $this->assertTrue(sizeof($results) > 0);

    // }

    // public function test_get_customer()
    // {
    //     $customer = new Customer();
    //     $results = $customer->getCustomer(1);
    //     $this->assertTrue(sizeof($results) > 0);
    // }

    // public function test_get_customer_order()
    // {
    //     $customer = new Customer();
    //     $results = $customer->getCustomerOrder(90);
    //     $this->assertTrue(sizeof($results) > 0);
    // }

    // public function test_get_customer_order_w_no_orders()
    // {
    //     $customer = new Customer();
    //     $results = $customer->getCustomerOrder(1);
    //     $this->assertTrue(sizeof($results) == 0);
    // }

    // public function test_get_customer_order_2()
    // {
    //     $pk = 'CustomerID';
    //     $fk = $pk;
    //     $customer_id = 90;
    //     $customer = new Customer();
    //     $results = $customer->oneToMany('orders', $pk, $fk)->where('orders.'.$fk, '=', $customer_id)->get();
    //     $this->assertTrue(sizeof($results) > 0);

    // }

    // public function test_get_customer_order_w_no_orders_2()
    // {
    //     $pk = 'CustomerID';
    //     $fk = $pk;
    //     $customer_id = 1;
    //     $customer = new Customer();
    //     $results = $customer->oneToMany('orders', $pk, $fk)->where('orders.'.$fk, '=', $customer_id)->get();
    //     $this->assertTrue(sizeof($results) == 0);
    // }

    /*
    public function test_get_left_join_customer_w_no_orders_2()
    {
        $pk = 'CustomerID';
        $fk = $pk;
        $customer_id = 1;
        $customer = new Customer();
        $results = $customer->leftJoin('orders', $pk, $fk)->where('orders.'.$fk, '=', $customer_id)->get();
        $this->assertTrue(sizeof($results) > 0);
    }
    */

    // public function test_delete_oneToMany_where()
    // {
    //     $pk = 'CustomerID';
    //     $fk = $pk;
    //     $customer_id = 1;
    //     $customer = new Customer();
    //     $result = $customer->oneToMany('orders', $pk, $fk)->where('orders.'.$fk, '=', $customer_id)->delete();
    //     $this->assertTrue($result);
    // }

    // public function test_get_customer_orders()
    // {
    //     $customer = new Customer();
    //     $results = $customer->getCustomerOrders();
    //     $this->assertTrue(sizeof($results) > 0);
    // }

    // public function test_reset_customers_table()
    // {
    //     include_once('Elegant/Database.php');
    //     $db_handler = new Database();
    //     $q = file_get_contents('sql/resetCustomers.sql');
    //     $db_handler->query($q);
    //     $this->assertTrue( $db_handler->execute() );
    // }

    // public function test_inner_join(){
    //     $customer = new Customer();
    //     $foreign_table_name = 'orders';
    //     $primary_key = 'Customers.CustomerID';
    //     $op = '=';
    //     $foreign_key = 'Orders.CustomerID';
    //     $results = $customer->innerJoin($foreign_table_name)->on($primary_key,$op,$foreign_key)->get();
    //     $this->assertTrue(count($results)>0);

    // }

    // public function test_left_join(){
    //     $customer = new Customer();
    //     $foreign_table_name = 'orders';
    //     $primary_key = 'Customers.CustomerID';
    //     $op = '=';
    //     $foreign_key = 'Orders.CustomerID';
    //     $results = $customer->leftJoin($foreign_table_name)->on($primary_key,$op,$foreign_key)->get();
    //     $this->assertTrue(count($results)>0);

    // }

    // public function test_right_join(){
    //     $customer = new Customer();
    //     $foreign_table_name = 'orders';
    //     $primary_key = 'Customers.CustomerID';
    //     $op = '=';
    //     $foreign_key = 'Orders.CustomerID';
    //     $results = $customer->rightJoin($foreign_table_name)->on($primary_key,$op,$foreign_key)->get();
    //     $this->assertTrue(count($results)>0);

    // }

    public function test_full_join(){
        $customer = new Customer();
        $foreign_table_name = 'orders';
        $primary_key = 'CustomerID';
        $op = '=';
        $foreign_key = 'CustomerID';
        $results = $customer->fullJoin($foreign_table_name, $primary_key, $op, $foreign_key)->get();
        $this->assertTrue(count($results)>25);

    }

    
    
}
?>