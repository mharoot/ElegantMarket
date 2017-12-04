<?php
/*

SUPER CONTROLLER WE ARE NO LONGER USING SEPERATE CONTROLLER FILES.

ALL GET, PUT, DELETE, POST calls go through here for the website
*/
 ini_set('display_errors',1);
 error_reporting(E_ALL);
include_once("model/Customer.php");
include_once("model/Product.php");
include_once("model/J1.php");
include_once("model/J2.php");
class Controller {
    public $customer_model;
    public $product_model;
    public $table_j1;
    public $table_j2;
    public $_routes = ['customer-orders','customers', 'delete-customer', 'insert-customer', 'query-builder', 'reset-customers', 'products', 'product-row-count','products-prev','products-next', 'product-order-desc',
'product-order-by','join-demos'];
    
    public function __construct()  
    {  
        if( $this->customer_model !=null)
        {
            return;
        }
        $this->customer_model = new Customer();
        $this->product_model = new Product();
        $this->table_j1 = new J1();
        $this->table_j2 = new J2();
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

            if (isset($_GET['customer-orders']))
            {
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

            if(isset($_GET['products']))
            {
                
                session_start();
                $_SESSION['product-row-count'] = 5;
                $_SESSION['product-order-by'] = 'ProductID';
                $_SESSION['product-order-desc'] = FALSE;
                $_SESSION['page'] = 1;
                $p = $this->product_model->orderBy($_SESSION['product-order-by'],$_SESSION['product-order-desc'])->paginate(5);
                session_write_close();
                $products = $p[1];
                include 'view/templates/header.php';
                include 'view/pages/products.php';
                include 'view/templates/footer.php';
            }

            if(isset($_GET['join-demos']))
            {
                $j1 = $this->table_j1->all();
                $j2 = $this->table_j2->all();
                $join = $this->table_j1->join('j2')->on('j1.id','=','j2.id')->get();
                $leftJoin = $this->table_j1->leftJoin('j2')->on('j1.id','=','j2.id')->get();
                $rightJoin = $this->table_j1->rightJoin('j2')->on('j1.id','=','j2.id')->get();
                $fullJoin = $this->table_j1->fullJoin('j2','j1.id','=','j2.id')->get();
                $crossJoin = $this->table_j1->crossJoin('j2')->get();

                include 'view/templates/header.php';
                include 'view/pages/join-demos.php';
                include 'view/templates/footer.php';
            }

            if(isset($_GET['products-prev']))
            {
                session_start();
                if($_SESSION['page'] > 1 )
                {
                    $_SESSION['page'] -= 1;
                }
                session_write_close();
                $products = $this->product_model->orderBy($_SESSION['product-order-by'],$_SESSION['product-order-desc'])->paginate($_SESSION['product-row-count'])[$_SESSION['page']];
                include 'view/templates/header.php';
                include 'view/pages/products.php';
                include 'view/templates/footer.php';
            }

             if(isset($_GET['products-next']))
            {
                session_start();
                $p = $this->product_model->orderBy($_SESSION['product-order-by'],$_SESSION['product-order-desc'])->paginate($_SESSION['product-row-count']);
                
                if($p['last_page'] > $_SESSION['page'])
                {
                    $_SESSION['page'] += 1;
                }
                session_write_close();
                $products = $p[$_SESSION['page']];
                include 'view/templates/header.php';
                include 'view/pages/products.php';
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
                $q = file_get_contents('sql/resetCustomersAndOrders.sql');
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
           
            if(isset($_POST['product-row-count']))
            {
                
                
                session_start();
                $_SESSION['product-row-count'] = $_POST['product-row-count'];
                $p = $this->product_model->orderBy($_SESSION['product-order-by'],$_SESSION['product-order-desc'])->paginate($_SESSION['product-row-count']);
                $_SESSION['page'] = 1;
                session_write_close();
                $products = $p[$_SESSION['page']];
                
                include 'view/templates/header.php';
                include 'view/pages/products.php';
                include 'view/templates/footer.php';
            
            }

            if(isset($_POST['product-order-by']))
            {
                
                
                session_start();
                $_SESSION['product-order-by'] = $_POST['product-order-by'];
                $_SESSION['page'] = 1;
                session_write_close();
                $products = $this->product_model->orderBy($_SESSION['product-order-by'],$_SESSION['product-order-desc'])->paginate($_SESSION['product-row-count'])[$_SESSION['page']];
                
                include 'view/templates/header.php';
                include 'view/pages/products.php';
                include 'view/templates/footer.php';
            
            }

            if(isset($_POST['product-order-desc']))
            {
                
                session_start();
                $_SESSION['product-order-desc'] = $_POST['product-order-desc'];
                $_SESSION['page'] = 1;
                session_write_close();
                $products = $this->product_model->orderBy($_SESSION['product-order-by'],$_SESSION['product-order-desc'])->paginate($_SESSION['product-row-count'])[$_SESSION['page']];
                include 'view/templates/header.php';
                include 'view/pages/products.php';
                include 'view/templates/footer.php';
            
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