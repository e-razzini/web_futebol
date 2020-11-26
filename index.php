<?php

require './classes/PlacarFutebol.php';
require './classes/Liga.php';
require './classes/class/Jogo.php';

$jog = new Jogo();
$jogos = $jog->listar();
?>

<!DOCTYPE html>
<html lang="pt-Br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Crawller</title>
    <link rel="stylesheet" href="main.css">

</head>

<body>
       <h2>Jogos de futebol</h2>
    <ul>

        <?php foreach ($jogos as $j) {?>
            <li><?php echo $j['informacao']; ?></li>
        <?php }?>


    </ul>



</body>

</html>