<?php
session_start();
if(!$_SESSION['logado']){
	die("Acesso restrito");
}
?>
<?php
if( isset( $_GET['arquivo'] ) ){
	$arquivo = "log_email/log.php";
		
	// Seta os cabeçalhos
	header( "Pragma: public" );
	header( "Expires: 0" );
	header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
	header( "Cache-Control: private",false );
	header( "Content-Type: application/octet-stream" );
	
	// A linha abaixo é responsável por dizer que o arquivo é para download
	header( "Content-Disposition: attachment; filename=log.csv;");
	
	header( "Content-Transfer-Encoding: binary" );
	header( "Content-Length: ".filesize($arquivo));
	
	// Lê e escreve o conteúdo do arquivo para o buffer de saída
	readfile($arquivo);
	
	exit;
} else {
	// Para dar um erro 404 de arquivo não encontrado
	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
	header("Status: 404 Not Found");
	
	// Se as duas linhas acima não der um erro 404 exibe a mensagem abaixo
	die("Arquivo não encontrado");
}
?>
