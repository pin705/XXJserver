<?php
$sqlname='root';
$sqlpass=''; // Default for local, was '6f7f374baf6fd4d4'
$dbhost='127.0.0.1'; // Default for local, was '103.149.252.61'
$dbname='game';
$dsn="mysql:host=$dbhost;dbname=$dbname;";
$dblj = new PDO($dsn,$sqlname,$sqlpass,array(PDO::ATTR_PERSISTENT=>true));
$dblj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dblj->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$dblj->query("SET NAMES utf8mb4");
?>