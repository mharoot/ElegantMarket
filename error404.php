<?php

echo "ERROR 404";

session_start();
echo '</br>'.$_SESSION['error-message'];
session_write_close();
