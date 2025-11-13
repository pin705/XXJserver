<?php
$sqlname='root';
$sqlpass='6f7f374baf6fd4d4';
$dbhost='localhost';
$dbname='game';
$dsn="mysql:host=$dbhost;dbname=$dbname;";
$dblj = new PDO($dsn,$sqlname,$sqlpass,array(PDO::ATTR_PERSISTENT=>true));
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
$dblj->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$dblj->query("SET NAMES utf8mb4");

// Tắt MySQL strict mode để tương thích với code cũ
$dblj->query("SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION'");
?>