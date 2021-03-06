<?php
// Página inicial, apresentada antes do usuário logar e depois de ele logar com o mural do usuário
session_start();
require "INC/funcoes.inc";?>

<!DOCTYPE>
<html>
    <head>
        <title>Bem vindo ao GameMaster</title>
        <link rel="stylesheet" type="text/css" href="STYLE/style.css"></link>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <meta charset=utf-8>
    </head>

    <?php
    // Verifica se login e a senha vem da sessao ou do post
    if(!$_SESSION["login"]) {
        $login = $_POST["login"];
        $senha = $_POST["senha"];
    }
    else {
        $login = $_SESSION["login"];
        $senha = $_SESSION["senha"];
    }

    if(!$login) {
        //Procedimento se não estiver logado
        header("Location: login.php");
    }

    else if(validar($login, $senha)) {
        //Senha correta
        ?> <h2 class= "fontebranca">Login bem sucedido</h2> <?php
        $_SESSION["login"] = $login;
        $_SESSION["senha"] = $senha;
        $todosUsuarios = pegaJson("DB/dbUsuarios.json");
        foreach ($todosUsuarios as $user)        
            if ($user->login == $_SESSION["login"])
                $_SESSION["user"] = $user;
        ?>
        <body>
            <h3 class="fontebranca">Bem vindo ao GameMaster, o melhor site para organizar mesas de RPG, aprovado por 100% dos usuários</h3>
            <p class="fontebranca">Vá para a sua página HOME para começar (ou continuar!)</p>
            <!-- A página só pode ter um header então estamos usando esse botão.
            Qualquer ideia para deixar isso mais eficiente será bem vinda -->
            <form method="get" action="home.php">
                <button type="submit">Go Home!</button>
            </form>
        </body> <?php
    }
    else {
        //Senha incorreta
        ?>
        <body>
            <h2 class= "fontebranca">Falha no login</h2>
			<a href='/login.php'>Tentar Novamente</a>
            <?php
		}
        include "INC/footer.inc"; ?>
    </body>
</html>