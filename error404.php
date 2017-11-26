<h1> Error 404 </h1>
<p>
<?php
session_start();
if ( isset($_SESSION['message']) )
    echo $_SESSION['message'];
session_write_close();
?>
</p>