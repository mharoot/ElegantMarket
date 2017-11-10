<?php
//in command line run: 
//phpunit --bootstrap model/Customer.php tests/CustomerTest.php --testdox
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
include_once('model/Customer.php');

class CustomerTest extends TestCase
{

    public function test_all() 
    {
        $customer = new Customer();
        $results = $customer->all();
        $this->assertTrue(sizeof($results) > 0);

    }

    public function test_get_customer()
    {
        $customer = new Customer();
        $results = $customer->getCustomer(1);
        $this->assertTrue(sizeof($results) > 0);
    }

    public function test_get_customer_order()
    {
        $customer = new Customer();
        $results = $customer->getCustomerOrder(90);
        $this->assertTrue(sizeof($results) > 0);
    }

    public function test_get_customer_order_w_no_orders()
    {
        $customer = new Customer();
        $results = $customer->getCustomerOrder(1);
        $this->assertTrue(sizeof($results) == 0);
    }


    public function test_get_customer_orders()
    {
        $customer = new Customer();
        $results = $customer->getCustomerOrders();
        $this->assertTrue(sizeof($results) > 0);
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
?>