<?php //Página para exibir qualquer mesa (o ID da mesa a ser mostrada deve vir via post)
session_start();
echo "1";
require "classes.php";
echo"1.5";
require "INC/funcoes.inc";
echo "2";
$idMesa =  $_POST["idMesa"];
$entrada = $_POST["entra"];
$saida = $_POST["sai"];
$todasAsMesas = pegaJson("DB/dbMesas.json");
$mesa = pegaPorId($todasAsMesas, $idMesa);
$presente = isCaraNaMesa($idMesa, $_SESSION["user"]->id);
$convidado = $_POST["convite"] || $presente; //Nego pode ver mesa privada se já estiver nela ou usar link com convite

var_dump($idMesa);
var_dump($entrada);
var_dump($saida);
var_dump($presente);
var_dump($convidado);
?>
<!DOCTYPE>
<html>
    <head>
        <title><?=$mesa->nome?></title>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8">        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="STYLE/style.css"></link>
    </head>
    <body>
        <div class="container-fluid">
            <? require "INC/userSideBar.inc"; ?>
            <div class="col-sm-10 centerbar">
        <?php
            if ($entrada) poeNaMesa($idMesa, $_SESSION["user"]->id);
            if (!$convidado){ //Nego tentando visualizar mesa privada sem convite
                ?> <h2>Esta é uma mesa privada.</h2> <?php
            }
            else { ?>
                <h1><?=$mesa->nome?></h1>
                <div class="divider"></div>
                <p><strong>Mestre: </strong><?= $mesa->mestre ?></p>
                <p><strong>Sistema: </strong><?= $mesa->sistema ?></p>
                <p><strong>Gênero: </strong><?= $mesa->genero ?></p>
                <p><strong>Sinopse: </stron><?= $mesa->sinopse ?></p>
                <p><strong>Endereço: </strong><?= $mesa->endereco ?></p>
                <?php  
                    /*
                    Comentando por não estar sendo usado agora
                    listaJogadores();
                    */
                if (!$presente) { //Nego ainda não está na mesa ?>
                    <form method="post" action="pgMesa.php">
                        <input type="hidden" name="idMesa" value="<?= $idMesa ?>">
                        <input type="hidden" name="entra" value="<?= true ?>">
                        <input type="hidden" name="sai" value="<?= false ?>">
                        <input type="hidden" name="convite" value="<?= false ?>">
                        <button type="submit">Entrar nessa mesa</button>
                    </form> <?php
                }
                else { //Nego já está nessa mesa ?>
                    <form method="post" action="pgMesa.php">
                        <input type="hidden" name="idMesa" value="<?= $idMesa ?>">
                        <input type="hidden" name="entra" value="<?= false ?>">
                        <input type="hidden" name="sai" value="<?= true ?>">
                        <input type="hidden" name="convite" value="<?= false ?>">
                        <button type="submit">Sair dessa mesa</button>
                    </form> <?php
                }
            } ?>
            </div>
        </div>
    </body>
    <?php include "INC/footer.inc"; ?>
</html>