# ElegantMarket
Online Nation Wide E-Commerce Mock Up that demonstrates Elegant Framework features.


#RelationChaining
In this version of elegant it will not be allowed.
The trade off is a better interaction with CRUD operations and a relaion.



<pre>
/*
--------------------------------------------DELETE-------------------------------------------------

CFG for DELETE:

// identifiers ---  http://dev.mysql.com/doc/refman/5.6/en/identifiers.html --------------
ALL_FIELDS	: '.*' ;
schema_name : tmpName=ID {strlen((const char *)$tmpName.text->chars) <= 64}? {printf("schema name = \%s \n",(char*)($tmpName.text->chars));};
table_name  : tmpName=ID {strlen((const char *)$tmpName.text->chars) <= 64}? {printf("table name = \%s \n",(char*)($tmpName.text->chars));};

// optional  = database_name.table_name
// mandatory = table_name
table_spec:
	
	( schema_name DOT )? table_name

;



// delete ------  http://dev.mysql.com/doc/refman/5.6/en/delete.html  ------------------------
delete_statements:
	
	DELETE_SYM (LOW_PRIORITY)? (QUICK)? (IGNORE_SYM)?
	
	( delete_single_table_statement | delete_multiple_table_statement1 | delete_multiple_table_statement2 )

;


delete_single_table_statement:
	
	FROM table_spec
	(partition_clause)?

	(where_clause)?
	(orderby_clause)?

	(limit_clause)?

;
column_list:
	LPAREN column_spec (COMMA column_spec)* RPAREN
;

join_condition:
      (ON expression) | (USING_SYM column_list)
      
table_references:
        table_reference (( COMMA table_reference )?)*
;
table_reference:
	table_factor1 | table_atom
;
table_factor1:
	table_factor2 (  (INNER_SYM | CROSS)? JOIN_SYM table_atom (join_condition)?  )?
;
table_factor2:
	table_factor3 (  STRAIGHT_JOIN table_atom (ON expression)?  )?
;
table_factor3:
	table_factor4 (  (LEFT|RIGHT) (OUTER)? JOIN_SYM table_factor4 join_condition  )?
;
table_factor4:
	table_atom (  NATURAL ( (LEFT|RIGHT) (OUTER)? )? JOIN_SYM table_atom )?
;

'DELETE customers, orders FROM (customers JOIN orders USING (CustomerID) ) WHERE customers.CustomerID = 90':
table_atom:
	  ( table_spec (partition_clause)? (alias)? (index_hint_list)? )
	| ( subquery alias )
	| ( LPAREN table_references RPAREN )
	| ( OJ_SYM table_reference LEFT OUTER JOIN_SYM table_reference ON expression )
;


delete_multiple_table_statement1:

	table_spec (ALL_FIELDS)? (COMMA table_spec (ALL_FIELDS)?)*

	FROM table_references

	(where_clause)?

;


delete_multiple_table_statement2:

	FROM table_spec (ALL_FIELDS)? (COMMA table_spec (ALL_FIELDS)?)*
	
	USING_SYM table_references

	(where_clause)?

; 

----------------------------------------------------------------------------
LEFT MOST DERIVATION FOR 
w= 'DELETE customers, orders FROM customers JOIN orders USING (CustomerID)  WHERE customers.CustomerID = 90':

----------------------------------------------------------------------------
NOTE
----
dropping optional sub strings: (sub_string)? 

or 

including them as needed: sub_string
----------------------------------------------------------------------------


                  => DELETE customers, orders FROM customers JOIN orders USING (CustomerID)  WHERE customers.CustomerID = 90
delete_statements => DELETE_SYM delete_multiple_table_statement1 
                  => DELETE delete_multiple_table_statement1
                 *=> DELETE customers, orders FROM table_references where_clause
                  => DELETE customers, orders FROM table_reference where_clause
                  => DELETE customers, orders FROM table_factor1 where_clause
                  => DELETE customers, orders FROM table_factor2 (  (INNER_SYM | CROSS)? JOIN_SYM table_atom (join_condition)?  )? where_clause
                  => DELETE customers, orders FROM table_factor4 (  (INNER_SYM | CROSS)? JOIN_SYM table_atom (join_condition)?  )? where_clause
                  => DELETE customers, orders FROM table_atom (  NATURAL ( (LEFT|RIGHT) (OUTER)? )? JOIN_SYM table_atom )? (  (INNER_SYM | CROSS)? JOIN_SYM table_atom (join_condition)?  )? where_clause
                  => DELETE customers, orders FROM table_atom JOIN_SYM table_atom join_condition where_clause
                  => DELETE customers, orders FROM table_atom JOIN_SYM table_atom join_condition where_clause
                 *=> DELETE customers, orders FROM customers JOIN orders join_condition where_clause
                 *=> DELETE customers, orders FROM customers JOIN orders USING column_list where_clause
                 *=> DELETE customers, orders FROM customers JOIN orders USING (CustomerID) WHERE customers.CustomerID = 90

</pre>





*/