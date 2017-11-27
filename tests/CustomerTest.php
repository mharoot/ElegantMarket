<?php
//in command line run: 
// phpunit -d memory_limit=2048M --bootstrap model/Customer.php tests/CustomerTest.php --testdox
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


    public function test_join(){
        $customer = new Customer();
        $ft = 'orders';
        $pk = 'Customers.CustomerID';
        $op = '=';
        $fk = 'Orders.CustomerID';
        $results = $customer->join($ft)->on($pk,$op,$fk)->get();
        $this->assertTrue(count($results)>0);
        unset($customer);

    }

    public function test_inner_join(){
        $customer = new Customer();
        $ft = 'orders';
        $pk = 'Customers.CustomerID';
        $op = '=';
        $fk = 'Orders.CustomerID';
        $results = $customer->innerJoin($ft)->on($pk,$op,$fk)->get();
        $this->assertTrue(count($results)>0);
        unset($customer);

    }

    public function test_left_join(){
        $customer = new Customer();
        $ft = 'orders';
        $pk = 'Customers.CustomerID';
        $op = '=';
        $fk = 'Orders.CustomerID';
        $results = $customer->leftJoin($ft)->on($pk,$op,$fk)->get();
        $this->assertTrue(count($results)>0);
        unset($customer);

    }

    public function test_right_join(){
        $customer = new Customer();
        $ft = 'orders';
        $pk = 'Customers.CustomerID';
        $op = '=';
        $fk = 'Orders.CustomerID';
        $results = $customer->rightJoin($ft)->on($pk,$op,$fk)->get();
        $this->assertTrue(count($results)>0);
        unset($customer);

    }

    public function test_full_join(){
        $customer = new Customer();
        $ft = 'orders';
        $pk = 'Customers.CustomerID';
        $op = '=';
        $fk = 'Orders.CustomerID';
        $results = $customer->fullJoin($ft,$pk,$op,$fk)->get();
        $this->assertTrue(count($results)>0);
        unset($customer);

    }
    public function test_cross_join(){
        $customer = new Customer();
        $ft = 'orders';
        $results = $customer->crossJoin($ft)->get();
        $this->assertTrue(count($results)>0);
        unset($customer);
    }

    public function test_full_join_order_by_OrderID()
    {
        $customer = new Customer();
        $ft = 'orders';
        $pk = 'Customers.CustomerID';
        $op = '=';
        $fk = 'Orders.CustomerID';
        $results = $customer->fullJoin($ft,$pk,$op,$fk)->orderBy('OrderID', false)->get();
        $this->assertTrue(count($results)>0);
        unset($customer);
    }


    
    
}
?>