<?php

var_dump($_POST);

global $n; //numero de restrioções
$n = $_POST["rest"];
global $m; //numero de variáveis
$m = $_POST["var"];
echo $n . " " . $m . "<br/>";

function mkMatriz($n, $m)
{
    $id = mkIdentidade($n); //matriz identidade
    $z = array(); //função objetivo
    $matOut = array(array()); //matriz de output
    for ($j = 0; $j < ($n + $m + 1); $j++) {
        if ($j < $m) {
            $z[$j] = $_POST["z" . $j];
        } else {
            $z[$j] = 0;
        }
        array_push($matOut[0], $z[$j]);
    }
    printMat($matOut);
    for ($i = 0; $i < $n; $i++) {
        echo "i: " . $i . "<br/>";
        for ($j = 0; $j < $m; $j++) {
            $matOut[($i + 1)][$j] = $_POST["v" . $i . $j];
        }
        for ($j = $m; $j < ($n + $m); $j++) {
            echo "j: " . $j . "<br/>";
            echo "Matriz " . ($i + 1) . " " . $j . " = id " . $i . " " . ($j - $m) . "<br/>";
            $matOut[($i + 1)][$j] = $id[$i][$j - $m];
        }
        array_push($matOut[$i + 1], $_POST["r" . $i]);
    }
    printMat($matOut);
    return ($matOut);
}

function mkIdentidade($n)
{
    $identidade = [];
    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < $n; $j++) {
            if ($i == $j) {
                $identidade[$i][$j] = 1;
            } else {
                $identidade[$i][$j] = 0;
            }
        }
    }
    printMat($identidade);
    return $identidade;
}
function addFolga($mat, $n, $m)
{
    $identidade = mkIdentidade($n);
    printMat($identidade);
    for ($i = 1; $i < count($mat); $i++) {
        for ($j = $m - 1; $j < count($mat[0]) - 1; $j++) {
            echo $i . " " . $j . "</br>";
            $mat[$i][$j] = $identidade[$i - 1][$j - $n];
        }
    }
    printMat($mat);
}
function checkOptimality($mat)
{ //teste de otimalidade
    for ($j = 0; $j < count($mat[0]); $j++) {
        if ($mat[0][$j] > 0) {
            echo "</br>Solução não ótima</br>";
            return false;
        }
    }
    echo "</br>Solução ótima</br>";

    return true;
}
function printMat($mat)
{ //imprime a matriz
    echo "<br/>";
    $lin = count($mat);
    $col = count($mat[0]);
    for ($i = 0; $i < $lin; $i++) {
        for ($j = 0; $j < $col; $j++) {
            echo "| " . round($mat[$i][$j], 2) . " | ";
        }
        echo "</br>";
    }
    echo "</br>";
}
function escalona($mat, $pivot)
{ //escalona a matriz para transformar o pivo em 1 e os elementos acima e abaixo dele em 0
    $div = $mat[$pivot[0]][$pivot[1]];
    for ($i = 0; $i < count($mat[0]); $i++) {
        $mat[$pivot[0]][$i] = ($mat[$pivot[0]][$i]) / $div; //divide a linha pivo pelo elemento pivo para transforma-lo em 1
    }
    printMat($mat);
    echo '</br>';

    for ($i = 0; $i < count($mat); $i++) {
        $mult = $mat[$i][$pivot[1]];
        if ($i != $pivot[0]) {
            for ($j = 0; $j < count($mat[0]); $j++) {
                $temp = $mat[$i][$j] -= $mult * $mat[$pivot[0]][$j]; //zera o elemento acima do pivo e faz a subtração entre as demais colunas
                echo round($mat[$i][$j], 2) . " -= (" . round($mult, 2) . " * " . round($mat[$pivot[0]][$j], 2) . ") = " . round($temp, 2) . " </br>";
            }
        }
    }
    return $mat;
}
function findPivot($mat)
{
    $lin = count($mat);
    $col = count($mat[0]);
    $maxCol = PHP_INT_MIN;
    $pivotCol = 0;
    $maxRow = PHP_INT_MAX;
    $pivotRow = 0;

    for ($j = 0; $j < $col - 1; $j++) { //encontra a coluna pivo
        if ($mat[0][$j] > $maxCol) {
            $maxCol = $mat[0][$j];
            $pivotCol = $j;
        }
    }
    echo "Coluna pivo -> " . $pivotCol . "<br>";

    for ($i = 1; $i < $lin; $i++) { //encontra a linha pivo
        if ($mat[$i][$pivotCol] != 0) {
            echo round($mat[$i][($col - 1)], 2) . " [" . $i . "][" . ($col - 1) . "] / " . round($mat[$i][$pivotCol], 2) . " [" . $i . "][" . $pivotCol . "] = " . round($mat[$i][$col - 1], 2) / round($mat[$i][$pivotCol], 2) . " </br>";
            if (($mat[$i][$col - 1] / $mat[$i][$pivotCol]) < $maxRow  && ($mat[$i][$col - 1] / $mat[$i][$pivotCol])  >= 0) { //teste da razão mínima
                $maxRow = ($mat[$i][$col - 1] / $mat[$i][$pivotCol]);
                $pivotRow = $i;
            }
        }
    }
    echo "Linha pivo -> " . $pivotRow . "<br>";

    echo "pivo = [" . $pivotRow . "][" . $pivotCol . "] -> " . $mat[$pivotRow][$pivotCol] . "<br>";
    echo '</br>';
    $pivot = array($pivotRow, $pivotCol);
    return $pivot;
}
function maximizeSimplex($mat)
{ //realiza maximização pelo método simplex tabular
    $it = 0;
    do {
        if ($it > 20) break; // para de executar caso efetue mais de 20 iterações
        echo "Iteração: " . ($it + 1) . "</br>";
        printMat($mat);
        $piv = findPivot($mat);
        $mat = escalona($mat, $piv);
        printMat($mat);
        $it++;
    } while (!checkOptimality($mat)); //realiza outra iteração enquanto não encontrar uma solução ótima
}

function minimizeSimplex($mat)
{ //realiza maximização pelo método simplex tabular (min Z = -max(-Z))
    for ($j = 0; $j < count($mat[0]); $j++) {
        $mat[0][$j] *= -1;
    }
    maximizeSimplex($mat);
}
$matriz = mkMatriz($n, $m);
echo "</br>-- MAXIMIZAÇÃO --</br></br>";
maximizeSimplex($matriz);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>REVISANDO PROBLEMA</title>
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