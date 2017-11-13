<?php
/*

SUPER CONTROLLER WE ARE NO LONGER USING SEPERATE CONTROLLER FILES.

ALL GET, PUT, DELETE, POST calls go through here for the website
*/

include_once("model/Customer.php");
class Controller {
    public $customer_model;
    public $_routes = ['customer-orders','customers', 'delete-customer', 'insert-customer', 'query-builder', 'reset-customers', 't'];
    
    public function __construct()  
    {  
        if( $this->customer_model !=null)
        {
            return;
        }
        $this->customer_model = new Customer();
    }
    
    public function invoke()
    {
        $noRequests = TRUE;
        for ($i = 0; $i < count($this->_routes); $i++)
        {
            if ( isset($_GET[$this->_routes[$i]]) || isset($_POST[$this->_routes[$i]]) )
            {
                $noRequests = FALSE;
            }
        }

        if($noRequests)
        {
            // no special book is requested, we'll show a list of all available books
            include 'view/templates/header.php';
            include 'view/pages/documentation.php';
            include 'view/templates/footer.php';
        }

        $this->get_request_handler();
        $this->post_request_handler(); // handles POST PUT DELETE
    }

    private function get_request_handler()
    {
        if($_SERVER['REQUEST_METHOD'] == 'GET')
        {

            if (isset($_GET['t']))
            {
                //illegal chaining takes to 404 with error message to guide users
                $this->customer_model->oneToOne('','','')->oneToOne('','','')->get();
            }

            if (isset($_GET['customer-orders']))
            {
/*
    using a join vs using a left join:

    Optimization plan 1: The second clause can be optimized using limit 1 since were only expected 1 result for 1 customer id. 
    Optimization plan 2: Take out second clause use left join instead where the customer is the left side, note maybe oneToMany should be a left join. 
                            Note it could be a right join. However, I like to think left to right as if I am writing a sentence so going with  left join 
                            is ideal.  


    


    using a join:
    - if a customer has not placed any orders, which many be more common than you think,
    - then two query executions are made to the server because the first query does 
    - not return anything.  It's obvious this may waste time but lets compare by running
    - MySQL UNIT TESTS
    -
    - 1st query: SELECT * FROM customers JOIN orders ON (Customers.CustomerID = Orders.CustomerID) WHERE customers.CustomerID = 1
            result:  MySQL returned an empty result set (i.e. zero rows). (Query took 0.0023 seconds.)

    - 2nd query: SELECT * FROM customers WHERE CustomerID = 1;
            result:  MySQL returned an empty result set (i.e. zero rows). (Query took 0.0012 seconds.)

    - limit in queries: same query performs 20-33% better when were expecting one result
        SELECT * FROM customers WHERE CustomerID = 1 LIMIT 1;
        result:  MySQL returned an empty result set (i.e. zero rows). (Query took 0.0008 seconds.)

        MySQL returned an empty result set (i.e. zero rows). (Query took 0.0016 seconds.)
        SELECT * FROM customers JOIN orders ON (Customers.CustomerID = Orders.CustomerID) WHERE customers.CustomerID = 1 

    using a left join:
    - we only need to run one query to find out this customer has not placed any orders.
        Showing rows 0 - 0 (1 total, Query took 0.0020 seconds.)
        SELECT * FROM customers LEFT JOIN orders ON (Customers.CustomerID = Orders.CustomerID) WHERE customers.CustomerID = 1
    - the join takes the same amount of time.


*/
                $customer_id = $_GET['customer-orders'];
                $customer_orders = $this->customer_model->getCustomerOrder($customer_id);
                $customer = null;

                if(sizeof($customer_orders) > 0) 
                {
                    $customer = $customer_orders[0];
                }
                else 
                {
                    $customer = $this->customer_model->getCustomer($customer_id)[0];
                }



                include 'view/templates/header.php';
                include 'view/pages/customer-orders.php';
                include 'view/templates/footer.php';
            }

            if (isset($_GET['customers']))
            {
                $customers = $this->customer_model->all();
                include 'view/templates/header.php';
                include 'view/pages/customers.php';
                include 'view/templates/footer.php';
            }

            if (isset($_GET['documentation']))
            {
                include 'view/templates/header.php';
                include 'view/pages/documentation.php';
                include 'view/templates/footer.php';
            }

            if (isset($_GET['query-builder']))
            {
                include 'view/templates/header.php';
                include 'view/pages/query-builder.php';
                include 'view/templates/footer.php';
            }

            if (isset($_GET['uml']))
            {
                include 'view/templates/header.php';
                include 'UML.html';
                include 'view/templates/footer.php';
            }


        }
    }

    private function post_request_handler()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {

            if (isset($_POST['reset-customers']))
            {
                include_once('Elegant/Database.php');
                $db_handler = new Database();
                $q = file_get_contents('sql/resetCustomers.sql');
                $db_handler->query($q);
                $db_handler->execute();
                $this->redirect();             
            }

            if(isset($_POST['insert-customer']))
           {
            
               $customer_name = $_POST['CustomerName'];
               $contact_name  = $_POST['ContactName'];
               $address       = $_POST['Address'];
               $city          = $_POST['City'];
               $postal_code   = $_POST['PostalCode'];
               $country       = $_POST['Country'];
               

               

               $customer = $this->customer_model->where('Address','=',$address)->where('CustomerName','=',$customer_name)->get()[0];
               $not_duplicate_entry = $customer == NULL;

               // all fields are required in form otherwise form won't fire 
               // note this is different for customer-orders since all fields do not have to be filled.
               $this->customer_model->CustomerName = $customer_name;
               $this->customer_model->ContactName  = $contact_name;
               $this->customer_model->Address      = $address;
               $this->customer_model->City         = $city;
               $this->customer_model->PostalCode   = $postal_code;
               $this->customer_model->Country      = $country;

               if( $not_duplicate_entry )
               {
                    $this->customer_model->save();
               }
               else
               {
                   // assume they're trying to update if the name and address are the same
                   $this->customer_model->where('CustomerID', '=', $customer->CustomerID)->save();
               }

               $this->redirect();

           }

            $this->putAndDeleteRequestHandler();         
        }

    }

    private function putAndDeleteRequestHandler()
    {
        if ( !isset($_POST['_method']) )
        {
            return 0;
        }
        



        $request_method = $_POST['_method'];




        /**********************************************************************
                                     PUT REQUESTS
        ***********************************************************************/
        if ( $request_method === 'PUT')
        {
            if ( isset($_POST['update-viewbook']) )
            { // the form's submit button was pressed

                if(isset($_POST['book_description']))
                {
                    $this->book_model->description = $_POST['book_description'];
                    $this->book_model->where('title','=',$_GET['book'])->save();
                }
                $book = $this->book_model->getBook($_GET['book']);
                include 'view/templates/header.php';
                include 'view/pages/viewbook.php';
                include 'view/templates/footer.php';
            }
        } // @end PUT



        /**********************************************************************
                                     DELETE REQUESTS
        ***********************************************************************/
        else if( $request_method === 'DELETE')
        {
            if ( isset($_POST['delete-customer']) )
            { 

                $customer_id = $_POST['CustomerID'];
                $this->customer_model->deleteCustomer($customer_id);
                $this->redirect();
               
            }

        }// @end DELETE






    } // @end putAndDeleteRequestHandler()

    private function redirect() 
    {
        ob_start();
        header('Location: '. $this->base_url());
        ob_end_flush();
        die();
    }

    private function base_url()
    {
        return 'http://'.$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
    }
}

?>