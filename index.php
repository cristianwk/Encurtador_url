<?php  

/*
Encurtador de URL
Seu serviço irá receber inicialmente como parâmetro uma URL que deverá ser encurtada 
seguindo as seguintes regras:

Mínimo de 5 e máximo de 10 caracteres.
Apenas letras e números.
Retornar apenas a url gerada, respeitando códigos HTTP.
A url retornada deverá ser salva no banco de dados e possuir um prazo de validade 
você poderá escolher quanto tempo.
                                        
*/


include 'config.php';

if (isset($_GET['url'])) {
	$url=htmlspecialchars(strip_tags($_GET['url']));
	$busc=$con->prepare('select * from url where encurtado=:e');
	$busc->bindValue(':e',$url);
	$busc->execute();

	if ($busc->rowCount()>0) {
		while ($linha=$busc->fetch(PDO::FETCH_ASSOC)) {
			$id=$linha['url_id'];
			$link=$linha['endereco'];
			$encurtado=$linha['encurtado'];
			$acessos=$linha['acessos'];
		}
		$acessos=$acessos+1;
		$upd=$con->prepare('update endereco set acessos=:a where url_id=:i');
		$upd->bindValue(':a',$acessos);
		$upd->bindValue(':i',$id);
		$upd->execute();
		echo "<script>window.location='".$link."'</script>";
	}else{
		echo "<script>alert('Url não encontrada em nosso banco de dados');</script>";
	}
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Encurtador de Url</title>
	<meta charset="utf-8" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
</head>
<style type="text/css">
	body{background:#f8f8f8;margin:0;}
	input[type='url']{border:1px solid #ddd;padding:6px;width:250px;margin:10px;border-radius:2px;}
	input[type='submit']{border:none;background:#222;color:#fff;padding:6px;border-radius:2px;}
	img{width:80px;height:80px;display:none;}
	#status{font-family:arial;font-size:15px;}
</style>
<body>
<center>
	<script type="text/javascript">
		function encurtar(){
			var url = $('#url').val();alert(url);
			var encurtando = $.post('encurtar.php', {url:url});
			$('img').show();
			encurtando.done(function(data){
				$('img').hide();
				if (data == 'error') {
					$('#status').empty().append('Ocorreu um erro ao encurtar a url');
				}else{
					$('#status').empty().append('Url encurtada com sucesso: ' + data);
				}
			});	
		}
	</script>
	<form method="post" onsubmit="encurtar();return false;">
		<input type="url" name="url" id="url" placeholder="Coloque a url que deseja encurtar.." autocomplete="off" /><input type="submit" value=">>" /><br>
		<img id="img" src="timer.gif" />
		<div id="status"></div>
	</form>
</center>
</body>
</html>