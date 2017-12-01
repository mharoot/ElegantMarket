<?php
//in command line run: 
//phpunit --bootstrap model/Book.php tests/BookTest.php --testdox
//declare(strict_types=1);

use PHPUnit\Framework\TestCase;
include_once('model/Book.php');

class BookTest extends TestCase
{








/*************************************************
 * PASSING TESTS
 * ***********************************************
 */
/*
    public function test_book_all_function()
    {
        $book = new Book();
        $this->assertTrue(sizeof($book->all()) > 0);
    }



    public function test_one_to_one_get_all_function()
    {
        $book = new Book();
        $result = $book->oneToOne('genres', 'genre_id', 'genre_id')->get();
        $this->assertTrue(sizeof($result) > 0);
    }

    public function test_one_to_one_get_cols_function()
    {
        $cols = array('title', 'description', 'genre_name');
        $book = new Book();
        $result = $book->oneToOne('genres','genre_id','genre_id')->get($cols);
        $this->assertTrue(sizeof($result) > 0);
    }

    public function test_one_to_one_get_cols_where_function()
    {
        $cols = array('title', 'description', 'genre_name');
        $book = new Book();
        $result = $book->oneToOne('genres','genre_id','genre_id')
                       ->where('genres.genre_id', '=', '1')
                       ->get($cols);
        $this->assertTrue(sizeof($result) > 0);
    }


    public function test_one_to_one_get_cols_where_chain_function()
    {
        $selected_cols = array('title', 'description', 'genre_name');
        $book = new Book();
        $pk = 'genre_id';
        $fk = $pk;

        $result = $book->oneToOne('genres', $pk, $fk)
                       ->where('genres.genre_id', '=', '1')
                       ->where('title', '=','The Algorithm Design Manual')
                       ->get($selected_cols);

        $this->assertTrue( sizeof($result) > 0 );
    }


    public function test_one_to_one_get_cols_where_or_where_chain_function()
    {
        $cols = array('title', 'description', 'genre_name');
        $book = new Book();
        $result = $book->oneToOne('genres','genre_id','genre_id')->where('genres.genre_id', '=', '1')->orWhere('title', '=','The Algorithm Design Manual')->get($cols);
        $this->assertTrue(sizeof($result) > 0);
    }


    
    public function test_one_to_one_get_cols_or_where_or_where_chain_function()
    {
        $cols = array('title', 'description', 'genre_name');
        $book = new Book();
        $result = $book->oneToOne('genres','genre_id','genre_id')
                       ->orWhere('genres.genre_id', '=', '1')
                       ->orWhere('title', '=','The Algorithm Design Manual')
                       ->get($cols);
        $this->assertTrue(sizeof($result) > 0);
    }


    public function test_many_to_many_get_function()
    {
        $book = new Book();
        $result = $book->getBookList();
        $this->assertTrue(sizeof($result) > 0);
    }

    public function test_many_to_many_get_cols_function()
    {
        $cols = array('title', 'description', 'author_name'); // genres is not included in this many to many join
        $book = new Book();
        $result = $book->manyToMany('authors','books_authors','book_id','author_id')->get($cols);
        $this->assertTrue(sizeof($result) > 0);
    }

    public function test_one_to_one_with_many_to_many_get_cols_function()
    {
        $cols = array('title', 'description', 'author_name', 'genre_name');
        $book = new Book();
        $result = $book->oneToOne('genres','genre_id','genre_id')->manyToMany('authors','books_authors','book_id','author_id')->get($cols);
        $this->assertTrue(sizeof($result) > 0);
    }

    public function test_where_update()
    {
        $primary_key = 'book_id';
        $book = new Book();
        $book->title = 'The Algorithm Design Manual';
        $book->description = 'Cool book dude!';
        $result = $book->where($primary_key,'=','1')->save();
        $this->assertTrue($result);
    }
    
    public function test_insert()
    {
        $book = new Book();
        $book->title = 'The Algorithm Design Manual 2nd edition';
        $book->description = 'Coolest book dude!';
        $result = $book->save();
        $this->assertTrue($result==TRUE);
    }

    public function test_where_delete()
    {
        $title = 'The Algorithm Design Manual 2nd edition';
        $book = new Book();
        $result = $book->deleteByTitle($title);
        $this->assertTrue($result);
    }

*/
    public function test_one_to_one_delete()
    {
        $book = new Book();
        $result = $book->oneToOne('genres', 'genre_id', 'genre_id')->where('genres.genre_id', '=', 1)->delete();

        // reset database
        include_once('Elegant/Database.php');
        $db_handler = new Database();
        $q = file_get_contents('sql/resetBooks.sql');
        $db_handler->query($q);


        $this->assertTrue($result);
    }


    public function test_one_to_many_delete()
    {
        $book = new Book();
        $result = $book->oneToMany('genres', 'genre_id', 'genre_id')->where('genres.genre_id', '=', 1)->delete();

        // reset database
        include_once('Elegant/Database.php');
        $db_handler = new Database();
        $q = file_get_contents('sql/resetBooks.sql');
        $db_handler->query($q);


        $this->assertTrue($result);
    }


    public function test_reset_books_table()
    {
        include_once('Elegant/Database.php');
        $db_handler = new Database();
        $q = file_get_contents('sql/resetBooks.sql');
        $db_handler->query($q);
        $this->assertTrue($db_handler->execute());
    }

}
?>