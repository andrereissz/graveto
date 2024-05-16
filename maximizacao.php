<?php

var_dump($_POST);
$var = $_POST["var"];
$rest = $_POST["rest"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>DEFININDO RESTRIÇÕES</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Krona One' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <div class="divzona d-flex flex-column min-vh-100 min-vw-100" style="background-color: #C6FFCB;">
        <div class="container d-flex flex-grow-1 justify-content-center align-items-center">
            <div class="card text-center border-dark">
                <div class="card-header" style="font-family: Krona One;">
                    Definindo Restrições
                </div>
                <div class="card-body">
                    <div class="col col-auto">
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
                        <div class="row row-auto">
                            <div style="width: 84px;">
                                <p>Z</p>
                            </div>
                            <?php
                            for ($j = 0; $j < $var; $j++) {
                            ?>
                                <div class="col col-auto">
                                    <div style="width: 60px;">
                                        <input class="num" type="number" id="v<?php echo ($i . "_" . $j) ?>">
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
                        <?php for ($i = 0; $i < $rest; $i++) { ?>
                            <div class="row row-auto">

                                <div class="col col-auto">
                                    <div style="width: 60px;">
                                        <p>R.<?php echo ($i + 1) ?></p>
                                    </div>
                                </div>

                                <?php for ($j = 0; $j < $var; $j++) { ?>
                                    <div class="col col-auto">
                                        <input class="num"  type="number" id="v<?php echo ($i . "_" . $j) ?>">
                                    </div>
                                <?php } ?>

                                <div class="col col-auto">
                                    <div class="btn-group" role="group" aria-label="Basic example" style="margin-bottom: 7px; height: 30px">
                                        
                                        <input type="checkbox" class="btn-check" id="s<?php echo ($i) ?>1" autocomplete="off">
                                        <label class="btn btn-outline-warning btn-sm" for="s<?php echo ($i) ?>1"><</label>

                                        <input type="checkbox" class="btn-check" id="s<?php echo ($i) ?>2" autocomplete="off">
                                        <label class="btn btn-outline-warning btn-sm" for="s<?php echo ($i) ?>2">=</label>

                                        <input type="checkbox" class="btn-check" id="s<?php echo ($i) ?>3" autocomplete="off">
                                        <label class="btn btn-outline-warning btn-sm" for="s<?php echo ($i) ?>3">></label>
                                    
                                    </div>
                                </div>
                                <div class="col col-auto">
                                    <input class="num" type="number" id="r<?php echo ($i . "_" . $j) ?>">
                                </div>
                            </div>

                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>