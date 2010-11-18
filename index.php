<?php
session_start();
$login = "admin";
$senha = "cjldhoh";
$erro  = "";

if( isset($_POST['login']) && isset($_POST['senha']) ) {
	if( $_POST['login'] == $login && $_POST['senha'] == $senha ) {
		$_SESSION['logado'] = true;
		die( header("Location: ler_csv.php") );
	}
	else {
		$erro = "<strong>Login ou Senha incorretos</strong>";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administração</title>
</head>

<body style="font:12px Verdana, Geneva, sans-serif">

<form name="ler_csv" method="post" action="">
<table align="center">
	<tr>
		<td colspan="2" align="center"><?php echo $erro?></td>
	</tr>
	<tr>
		<td>Login:</td>
		<td><input type="text" name="login" /></td>
	</tr>
	<tr>
		<td>Senha:</td>
		<td><input type="password" name="senha" /></td>
	</tr>
	<tr>
		<td colspan="2"><button type="submit">Entrar</button></td>
	</tr>
</table>
</form>

</body>
</html>