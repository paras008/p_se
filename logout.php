<?php 
@session_start();
require 'connection.php';

session_unset();
session_destroy(); 
header('Location:index.php');

?>