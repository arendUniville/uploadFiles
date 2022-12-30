<?php

    include_once('../controller/connection.php');

    // 1024 Bytes = 1Kb
    // 1024 Kb = 1Mb

    $arquivo;
    $nomeDoArquivo;
    $extensao;
    $pasta;
    $hashName;
    $isAllCorrect;


    if(isset($_FILES['arquivo'])){

        $arquivo = $_FILES['arquivo'];

        if($arquivo['error']){

            die("Erro ao carregar o arquivo.");

        }


        if($arquivo['size'] > 2097152){  //2mb

            die("Arquivo muito grande. Tamanho máximo permitido: 2Mg.");

        }else{

            $nomeDoArquivo = $arquivo['name'];
            $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

            if($extensao != "jpg" && $extensao != "png"){

                die("O tipo do arquivo enviado deve estar em formato .jpg ou .png");

            }else{

                $pasta = "files/";
                echo $hashName = uniqid();

                $hashNameWithExt = $hashName . "." . $extensao;

                $isAllCorrect = move_uploaded_file($arquivo['tmp_name'], $pasta . $hashName . "." . $extensao);

                if($isAllCorrect){

                    echo "<p>Arquivo enviado com sucesso! Para acessá-lo, clique aqui: <a target='_blank' href='files/$hashNameWithExt'> Clique aqui </a> </p>";

                }else{

                    echo "Falha ao enviar o arquivo";

                    // SALVAR NO LOG MESMO QUE TENHA DADO ERRO

                }

            }

        }

        //var_dump($arquivo);

    }

    

    
?>



<!DOCTYPE html>
<html lang="pt-br">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Enviar arquivos</title>
</head>

<body>

    <h2>Enviar arquivos</h2>

    <br><br>

    <div class="main">

        <form enctype="multipart/form-data" action="" method="POST">

            <h5>Selecione o arquivo: </h5> <br> 
            <input type="file" name="arquivo"> <br><br><br>
            <button name="upload" class="btn btn-success" type="submit">Enviar arquivo</button>

        </form>    

    </div>

</body>

</html>