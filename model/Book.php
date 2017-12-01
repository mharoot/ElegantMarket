<?php
declare(strict_types=1);

include_once("Elegant/Model.php");

class Book extends Model {


	/* 
		Every instance of a model should have properties like table_name, primary key, etc;
		Before the parent::__construct().
	*/
	public function __construct()  
	{  
			$this->table_name = 'books';
			parent::__construct($this);

	}

	public function deleteByTitle($title)
	{
		return $this->where('title','=', $title)->delete();
	}


	public function getBookList()
	{

        $select_cols = array('author_name', 'description', 'title');
        $books = $this->manyToMany('authors','books_authors','book_id','author_id')
                      ->get($select_cols);
		
		$result = array();
		$authors = [];
		
		foreach ( $books as $book )
		{
			$key = $book->title;	
			if ( !isset($result[$key]) )
			{
				$result[$key] = array();
				array_push( $result[$key], 
					[
						'title'   => $book->title,
						'authors' => array($book->author_name),
						'description' => $book->description
					]
				);

			} 
			else // collison tac on to authors array
			{

				array_push($result[$key][0]['authors'], $book->author_name);

			}
			
		}
		
		
		
		return $result;

		
	}
	
	public function getBook($title)
	{
        return $result = $this->oneToOne('genres','genre_id','id')
                              ->manyToMany('authors', 'books_authors','book_id','author_id')
                              ->where('title', '=', $title)
                              ->get();   
	}

	public function genre()
	{
		return $result = $this->oneToOne('genres','genre_id','id')->get();   
	}
	
	
}

?>