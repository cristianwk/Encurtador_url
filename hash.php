<?php  

/*
Autor: Cristian Marques 
Data: 20/05/2021                                        
*/

function Gerar($valor){
	$keys='aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ0123456789';
	$q=strlen($keys);
	$q--;
	$hash=null;
	//Mínimo de 5 e máximo de 10 caracteres.
	for($i=5;$i<=$valor;$i++){
		$p=rand(0,$q);$hash.=substr($keys,$p,1);
	}
	return $hash;
}

?>