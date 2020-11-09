<?php
// index.php

include('connection.php');

if(!isset($_SESSION['type']))
{
    header("location: login.php");
}

include('header.php');

?>