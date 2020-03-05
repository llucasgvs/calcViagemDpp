<!DOCTYPE html>
<html lang="pt-br">

<head>
	<link rel="stylesheet" type="text/css" href="efects/efect.css" />
	<meta charset="utf-8">
</head>

<body>

</body>

</html>
<p align=center><a><img border=0></a></td>
	<td width=80% valign=center align=center bgcolor=#FFFFFF>
		<font face="Tahoma, arial" size=6 color=green><b>SISTEMA CALCULO DE VIAGEM - DEFENSORIA PUBLICA DO PR</b></font>
</p>



<?php

error_reporting(E_ALL ^ E_NOTICE);

$diasut = $_POST['diasut'];
$sb = $_POST['sb'];
$dataini = $_POST['dataini'];
$datafim = $_POST['datafim'];
$horaini = $_POST['horaini'];
$horafim = $_POST['horafim'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$passagem = $_POST['passagem'];
$translado = $_POST['translado'];
$cargo = $_POST['cargo'];
$protocolo = $_POST['protocolo'];
$defensorsim = $_POST['defensorsim'];


$porcentagem = 1;
$alimdia = 38.80;
$servidor = 438.00;
$submenosalim = 0;

//aqui verifica se tem algum campo obrigatorio em branco e retorna sem apagar os dados.



if ($diasut == "" || $dataini == "" || $datafim == "" || $passagem == "" || $translado == "" || $horaini == "" || $horafim == "") {
	echo "<script>alert('NÃO DEIXE NENHUM CAMPO EM BRANCO!');history.back();</script>";
	exit;
}


// pega dia inicial
$partes = explode("-", $dataini);
$diaini = $partes[2];
$mesini = $partes[1];
$anoini = $partes[0];

// pega dia final
$partes1 = explode("-", $datafim);
$diafim = $partes1[2];
$mesfim = $partes1[1];
$anofim = $partes1[0];



//hora 
$h11 = new DateTime($horaini);
$h22 = new DateTime($horafim);


$horas = explode(":", $horaini);
$hr1 = $horas[0];
$mn1 = $horas[1];


$minutos = explode(":", $horafim);
$hr2 = $minutos[0];
$mn2 = $minutos[1];


$horafixa = 24;
$minutosfixo = 60;


//aqui faz a diferença h==hora :i minuto e :%S para segundos



if ($h22 > $h11) {

	$diffHoras = $h22->diff($h11)->format('%H:%I');
} else {
	$horatot = $horafixa - $hr1;
	$minutot = $minutosfixo - $mn1;
	$horatot = $horatot + $hr2 - 1;
	$minutot = $minutot + $mn2;

	if ($minutot >= 60) {
		$horatot = $horatot + 1;
		$minutot = $minutot - $minutosfixo;

		if ($minutot < 10) {
			$minutot = "0" . $minutot;
		}
	}



	$array = array($horatot, $minutot);
	$novahora = implode(":", $array);
	$diffHoras = $novahora;
}

if ($diffHoras == 24) {
	$diffHoras = 0;
}

//pega o ultimo dia do mes
//if ($mesini == 4 && $mesfim > 4){
//$udini = date('t', mktime(0, 0, 0, $mesini, 0, $anoini ));
//$udfim = date('t', mktime(0, 0, 0, $mesfim, 0, $anofim ));
//} else if($mesini != 4){
$udini = date('t', mktime(0, 0, 0, $mesini, $diaini, $anoini));
$udfim = date('t', mktime(0, 0, 0, $mesfim, $diafim, $anofim));
//}


// se o mes for igual entra no if se não faz a diferença das datas.
if ($mesini == $mesfim) {
	$difedia = $diafim - $diaini;
} else {
	$difedia = ($udini - $diaini) + $diafim;
}

if ($horaini > $horafim) {
	$difedia = $difedia - 1;
}

// se necessario colocar no final da formula do completo - 0.01 para ter o valor exato

if ($sb == 0) {
	$completo = $servidor;
	$metade = $servidor / 2;
} else {

	$completo = (float) $sb / 30; // tabela 100%
	$metade = (float) $completo / 2; // tabela 50%
}

$contafinal = (float) 0;

//adicionar quantos dias foi de viagem a conta final.
for ($i = 0; $i < $difedia; $i++) {
	$contafinal = (float) $contafinal + $completo;
}


//se a diferença de horas for igual ou maior que 6 e menor que 16 recebe metade se for maior que 16 recebe 100%.
if ($diffHoras >= 6 && $diffHoras < 16) {
	$contafinal = $contafinal + $metade;
} else if ($diffHoras >= 16) {

	// adiciona apenas 50%
	if ($diaini == $diafim  && $mesini == $mesfim) {
		$contafinal = $contafinal + $metade;
	} else {
		$contafinal = $contafinal + $completo;
	}
}

// calcula o valor da diaria de alimentação.
$caldiasuteis = $alimdia * $diasut;

// se o cargo for OUTROS faz uma porcentagem, se for defensor faz outra.

switch ($estado) {
	case 0:
		$porcentagem = $porcentagem + 0.25;

		//$contafinal=$contafinal+$completo*0.25;
		break;
}
if ($cidade != 0) {
	$porcentagem = $porcentagem + 0.25;

	//$contafinal=$contafinal+$completo*0.25;
}




$contafinal = $contafinal * $porcentagem;
//subtrai a alimentação do valor da diaria.
$contafinal2 = $contafinal - $caldiasuteis;
$submenosalim = $contafinal - $caldiasuteis;

$sb = (float) $sb;
$contafinal2 = $contafinal2 + $translado + $passagem;
//

$porcentagem = $porcentagem * 100;
include_once("conexao.php");

$up1 = "UPDATE n_protocolos SET subsidio='$sb',dif_dias='$difedia',dif_horas='$diffHoras',completo='$completo',metade='$metade',subtotaldi='$contafinal',vlr_aliment='$caldiasuteis',valor_pass='$passagem',vlr_translado='$translado',submenosalim='$submenosalim',vlr_final='$contafinal2',data=NOW(),porcentagem='$porcentagem' WHERE nr_protocolo='$protocolo'";
$pesq1 = mysqli_query($conn, $up1);

//se  nao houve update entao faz o insert na tabela
if (mysqli_affected_rows($conn) == 0) {

	$result_usuario = "INSERT INTO n_protocolos(nr_protocolo,subsidio,dif_dias,dif_horas,completo,metade,subtotaldi,vlr_aliment,valor_pass,vlr_translado,submenosalim,vlr_final,data,porcentagem)
 VALUES('$protocolo','$sb','$difedia','$diffHoras','$completo','$metade','$contafinal','$caldiasuteis','$passagem','$translado','$submenosalim','$contafinal2',NOW(),'$porcentagem')";
	$pesq = mysqli_query($conn, $result_usuario);
}


$submenosalim = number_format($submenosalim, 2, ',', '.');


//formata os numeros para real (ex. 1,000.00)
$contafinal = number_format($contafinal, 2, ',', '.');
$completo = number_format($completo, 2, ',', '.');
$metade = number_format($metade, 2, ',', '.');



$caldiasuteis = (float) $caldiasuteis;
$caldiasuteis = number_format($caldiasuteis, 2, ',', '.');



$contafinal2 = number_format($contafinal2, 2, ',', '.');



$sb = number_format($sb, 2, ',', '.');
$passagem = number_format($passagem, 2, ',', '.');
$translado = number_format($translado, 2, ',', '.');




echo "<div id='div2'>

Nº Protocolo: $protocolo<br><br>

Subsídio: R$$sb<br><br>

Diferença de Dias: $difedia<br><br>

Diferença de Horas: $diffHoras<br><br>

Diária (100%): R$$completo<br><br> 

Metade da Diária (50%): R$$metade<br><br>
<hr>
A: Subtotal Valor das Diárias: R$$contafinal<br><br>

B: Valor Total Alimentação: R$$caldiasuteis<br><br>

Valor da Passagem: R$$passagem<br><br>

Valor do Translado: R$$translado<br><br>

Porcentagem: $porcentagem %<br><br>
A-B = Total Diárias = R$$submenosalim<br>



<hr> Valor Final: R$$contafinal2 <br><hr>";





// RETORNA O ERRO DO BANCO , OU SE FOI COM SUCESSO.
//if (mysqli_query($conn, $result_usuario)) {
//echo "<h3 style = 'color : red ;'>Salvo no Banco de dados</h3>";
//} else {
// echo "<p style = 'color : yellow ;'>Error: </p>" . $result_usuario . "<br>" . mysqli_error($conn);

//}

mysqli_close($conn);

echo '<form><input type="button" value="VOLTAR" onClick="history.back();"></form>';


//Ultimo dia do mes inicial: Dia $udini <br><br>

//Dia inicial: Dia $diaini<br><br>

//Dia final: Dia $diafim<br><br>




?>