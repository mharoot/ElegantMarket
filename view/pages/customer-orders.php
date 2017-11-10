<div class="jumbotron">
<h1> <?php echo $customer->CustomerName?>'s Customer Info</h1>
<ul>
<li>
<p>CustomerID: <?php echo $customer->CustomerID?></p>
</li>
<li>
<p>ContactName: <?php echo $customer->ContactName?></p>
</li>
<li>                  
<p>Address: <?php echo $customer->Address.', '.$customer->City.', '.$customer->PostalCode.', '.$customer->Country;?></p>
</li>

</ul>

<?php 
if(sizeof($customer_orders) > 0) 
{ 
?>
<h2> <?php echo $customer->CustomerName?>'s Orders</h2>
<table class="table table-hover">
	<thead>
      <tr>
        <th>OrderID</th>
        <th>EmployeeID</th>
        <th>OrderDate</th>
        <th>ShipperID</th>
      </tr>
    </thead>
    <?php foreach ($customer_orders as $c) { ?>
    <tr>
      <td><p><?php echo $c->OrderID ?></p></td>
      <td><p><?php echo $c->EmployeeID ?></p></td>
      <td><p><?php echo $c->OrderDate ?></p></td>
      <td><p><?php echo $c->ShipperID ?></p></td>
    </tr>
    <?php } ?>
</table>
<?php 
} 
else
{
?>
<h2> <?php echo $customer->CustomerName?> has not placed any orders.</h2>
<?php
}
?>
</br>	

</br>

</div>