
<h2>In order to run tests on linux/mac use the following commands:</h2>
</br>
<h3>QueryBuilderTest</h3>
<code>
phpunit --bootstrap  Elegant/QueryBuilder.php tests/QueryBuilderTest.php --testdox
</code>
</br>
<h3>BookTest</h3>
<code>
phpunit --bootstrap  model/Book.php tests/BookTest.php --testdox
</code>
</br></br>

<h2>In order to run tests on windows use the following commands:</h2>
</br>
<h3>Query Builder Test</h3>
<code>
phpunit --bootstrap c:/xampp/htdocs/github/Elegant-Bookstore/Elegant/QueryBuilder.php tests/QueryBuilderTest.php --testdox
</code>
</br>
<h3>Book Test</h3>
<code>
phpunit --bootstrap c:/xampp/htdocs/github/Elegant-Bookstore/model/Book.php tests/BookTest.php --testdox
</code>
</br>
<h3>Customer Test</h3>
<code>
phpunit --bootstrap c:/xampp/htdocs/github/Elegant-Bookstore/model/Customer.php tests/CustomerTest.php --testdox 
</code>
</br></br>

<h2>Debugging in Terminal</h2>

<p>change --testdox to --verbose and use either var_dump($object);</p>
<p>or </p>
<code>
echo '| String qbQuery = "'.$qbQuery.'"; |'; // do a dump replace --testdox 
</code>
</br></br>
<code>phpunit --bootstrap c:/xampp/htdocs/github/Elegant-Bookstore/model/Book.php tests/BookTest.php --testdox
</code>

<code>phpunit --bootstrap c:/xampp/htdocs/github/Elegant-Bookstore/model/Book.php tests/BookTest.php --verbose 
</code>
