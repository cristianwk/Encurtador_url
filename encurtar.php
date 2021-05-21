<?php  

/*
Autor: Cristian Marques 
Data: 20/05/2021                                        
*/


include 'config.php';
include 'hash.php';

if (isset($_POST['url'])) { 
	//echo"<br>url: ".$_POST['url'];
	$url=htmlspecialchars(strip_tags($_POST['url']));
	$ip=$_SERVER['REMOTE_ADDR'];
	$encurtado=Gerar(10);

	$busc=$con->prepare("select * from url where endereco='{$url}'");
	$busc->execute();
	//echo"<br>sql: <pre>";print_r($busc);echo"</pre>";

	if ($busc->rowCount()<1) {
		//O campo status refere-se ao prazo de validade 
		$ins=$con->prepare("insert into url(endereco,encurtado,status, acessos) values('{$url}','{$encurtado}','{30}','{NULL}')");
		$ins->execute();
//echo"<pre>";print_r($ins);echo"</pre>";
		if ($ins) {echo"<br>inserindo..";
			$busc=$con->prepare("select * from url where encurtado='{$encurtado}'");
			//echo"<br>busc: <pre>";print_r($busc);echo"</pre>"."<br>encurtado: ".$encurtado;
			$busc->execute();

			if ($busc->rowCount()>0) {
				echo "<br>Link encurtado: <a href='?url=".$encurtado."'>".$_SERVER['SERVER_NAME']."?url=".$encurtado."</a>";
				echo "<br>Link Banco: <a href='?url=https://br540.hostgator.com.br:2083/cpsess0902314493/3rdparty/phpMyAdmin/sql.php?server=1&db=cons0645_urls&table=url&pos=0'></a>";
				echo "<br>Usuario do banco: cons0645";
				echo "<br>Senha: egs4J4O63y";
			}else{
				echo "error";
			}
		}else{
			echo "error";
		}
	}else{
		while ($linha=$busc->fetch(PDO::FETCH_ASSOC)) {
			$id=$linha['url_id'];
			$link=$linha['endereco'];
			$enc=$linha['encurtado'];
		}
		echo "<a href='?url=".$enc."'>".$_SERVER['SERVER_NAME']."?url=".$enc."</a>";

	}
}else{
	echo "error";
}


?>