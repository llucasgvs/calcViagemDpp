<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";          //aqui joga os dados necessarios para acessar o servidor banco de dados
$dbname = "protocolos";


$conn = mysqli_connect($servidor,$usuario,$senha,$dbname);//aqui cria a conexao
//para utilizar a conexao basta usar a variavel conn
