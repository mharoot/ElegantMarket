<div class="jumbotron">
<h2> Customer's Orders</h2>
<table class="table table-hover">
	<thead>
      <tr>
        <th>CustomerID</th>
        <th>OrderID</th>
        <th>OrderDetailID</th>
      </tr>
    </thead>
</table>

<?php var_dump($customers[0]->CustomerID);?>
</br>	
<?php var_dump($customers[1]->CustomerID);?>
</br>
<?php echo sizeof($customers)?>
</div>