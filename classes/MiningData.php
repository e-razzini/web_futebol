<?php

require './Liga.php';
require './PlacarFutebol.php';
require '../classes/class/Jogo.php';

$resultados = new PlacarFutebol();
$liga = new Liga();


$resultadosJogos = $resultados->resultadoPlacar();
$resultadoLiga  = $liga->resultadoLiga();

automaticMining($resultadosJogos);
automaticMining($resultadoLiga);

function automaticMining($array)
{
    $novaInfo = new Jogo();

    foreach($array as $value) {

        $novaInfo->inserir($value);
    }

}
