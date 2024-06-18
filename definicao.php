<?php

$var = $_POST["var"];
$rest = $_POST["rest"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>DEFININDO RESTRIÇÕES</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link href='https://fonts.googleapis.com/css?family=Krona One' rel='stylesheet'>
</head>

<body>
    <div class="divzona d-flex flex-column min-vh-100 min-vw-100" style="background-color: #C6FFCB;">
        <div class="container d-flex flex-grow-1 justify-content-center align-items-center">
            <div class="card text-center border-dark">
                <div class="card-header" style="font-family: Krona One;">
                    Definindo Restrições
                </div>
                <div class="card-body">
                    <form action="maximizacao.php" method="POST">
                        <input type="hidden" name="var" value="<?php echo ($_POST["var"]) ?>">
                        <input type="hidden" name="rest" value="<?php echo ($_POST["rest"]) ?>">

                        <!-- Corpo do card -->
                        <div class="col col-auto">

                            <!-- Primeira linha ( definir se é maximização ou minimização ) -->
                            <div class="row mb-2">
                                <div class="col col-auto">
                                    <p>Informe o tipo de problema</p>
                                </div>
                                <div class="col">
                                    <input type="radio" class="btn-check" name="options" id="option1" value="Maximizar" autocomplete="off" checked>
                                    <label class="btn btn-outline-warning btn-sm" for="option1">Maximizar</label>
                                    <input type="radio" class="btn-check" name="options" id="option2" value="Minimizar" autocomplete="off">
                                    <label class=" btn btn-outline-warning btn-sm" for="option2">Minimizar</label>
                                </div>
                            </div>

                            <!-- Segunda linha ( exibir variáveis ) -->
                            <div class="row">
                                <div style="width: 84px; height: 40px"></div>
                                <?php
                                for ($j = 0; $j < $var; $j++) {
                                ?>
                                    <div class="col col-auto">
                                        <div style="width: 60px;">
                                            <p><?php echo ("x" . $j + 1) ?></p>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>





                            <!-- Terceira linha ( definir a Z e mostrar identificadores de colunas ) -->
                            <div class="row row-auto">
                                <div style="width: 84px;">
                                    <p>Z</p>
                                </div>
                                <?php
                                for ($j = 0; $j < $var; $j++) {
                                ?>
                                    <div class="col col-auto">
                                        <div style="width: 60px;">
                                            <input class="num" type="number" name="z<?php echo ($j) ?>" id="z<?php echo ($j) ?>">
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                <div class="col col-auto">
                                    <div style="width: 80px;">
                                        <p>Sinais</p>
                                    </div>
                                </div>
                                <div class="col col-auto">
                                    <div style="width: 60px;">
                                        <p>R.H.S</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Inputs -->
                            <?php for ($i = 0; $i < $rest; $i++) { ?>
                                <div class="row row-auto">

                                    <!-- Printa o identificador da restrição -->
                                    <div class="col col-auto">
                                        <div style="width: 60px;">
                                            <p>R.<?php echo ($i + 1) ?></p>
                                        </div>
                                    </div>

                                    <!-- A partir da quantidade de variáveis, irá apresentar a quantidade de inputs necessários -->
                                    <?php for ($j = 0; $j < $var; $j++) { ?>
                                        <div class="col col-auto">
                                            <input class="num" type="number" name="v<?php echo ($i . $j) ?>" id="v<?php echo ($i . $j) ?>">
                                        </div>
                                    <?php } ?>

                                    <!-- Define os sinais -->
                                    <div class="col col-auto">
                                        <div class="btn-group" role="group" aria-label="Basic example" style="margin-bottom: 7px; height: 30px">

                                            <input type="checkbox" class="btn-check" name="s<?php echo ($i) ?>[]" value="<" id="s<?php echo ($i) ?>1" autocomplete="off">
                                            <label class="btn btn-outline-warning btn-sm" for="s<?php echo ($i) ?>1"><?php echo "<" ?></label>

                                            <input type="checkbox" class="btn-check" name="s<?php echo ($i) ?>[]" value="=" id="s<?php echo ($i) ?>2" autocomplete="off">
                                            <label class="btn btn-outline-warning btn-sm" for="s<?php echo ($i) ?>2">=</label>

                                            <input type="checkbox" class="btn-check" name="s<?php echo ($i) ?>[]" value=">" id="s<?php echo ($i) ?>3" autocomplete="off">
                                            <label class="btn btn-outline-warning btn-sm" for="s<?php echo ($i) ?>3">></label>

                                        </div>
                                    </div>
                                    <div class="col col-auto">
                                        <input class="num" type="number" name="r<?php echo ($i) ?>" id="r<?php echo ($i . "_" . $j) ?>">
                                    </div>
                                </div>

                            <?php } ?>
                        </div>

                        <div class="row row-auto justify-content-center align-items-center">
                            <div class="col m-2">
                                <input type="submit" class="btn btn-primary " value="Resolver">
                            </div>
                        </div>
                </div>

                </form>
            </div>
        </div>
    </div>
</body>

</html>