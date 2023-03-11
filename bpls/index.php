<?php
include('php/connect.php');
session_start();
if(isset($_SESSION['signed_in']) == true)
{
  header("location:../../index.php");
}else{
  header("location:../../login.php");
}
?>