<?php

    include_once('../controller/connection.php');

    // 1024 Bytes = 1Kb
    // 1024 Kb = 1Mb

    $arquivo;
    $nomeDoArquivo;
    $extensao;
    $pasta;
    $hashName;
    $hashNameWithExt;
    $isAllCorrect;
    $tamanhoArquivo;
    $path;
    $progressStatus;

    //Se existe arquivo no input.
    if(isset($_FILES['arquivo'])){

        $arquivo = $_FILES['arquivo'];

        //Se existe erro no envio do arquivo. (Logic 1)
        if($arquivo['error']){

            die("Logic 1: Erro ao carregar o arquivo.");

        }

        //Se o tamanhdo do arquivo for maior que 2mb. (Logic 2)
        if($arquivo['size'] > 2097152){  //2mb

            die("Logic 2: Erro! Arquivo muito grande. Tamanho máximo permitido: 2Mg.");

        }else{

            $tamanhoArquivo = $arquivo['size'];
            $nomeDoArquivo = $arquivo['name'];
            $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

            //Se o arquivo não conter extensão .jpg ou .png. (Logic 3)
            if($extensao != "jpg" && $extensao != "png"){

                die("Logic 3: Erro! O tipo do arquivo enviado deve estar em formato .jpg ou .png");

            }else{

                $pasta = "files/";
                echo $hashName = uniqid();

                $hashNameWithExt = $hashName . "." . $extensao;
                $path = $pasta . $hashName . "." . $extensao;

                $isAllCorrect = move_uploaded_file($arquivo['tmp_name'], $path);

                //Se a deslocação do arquivo para a pasta destino foi realizado com sucesso. (Logic 4)
                if($isAllCorrect){

                    //Se o tamanho da string arquivo for maior que 100 caracteres. (Logic 5)
                    if(strlen($nomeDoArquivo) > 100){

                        die("Logic 5: O tamanho do nome do arquivo é grande demais para ser inserido no banco de dados");

                    }

                    $progressStatus = 0;

                    $mysqli->query("INSERT INTO arquivos(pathDir, originalFileName, fileSize, progressStatus) VALUES('$path', '$nomeDoArquivo', $tamanhoArquivo, $progressStatus)") or die($mysqli->error);

                    echo "<p>Arquivo enviado com sucesso!</p>";

                }else{

                    die("Logic 4: Falha ao enviar o arquivo");

                    // SALVAR NO LOG MESMO QUE TENHA DADO ERRO

                }

            }

        }

        var_dump($arquivo);

    }

$sql_query = $mysqli->query("SELECT * FROM arquivos") or die($mysqli->error);



    
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

    <br><br><br><br>

    <h4>Lista de arquivos</h4>
    <table border="1" cellpadding="10" style="width: 100%;">
        <thead>

            <th>Preview</th>
            <th>Arquivo</th>
            <th>Data de envio</th>
            <th>Status</th>

        </thead>
    
        <tbody style="width: 100%;">

            <?php

                while($arquivo = $sql_query->fetch_assoc()){
                    
            ?>
                    <tr>

                        <td> <img height='50' src='<?php $arquivo['pathDir']; ?>' alt=''> </td>
                        <td> <?php echo $arquivo['pathDir']; ?> </td>
                        <td> <?php echo date("d/m/Y H:i", strtotime($arquivo['uploadDate'])); ?> </td>
                        <td> <?php echo $arquivo['progressStatus']; ?> </td>

                    </tr>
            
            <?php
            
                }

            ?>

        </tbody>

    </table>

</body>

</html>