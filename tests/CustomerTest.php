<?php
//in command line run: 
// phpunit -d memory_limit=2048M --bootstrap model/Customer.php tests/CustomerTest.php --testdox
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
include_once('model/Customer.php');

class CustomerTest extends TestCase
{

    /* passed
    public function test_one_to_many_orders_where_where_delete()
    {
        $pk = 'CustomerID';
        $fk = $pk;
        $customer_id = 89;
        $customer = new Customer();
        $results = $customer->oneToMany('orders', $pk, $fk)->where('orders.'.$fk, '=', $customer_id)->where('orders.OrderID','>',1)->delete();
        $this->assertTrue(sizeof($results) > 0);
    }
    */

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



    /* TEST PASSED
    public function test_one_to_many_orders_where_get()
    {
        $pk = 'CustomerID';
        $fk = $pk;
        $customer_id = 89;
        $customer = new Customer();
        $results = $customer->oneToMany('orders', $pk, $fk)->where('orders.'.$fk, '=', $customer_id)->get();
        $this->assertTrue(sizeof($results) > 0);

    }
    */


    /* TEST PASSED
    public function test_one_to_many_orders_where_where_get()
    {
        $pk = 'CustomerID';
        $fk = $pk;
        $customer_id = 89;
        $customer = new Customer();
        $results = $customer->oneToMany('orders', $pk, $fk)->where('orders.'.$fk, '=', $customer_id)->where('orders.OrderID','>',1)->get();
        $this->assertTrue(sizeof($results) > 0);
    }
    */


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

    /* TEST PASSED
    public function test_one_to_many_where_delete()
    {
        $pk = 'CustomerID';
        $fk = $pk;
        $customer_id = 1;
        $customer = new Customer();
        $result = $customer->oneToMany('orders', $pk, $fk)->where('orders.'.$fk, '=', $customer_id)->delete();
        $this->assertTrue($result);
    }
    */

    /* passed
    public function test_one_to_one_where_delete()
    {
        $pk = 'CustomerID';
        $fk = $pk;
        $customer_id = 67;
        $customer = new Customer();
        $result = $customer->oneToOne('orders', $pk, $fk)->where('orders.'.$fk, '=', $customer_id)->delete();
        $this->assertTrue($result);
    }
    */


    // public function test_get_customer_orders()
    // {
    //     $customer = new Customer();
    //     $results = $customer->getCustomerOrders();
    //     $this->assertTrue(sizeof($results) > 0);
    // }


    public function test_reset_customers_table()
    {
        include_once('Elegant/Database.php');
        $db_handler = new Database();
        $q = file_get_contents('sql/resetCustomersAndOrders.sql');
        $db_handler->query($q);
        $this->assertTrue( $db_handler->execute() );
    }
    



    /*
    passing join tests:

    public function test_join()
    {
        $customer = new Customer();
        $ft = 'orders';
        $pk = 'Customers.CustomerID';
        $op = '=';
        $fk = 'Orders.CustomerID';
        $results = $customer->join($ft)->on($pk,$op,$fk)->get();
        $this->assertTrue(count($results)>0);
        unset($customer);
    }

    public function test_inner_join()
    {
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

    public function test_right_join()
    {
        $customer = new Customer();
        $ft = 'orders';
        $pk = 'Customers.CustomerID';
        $op = '=';
        $fk = 'Orders.CustomerID';
        $results = $customer->rightJoin($ft)->on($pk,$op,$fk)->get();
        $this->assertTrue(count($results)>0);
        unset($customer);

    }

    public function test_full_join()
    {
        $customer = new Customer();
        $ft = 'orders';
        $pk = 'Customers.CustomerID';
        $op = '=';
        $fk = 'Orders.CustomerID';
        $results = $customer->fullJoin($ft,$pk,$op,$fk)->get();
        $this->assertTrue(count($results)>0);
        unset($customer);

    }
    end of passing joins tests
    */


/* TEST FAILED
    public function test_cross_join_get(){
        $customer = new Customer();
        $ft = 'orders';
        //$pt = $customer->table_name;
        //$ptpk = $pt.'.'.'CustomerID';
        $results = $customer->crossJoin($ft)->get();
        $this->assertTrue(count($results)>0);
        unset($customer);
    }
*/


    /* TEST PASSED
    public function test_full_join_order_by_OrderID()
    {
        $customer = new Customer();
        $ft   = 'orders';
        $ftfk = 'orders.CustomerID';
        $ptpk = $customer->table_name.'.CustomerID'; // customers.CustomerID
        $op   = '=';
        $results = $customer->fullJoin($ft,$ptpk,$op,$ftfk)->orderBy('OrderID', false)->get();
        $this->assertTrue(count($results)>0);
        unset($customer);
    }
    */

    
    
}
?>