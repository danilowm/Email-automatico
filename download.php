<?php
session_start();
if(!$_SESSION['logado']){
	die("Acesso restrito");
}
?>
<?php
if( isset( $_GET['arquivo'] ) ){
	$arquivo = "log_email/log.php";
		
	// Seta os cabe�alhos
	header( "Pragma: public" );
	header( "Expires: 0" );
	header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
	header( "Cache-Control: private",false );
	header( "Content-Type: application/octet-stream" );
	
	// A linha abaixo � respons�vel por dizer que o arquivo � para download
	header( "Content-Disposition: attachment; filename=log.csv;");
	
	header( "Content-Transfer-Encoding: binary" );
	header( "Content-Length: ".filesize($arquivo));
	
	// L� e escreve o conte�do do arquivo para o buffer de sa�da
	readfile($arquivo);
	
	exit;
} else {
	// Para dar um erro 404 de arquivo n�o encontrado
	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
	header("Status: 404 Not Found");
	
	// Se as duas linhas acima n�o der um erro 404 exibe a mensagem abaixo
	die("Arquivo n�o encontrado");
}
?>
