<?php

$z = $_POST['z'];
$variaveis = $_POST['variaveis'];
$valores = $_POST['valores'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>TENTATIVA INTEIRA</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link href='https://fonts.googleapis.com/css?family=Krona One' rel='stylesheet'>
</head>

<body>
    <div class="divzona d-flex flex-column min-vh-100 min-vw-100" style="background-color: #C6FFCB;">
    <a href="index.php" class="btn position-absolute rounded-circle m-2" style="width: 100px; height: 100px; background-image: url('views/components/btn.png'); background-size: 100% 100%; scale: -1"></a>

    <div class="container d-flex flex-grow-1 justify-content-center align-items-center">
            <div class="card text-center border-dark">
                <div class="card-header" style="font-family: Krona One;">
                    TENTATIVA DE INTEIRA
                </div>
                <div class="card-body bg-white">
                    <div class="row row-auto">   
                        <div class="col col-100">
                            <p class="form-control text-monospace my-2 w-100" type="text">
                                <span class="fw-bold">Z → </span>
                                <?php
                                $resposta = '';
                                for($i = 0; $i < count($GLOBALS['variaveis']); $i++){
                                        $resposta = $resposta.'('.$GLOBALS['valores'][$i].')·'.$GLOBALS['variaveis'][$i];
                                        if($i != count($GLOBALS['variaveis'])-1){
                                            $resposta = $resposta.' + ';
                                        }
                                }
                                $resposta = $resposta.' = '.$GLOBALS['z'];
                                echo $resposta;
                                ?>
                            </p>     
                        </div> 
                    </div>
                </div>
            </div>
    </div>
    <script src="js/bootstrap/bootstrap.bundle.js"></script>
</body>

</html>