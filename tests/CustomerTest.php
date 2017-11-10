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

    public function test_get_customer_order()
    {
        $customer = new Customer();
        $results = $customer->getCustomerOrder(90);
        $this->assertTrue(sizeof($results) > 0);
    }

    public function test_get_customer_orders()
    {
        $customer = new Customer();
        $results = $customer->getCustomerOrders();
        $this->assertTrue(sizeof($results) > 0);
    }


    
    
}
?>