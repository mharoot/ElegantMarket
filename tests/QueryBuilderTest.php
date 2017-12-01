<?php
//in command line run: 
// phpunit --bootstrap model/Book.php tests/BookTest.php --testdox
// phpunit --bootstrap model/*.php tests/*.php --testdox
// phpunit --bootstrap model/*.php tests/QueryBuilderTest.php --testdox
// phpunit --bootstrap Elegant/QueryBuilder.php tests/QueryBuilderTest.php --testdox

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
include_once('Elegant/QueryBuilder.php');

class QueryBuilderTest extends TestCase
{

    public function test_one_to_many_where_where_where_update()
    {
        $expected_query = 'UPDATE (orders LEFT JOIN orderdetails ON orders.OrderID=orderdetails.OrderID) SET orders.ShipperID = :orders.ShipperID, orderdetails.Quantity = :orderdetails.Quantity WHERE orders.OrderID=:OrderID  AND orderdetails.OrderID=:OrderID  AND orderdetails.OrderDetailID=:OrderDetailID ';
        $table_name = 'orders';
        $queryBuilder = new QueryBuilder($table_name);
        $col_val_pairs = ['orders.ShipperID' => 2, 'orderdetails.Quantity' => 2]; /// bind may not work for these cause of orders. and orderdetails.  ...
        $actual_query = $queryBuilder->oneToMany('orderdetails','OrderID', 'OrderID')
                                ->where('orders.OrderID','=')
                                ->where('orderdetails.OrderID','=')
                                ->where('orderdetails.OrderDetailID','=')
                                ->update( $col_val_pairs  );

        $this->assertEquals( $expected_query, $actual_query);
    }
    
    /*
    public function test_all()
    {
        $table_name = 'books';
        $queryBuilder = new QueryBuilder($table_name);
        $this->assertEquals($queryBuilder->all(), 'SELECT * FROM '.$table_name);
    }
    */
/*  this test only runs when i turn QueryBuilder->query into public, it passed and is no longer needed
    public function test_select()
    {
        $table_name    = 'books';
        $queryBuilder  = new QueryBuilder($table_name);
        $qbQuery       = $queryBuilder->select()->query;

        $this->assertEquals($qbQuery, 'SELECT * FROM '.$table_name);
    }

    public function test_select_w_params()
    {
        $table_name    = 'books';
        $queryBuilder  = new QueryBuilder($table_name);
        $selected_cols = ['book_id', 'title', 'description'];
        $qbQuery       = $queryBuilder->select($selected_cols)->query;

        $this->assertEquals($qbQuery, 'SELECT book_id, title, description FROM '.$table_name);
    }
*/

/*
    public function test_where_get()
    {
        $table_name = 'books';
        $queryBuilder = new QueryBuilder($table_name);
        $qbQuery = $queryBuilder->where('id','=')->get();
        // echo '| String qbQuery = "'.$qbQuery.'"; |'; // do a --verbose dump
        $query   = "SELECT * FROM books WHERE id=:id ";
        $this->assertEquals( $qbQuery, $query);
    }

    public function test_where_chain_get()
    {
        $table_name = 'books';
        $queryBuilder = new QueryBuilder($table_name);
        $qbQuery = $queryBuilder->where('id','=')->where('genre_id', '=')->get();
        $query   = "SELECT * FROM ".$table_name." WHERE id=:id  AND genre_id=:genre_id ";
        $this->assertEquals( $qbQuery, $query);

    }


    // public function test_one_to_many_get(){}

    public function test_many_to_many_get()
    {
        $foreign_table_name        = 'authors';
        $foreign_table_primary_key = 'author_id';
        $junction_table_name       = 'books_authors';
        
        $primary_table_name        = 'books';
        $primary_table_primary_key = 'book_id';
        $queryBuilder = new QueryBuilder($primary_table_name);
        
        $qbQuery = $queryBuilder->manyToMany( $foreign_table_name, $junction_table_name, $foreign_table_primary_key, $foreign_table_primary_key)->get();

        $q = 'SELECT * FROM books JOIN books_authors ON (books.author_id=books_authors.author_id) JOIN authors ON (books_authors.author_id=authors.author_id)';

        $this->assertEquals($qbQuery, $q);
        
    }


    public function test_one_to_one_get()
    {
        $primary_table_name = 'books';
        $foreign_table_name = 'genres';
        $primary_key = 'genre_id';
        $foreign_key = 'id';
        $queryBuilder = new QueryBuilder($primary_table_name);
        $qbQuery = $queryBuilder->oneToOne($foreign_table_name, $primary_key , $foreign_key)->get();
        $query   = 'SELECT * FROM books JOIN genres ON books.genre_id=genres.id';
        $this->assertEquals( $qbQuery, $query);
    }

    

    public function test_update()
    {
        $primary_table_name = 'books';
        $primary_key = 'book_id';
        $queryBuilder = new QueryBuilder($primary_table_name);
        $col_val_pairs = ['title' => 'The Algorithm Design Manual', 'description' => "Cool book dude!"];
        $qbQuery = $queryBuilder->where($primary_key,'=')->update($col_val_pairs);
        $query = "UPDATE books SET title = :title, description = :description WHERE book_id=:book_id ";
        $this->assertEquals( $qbQuery, $query);
    }


    public function test_insert()
    {
        $primary_table_name = 'customers';
        $primary_key = 'id';
        $queryBuilder = new QueryBuilder($primary_table_name);
        $col_val_pairs = ['name' => 'Craig Walker', 'address' => "1641 Daily Circle, Glendale Ca, 91208"];
        $qbQuery = $queryBuilder->insert($col_val_pairs);
        $query = "INSERT INTO customers ( name, address ) VALUES ( :name, :address )";
        $this->assertEquals( $qbQuery, $query);
    }

    public function test_one_to_many_get()
    {
        $primary_table_name = 'customers';
        $foreign_table_name = 'orders';
        $primary_key = 'id';
        $foreign_key = 'customer_id';
        $queryBuilder = new QueryBuilder($primary_table_name);
        $qbQuery = $queryBuilder->oneToMany($foreign_table_name, $primary_key , $foreign_key)->get();
        $query   = 'SELECT * FROM  (customers JOIN orders ON customers.id=orders.customer_id) ';
        $this->assertEquals( $qbQuery, $query);
    } 

    public function test_inner_join() 
    {
        $primary_table_name = 'customers';
        $foreign_table_name = 'orders';
        $primary_key = 'Customers.CustomerID';
        $op = '=';
        $foreign_key = 'Orders.CustomerID';
        $queryBuilder = new QueryBuilder($primary_table_name);
        $qbQuery = $queryBuilder->innerJoin($foreign_table_name)->on($primary_key,$op,$foreign_key)->get();
        $query   = 'SELECT * FROM customers INNER JOIN orders ON Customers.CustomerID = Orders.CustomerID';
        $this->assertEquals($qbQuery, $query);
    } 

    public function test_left_join() 
    {
        $primary_table_name = 'customers';
        $foreign_table_name = 'orders';
        $primary_key = 'Customers.CustomerID';
        $op = '=';
        $foreign_key = 'Orders.CustomerID';
        $queryBuilder = new QueryBuilder($primary_table_name);
        $qbQuery = $queryBuilder->leftJoin($foreign_table_name)->on($primary_key,$op,$foreign_key)->get();
        $query   = 'SELECT * FROM customers LEFT JOIN orders ON Customers.CustomerID = Orders.CustomerID';
        $this->assertEquals($qbQuery, $query);
    } 


    public function test_full_join() 
    {
        $primary_table_name = 'customers';
        $foreign_table_name = 'orders';
        $primary_key        = 'CustomerID';
        $op                 = '=';
        $foreign_key        = 'CustomerID';
        $queryBuilder       = new QueryBuilder($primary_table_name);

        $qbQuery = $queryBuilder->fullJoin($foreign_table_name, $primary_key, $op, $foreign_key)->get();
        $query   = 'SELECT * FROM customers LEFT JOIN orders ON customers.CustomerID=orders.CustomerID UNION SELECT * FROM customers RIGHT JOIN orders ON customers.CustomerID=orders.CustomerID';
        
        $this->assertEquals($qbQuery, $query);
    } 
    public function test_full_join_order_by_OrderID()
    {
        $primary_table_name = 'customers';
        $foreign_table_name = 'orders';
        $primary_key        = 'CustomerID';
        $op                 = '=';
        $foreign_key        = 'CustomerID';
        $queryBuilder       = new QueryBuilder($primary_table_name);

        // some statements are ambigeous
        $qbQuery = $queryBuilder->fullJoin($foreign_table_name, $primary_key, $op, $foreign_key)->orderBy('OrderID', false)->get();
        $query = 'SELECT * FROM customers LEFT JOIN orders ON customers.CustomerID=orders.CustomerID UNION SELECT * FROM customers RIGHT JOIN orders ON customers.CustomerID=orders.CustomerID ORDER BY OrderID ASC';
        $this->assertEquals($qbQuery, $query);
    }



    public function test_limit_get(){
        $primary_table_name = 'customers';
        $queryBuilder = new QueryBuilder($primary_table_name);
        $qbQuery = $queryBuilder->limit(0,5)->get();
        $query   = 'SELECT * FROM customers LIMIT 0,5';
        $this->assertEquals( $qbQuery, $query);
    }

    public function test_order_by_get(){
        $primary_table_name = 'customers';
        $col = 'CustomerName';
        $queryBuilder = new QueryBuilder($primary_table_name);
        $qbQuery = $queryBuilder->orderBy($col,false)->get();
        $query   = 'SELECT * FROM customers ORDER BY CustomerName ASC';
        $this->assertEquals( $qbQuery, $query);
    }

    public function test_right_join() 
    {
        $primary_table_name = 'customers';
        $foreign_table_name = 'orders';
        $primary_key = 'Customers.CustomerID';
        $op = '=';
        $foreign_key = 'Orders.CustomerID';
        $queryBuilder = new QueryBuilder($primary_table_name);
        $qbQuery = $queryBuilder->rightJoin($foreign_table_name)->on($primary_key,$op,$foreign_key)->get();
        $query   = 'SELECT * FROM customers RIGHT JOIN orders ON Customers.CustomerID = Orders.CustomerID';
        $this->assertEquals($qbQuery, $query);
    } 
    */
}
?>