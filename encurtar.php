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
	$encurtado=Gerar(8);

	$busc=$con->prepare("select * from url where endereco='{$url}'");
	$busc->execute();
	//echo"<br>sql: <pre>";print_r($busc);echo"</pre>";

	if ($busc->rowCount()<1) {
		$ins=$con->prepare("insert into url(endereco,encurtado,acessos) values('{$url}','{$encurtado}','{NULL}')");
		$ins->execute();
//echo"<pre>";print_r($ins);echo"</pre>";
		if ($ins) {echo"<br>inserindo..";
			$busc=$con->prepare("select * from url where encurtado='{$encurtado}'");
			//$busc->bindValue(':e',$encurtado);
			//echo"<br>busc: <pre>";print_r($busc);echo"</pre>"."<br>encurtado: ".$encurtado;
			$busc->execute();

			if ($busc->rowCount()>0) {
				echo "<br>Link encurtado: <a href='?url=".$encurtado."'>".$_SERVER['SERVER_NAME']."?url=".$encurtado."</a>";
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