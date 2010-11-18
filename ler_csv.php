<?php
session_start();
if(!$_SESSION['logado']){
	die("Acesso restrito");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ler CSV</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/jquery.tablesorter.pager.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script>
<script type="text/javascript">
$(function() {
	$("table").tablesorter({ widgets: ['zebra'], sortList: [[0,1]] }).tablesorterPager({ container: $("#pager") });
});
</script>
</head>

<body>

<table align="center">
	<tr>
		<td align="center" style="font:12px Verdana, Geneva, sans-serif"><a href="download.php?arquivo=data.csv">Download .CSV</a></td>
	</tr>
</table>

<?php
$nomeArquivo = "log_email/log.php";
$fp = @fopen($nomeArquivo, "r");
$x=1;

if(!$fp){die("Arquivo e/ou diretório sem permissão chmod(777)");}

echo "<table class=\"tablesorter\" cellspacing=\"1\" cellpadding=\"0\">\n";
while(($dados = fgetcsv($fp, 0, ";")) !== FALSE){
	if($x == 1){$x++; continue;}
	if($x == 2){echo "<thead>\n";}
	if($x == 3){echo "<tbody>\n";}
	echo "<tr>\n";
	$quant_campos = count($dados);
	if($x == 2) {
		for($i = 0; $i < $quant_campos; $i++){
			echo "<th>".$dados[$i]."</th>\n";
		}
	}
	else {
		for($i = 0; $i < $quant_campos; $i++){
			echo "<td>".$dados[$i]."</td>\n";
		}		
	}
	echo "</tr>\n";
	if($x == 2){echo "</thead>\n";}
	$x++;
}
fclose($fp);
echo "</tbody>\n";
echo "</table>";
?>
<div id="pager" class="pager" style="margin-top:10px;">
<form>
	<img src="css/icons/first.png" class="first"/>
	<img src="css/icons/prev.png" class="prev"/>
	<input type="text" class="pagedisplay"/>
	<img src="css/icons/next.png" class="next"/>
	<img src="css/icons/last.png" class="last"/>
	<select class="pagesize">
		<option selected="selected" value="10">10</option>
		<option value="20">20</option>
		<option value="30">30</option>
		<option  value="40">40</option>
	</select>
</form>
</div>

</body>
</html>