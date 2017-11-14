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
    /*
    public function test_all()
    {
        $table_name = 'books';
        $queryBuilder = new QueryBuilder($table_name);
        $this->assertEquals($queryBuilder->all(), 'SELECT * FROM '.$table_name);
    }
    */
    public function test_many_to_many_where_get()
    {
        $ft   = 'products';
        $ftpk = 'ProductID';
        $jt   = 'orderdetails';
        $ptpk = 'OrderID';
        $pt   = 'orders';

        $queryBuilder = new QueryBuilder($pt);
        
        $qbQuery = $queryBuilder->manyToMany( $ft, $jt, $ptpk, $ftpk)->get();

        $q = 'SELECT * FROM orders JOIN orderdetails ON (orders.OrderID=orderdetails.OrderID) JOIN products ON (products.ProductID=orderdetails.ProductID)';

        $this->assertEquals($qbQuery, $q);
        
    }

    public function test_many_to_many_where_delete()
    {
        $ft   = 'products';
        $ftpk = 'ProductID';
        $jt   = 'orderdetails';
        $ptpk = 'OrderID';
        $pt   = 'orders';
        $ptpkValue = 10248;

        $queryBuilder = new QueryBuilder($pt);
        
        $qbQuery = $queryBuilder->manyToMany( $ft, $jt, $ptpk, $ftpk)->where($pt.'.'.$ptpk, '=', $ptpkValue)->delete();

        $q = 'DELETE orders, orderdetails FROM orders JOIN orderdetails ON (orders.OrderID=orderdetails.OrderID) JOIN products ON (products.ProductID=orderdetails.ProductID) WHERE orders.OrderID=:OrderID ';

        $this->assertEquals($qbQuery, $q); 

    }
/*

    public function test_join_chain()
    {
        $queryToMatch = 'SELECT * FROM customers JOIN orders ON (customers.CustomerID=orders.CustomerID) JOIN orderdetails ON (orders.OrderID=orderdetails.OrderID)';
        $queryBuilder = new QueryBuilder('customers');

        // two joins chained together
        $qbQuery      = $queryBuilder->join('orders', 'customers.CustomerID', 'orders.CustomerID')
                                     ->join('orderdetails', 'orders.OrderID', '=', 'orderdetails.OrderID')
                                     ->get();

        $this->assertEquals($qbQuery, $queryToMatch);

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
        $query   = 'SELECT * FROM customers JOIN orders ON customers.id=orders.customer_id';
        $this->assertEquals( $qbQuery, $query);
    }    
*/
}
?>