<?php
session_start();
require( dirname(__FILE__) . '/lib/openid/openid.php');

$openid = unserialize($_SESSION['openid']);
?>
                <html>
            <head>
                <link href='style.css' rel='stylesheet' type='text/css'>
            </head>
            <body>
                <h1>More information</h1>
<a href='index.php'>Back to index</a>

<?
$attrib = $openid->getAttributes();
echo "<pre>";
print_r($attrib);
echo "</pre>";

?>
