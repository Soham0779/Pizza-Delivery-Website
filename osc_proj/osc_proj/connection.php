<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "osc_proj";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{
	die("failed to connect!");
}
