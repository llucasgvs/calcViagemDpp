<!DOCTYPE html>
<html lang="pt-br">

<head>
	<title>Resultado</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="efects/efect.css" />

</head>

<body>
	<p align=center><a><img border=0></a></td>
		<td width=80% valign=center align=center bgcolor=#FFFFFF>
			<font face="Tahoma, arial" size=6 color=green><b>SISTEMA CALCULO DE VIAGEM - DEFENSORIA PUBLICA DO PR</b></font>
	</p>
	<br><br>
	<?php
	include_once("conexao.php");
	//puxa variavel a ser pesqusiada
	$prot = $_POST['v_prot'];
	//faz o select para pesquisar no banco
	$result = "SELECT * FROM n_protocolos WHERE nr_protocolo='$prot'";
	//inicia a conexao e insere o select
	$pesq = mysqli_query($conn, $result);


	//aqui faze um while para cade registro da funcao fetch array e joga em uma variavel
	while ($registro = mysqli_fetch_array($pesq)) {
		//$protocolo=$registro['nr_protocolo'];
		//$subsi=$registro['subsidio'];
		//$diferdia=$registro['dif_dias'];
		//$diferh=$registro['dif_horas'];
		//$completo=$registro['completo'];
		//$metade=$registro['metade'];
		//$subtot=$registro['subtotaldi'];
		//$vlr_alimentacao=['vlr_aliment'];
		//$vlr_passagem=['valor_pass'];
		//$vlr_translado =['vlr_translado'];
		//$submenosalim=['submenosalim'];
		//$vlr_final=['vlr_final'];
		//$data=['data'];
		//mostra as variaveis

		//echo"Protocolo: ".$protocolo."<br> Subsidio:
		//".$subsi."<br>"."Diferença de dias:".$diferdia."<br>Diferença de Horas:".$diferh."<br>diaria 100%:".$completo."<br>Diaria 50%:".$metade."<br>Subtotal:".$subtot."<br> Valor Alimentação:".$vlr_alimentacao.
		//"<br>Valor da Passagem:".$vlr_passagem."<br>Valor Translado:".$vlr_translado."<br>Subtotal-Alimentação:".$submenosalim."<br>Valor Total:".$vlr_final."<br>Data de resgistro no Banco:".$data;
		echo " <div id='div2'>Protocolo:$registro[0] <hr> Subsidio: $registro[1] <hr> Diferença de dias: $registro[2] <hr> Diferença de Horas $registro[3] <hr>
	Completo: $registro[4] <hr> Metade: $registro[5]<hr> Subtotal: $registro[6] <hr> Valor Alimentação : $registro[7] <hr>Valor Passagem: $registro[8] <hr>Valor Translado: $registro[9] <hr>
	Subtotal- Alimentação : $registro[10] <hr> Valor Total: $registro[11] <hr> Data de Registro no Banco: $registro[12]<hr> Porcentagem: $registro[13]<hr> 
	<form><input type='button' value='VOLTAR' onClick='history.back()';></form></div>";


		//mysqli_close($pesq);
	}




	?>


</body>

</html>