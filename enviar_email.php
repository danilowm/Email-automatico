<?php
header("Content-Type: text/html; charset=utf-8", true);
/*
** ENVIADOR AUTOMÁTICO DE E-MAILS
** Versão 1.1
** Danilo Iannone (C) 2010
** Hotelwww.com.br
** 
** Instruções:
**
** SEMPRE ENVIAR O FORMULÁRIO COMO: post
**
** CRIAR A PASTA log_email COM PERMISSÃO chmod(777)
**
** A linha de comando abaixo indicará o e-mail do DESTINATÁRIO  # OBRIGATÓRIA #
** <input type="hidden" name="recipient" value="danilowm@gmail.com" />
**
** A linha de comando abaixo indicará o NOME do remetente # OBRIGATÓRIA #
** <input type="text" name="nome" />
**
** A linha de comando abaixo indicará o E-MAIL do remetente # OBRIGATÓRIA #
** <input type="text" name="email" /> 
**
** A linha de comando abaixo indicará a página de retorno  # OBRIGATÓRIA #
** <input type="hidden" name="redirect" value="obrigado.html" />
** Se o campo não existir, o sistema direcionará o visitante para a página de erro 404
**
** A linha de comando abaixo indicará o ASSUNTO do e-mail
** <input type="hidden" name="subject" value="Contato pelo site" />
** OU
** <input type="text" name="assunto" />  # COM ESSA LINHA O VISITANTE DEFINE UM ASSUNTO #
** Se não existir nenhum dos comando acima, será inserida uma mensagem de assunto padrão: CONTATO PELO SITE
** Se existir os dois (02) comandos acima, será exibida a mensagem do campo ASSUNTO
*/

################### EXEMPLO 
################### copiar em arquivo separado!!

/*
<form method="post" name="enviar_email" action="enviar_email.php">
	<input type="hidden" name="subject" value="CONTATO" />
	<input type="hidden" name="redirect" value="obrigado.html" />
	<input type="hidden" name="recipient" value="designer@hotelwww.com.br" />
	<input type="text" name="nome" />
	<input type="text" name="email" />
	<input type="text" name="telefone" />
	<textarea name="mensagem"></textarea>
	<button type="submit">Enviar</button>
</form>
*/

if( isset($_POST) && isset($_POST['recipient']) && isset($_POST['redirect']) ) { foreach ($_POST as $key => $value) { $campo[] = strtolower($key); $valor[] = $value; } } else { die("Erro!<br /><br />Enviador autom&aacute;tico de e-mail!"); }
$totalCampos      = count($campo);
$procuraNome      = array_search("nome", $campo);
$procuraEmail     = array_search("email", $campo);
$procuraAssunto   = array_search("assunto", $campo);
$procuraSubmit    = array_search("submit", $campo);
$procuraSubject   = array_search("subject", $campo);
$procuraRedirect  = array_search("redirect", $campo);
$procuraRecipient = array_search("recipient", $campo);
if( !empty($procuraNome) )      { $nome = $valor[$procuraNome]; }
if( !empty($procuraEmail) )     { $email = $valor[$procuraEmail]; }
if( !empty($procuraRecipient) ) { $recipient = $valor[$procuraRecipient]; }
if( !empty($procuraRedirect) )  { $redirect = $valor[$procuraRedirect]; }
if( empty($procuraAssunto) && empty($procuraSubject) ) { $subject = "Contato pelo site"; }
else if( !empty($procuraAssunto) && empty($procuraSubject) ) { $subject = $valor[$procuraAssunto]; }
else if( empty($procuraAssunto) && !empty($procuraSubject) ) { $subject = $valor[$procuraSubject]; }
else if( !empty($procuraAssunto) && !empty($procuraSubject) ) { $subject = $valor[$procuraAssunto];	}
$gravarCampos = array();
$gravarValor  = array();
$data         = date("d/m/Y H:i:s");

function GravaCSV($linhas = "", $colunas = "") {
	$nomeArquivo = "log_email/log.php";
	if(!file_exists($nomeArquivo)){
		$abreArquivo = @fopen($nomeArquivo, "a+");
		fputs($abreArquivo, "<?php die('Acesso restrito')?>\r\n");
	}else{
		$abreArquivo = @fopen($nomeArquivo, "a+");
	}
	for($x=0; $x<=1; $x++) { $rows[] = fgets($abreArquivo); }
	$segundaLinha  = $rows[1];
	if($abreArquivo){
		if(strtolower(trim($segundaLinha)) != strtolower(trim($colunas))){
			fputs($abreArquivo, $colunas."\r\n");
		}
		fputs($abreArquivo, trim($linhas)."\r\n");
		fclose($abreArquivo);
	}
}

$message = "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
$message .= "<tr>";
$message .= "<td colspan=\"2\" align=\"center\" style=\"font:bold 12px Verdana, Geneva, sans-serif; color:#000; background-color:#e9e9e9; padding:5px; \">".strtoupper($subject)."</td>";
$message .= "</tr>";
for($x=0; $x<$totalCampos; $x++){
	if( $x == $procuraRedirect || $x == $procuraSubject || $x == $procuraRecipient || $x == $procuraSubmit ) { continue; }	
	$message .= "<tr>";
	$message .= "<td valign=\"top\" style=\"font:12px Verdana, Geneva, sans-serif; color:#000; padding:6px 30px 6px 0; border-bottom: 1px solid #CCC; border-right: 1px solid #CCC;\">".ucfirst(trim($campo[$x]))."&nbsp;</td>";
	$message .= "<td style=\"font:12px Verdana, Geneva, sans-serif; color:#000; padding: 6px; border-bottom: 1px solid #CCC;\">".nl2br(trim($valor[$x]))."&nbsp;</td>";
	$message .= "</tr>";
	
	$gravarCampos[] = strtolower($campo[$x]);
	$gravarValor[]  = trim(str_replace("\r\n"," ", str_replace(";", ",", $valor[$x])));
}
$message .= "<table>";

$gravaCampos = join("; ", $gravarCampos);
$gravaValor  = join("; ", $gravarValor);
GravaCSV($data."; ".$gravaValor, "data; ".$gravaCampos);

$headers = "Reply-To: ".$nome." <".$email.">\n";
$headers .= "From: ".$email."\n";
$headers .= "Content-Type: text/html; charset=utf-8\n";


if(mail($recipient, $subject, $message, $headers)){
	echo "<meta http-equiv='refresh' content='0;url=".$redirect."'>";
}
else{
	echo "<script type=\"text/javascript\">alert('Erro no envio');</script>";
}
?>