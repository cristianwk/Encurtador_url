<?php  

/*
Autor: Cristian Marques 
Data: 20/05/2021                                        
*/


$dbusername='cons0645_admin';
$dbpassword='admin';
$dbhost='br540.hostgator.com.br';
$dbname='cons0645_urls';

$var='mysql:host='.$dbhost.';dbname='.$dbname;
$con = new PDO($var,$dbusername,$dbpassword);

?>