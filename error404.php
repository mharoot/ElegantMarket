<h1> Error 404 </h1>
<p>
<?php
session_start();
if ( isset($_SESSION['error_message']) )
    echo $_SESSION['error_message'];
session_write_close();
?>
</p>