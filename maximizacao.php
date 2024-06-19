<?php

$n = $_POST["rest"];
$m = $_POST["var"];
$base = [];

// FUNÇÕES PARA GERAR MATRIZ INICIAL

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
    return $identidade;
}

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
    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < $m; $j++) {
            $matOut[($i + 1)][$j] = $_POST["v" . $i . $j];
        }
        for ($j = $m; $j < ($n + $m); $j++) {
            $matOut[($i + 1)][$j] = $id[$i][$j - $m];
        }
        array_push($matOut[$i + 1], $_POST["r" . $i]);
    }
    for ($i = 0; $i < $n; $i++) {
        array_push($GLOBALS['base'], 's' . $n + $i - 1);
    }
    return ($matOut);
}

//------------------------------------------------------------------------

//FUNÇÕES PARA PRINTAR AS MATRIZES

function printMat($mat, $iteracao)
{ //imprime a matriz
    $lin = count($mat);
    $col = count($mat[0]);
?>
    <div class="card text-center border-dark mt-5">
        <div class="card-header" style="font-family: Krona One;">
            <?php echo 'Iteração ' . $iteracao ?>
        </div>

        <div class="m-2">
            <div class="row row-auto">
                <div class="col col-auto">
                    <div class="my-2 fw-bold" style="width: 100px; height: 30px;">
                    </div>
                </div>
                <?php
                for ($j = 0; $j < $col; $j++) {
                ?>
                    <div class="col col-auto">
                        <?php
                        if ($j < $GLOBALS['m']) {
                        ?>
                            <div class="my-2 fw-bold" style="width: 100px; height: 30px;"><?php echo 'x' . $j + 1 ?></div>
                        <?php
                        }
                        if ($j > $GLOBALS['m'] - 1 && $j != $col - 1) {
                        ?>
                            <div class="my-2 fw-bold" style="width: 100px; height: 30px;"><?php echo 'sx' . $j + 1 ?></div>
                        <?php
                        }
                        if ($j == $col - 1) {
                        ?>
                            <div class="my-2 fw-bold" style="width: 100px; height: 30px;"><?php echo 'Solução' ?></div>
                        <?php
                        }
                        ?>

                    </div>
                <?php
                }
                ?>
            </div>
            <?php
            for ($i = 0; $i < $lin; $i++) {
            ?> <div class="row row-auto">
                    <div class="col col-auto">
                        <div class="my-2 fw-bold" style="width: 100px; height: 30px;">
                            <?php
                            if ($i == 0) {
                                echo 'z (' . substr($_POST['options'], 0, 3) . ')';
                            } else {
                                echo $GLOBALS['base'][$i - 1];
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    for ($j = 0; $j < $col; $j++) {
                    ?>
                        <div class="col col-auto">
                            <input class="form-control my-2" type="text" value="
<?php
                        if ($i == 0) {
                            if (round($mat[$i][$j], 2) == 0) {
                                echo round($mat[$i][$j], 2);
                            } else {
                                echo -1 * round($mat[$i][$j], 2);
                            }
                        } else {
                            echo round($mat[$i][$j], 2);
                        }
?>
                        " aria-label="Disabled input example" disabled readonly style="width: 100px;">
                        </div>
                    <?php
                    }
                    ?>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
<?php
}

function printMatPivot($mat, $iteracao, $piv)
{
    $lin = count($mat);
    $col = count($mat[0]);
?>
    <div class="card text-center border-dark mt-5">
        <div class="card-header" style="font-family: Krona One;">
            <?php echo 'Iteração ' . $iteracao . ' - Encontrando Pivo' ?>
        </div>

        <div class="m-2">
            <div class="row row-auto">
                <div class="col col-auto">
                    <div class="my-2 fw-bold" style="width: 100px; height: 30px;">
                    </div>
                </div>
                <?php
                for ($j = 0; $j < $col; $j++) {
                ?>
                    <div class="col col-auto">
                        <?php
                        if ($j < $GLOBALS['m']) {
                        ?>
                            <div class="my-2 fw-bold" style="width: 100px; height: 30px;"><?php echo 'x' . $j + 1 ?></div>
                        <?php
                        }
                        if ($j > $GLOBALS['m'] - 1 && $j != $col - 1) {
                        ?>
                            <div class="my-2 fw-bold" style="width: 100px; height: 30px;"><?php echo 'sx' . $j + 1 ?></div>
                        <?php
                        }
                        if ($j == $col - 1) {
                        ?>
                            <div class="my-2 fw-bold" style="width: 100px; height: 30px;"><?php echo 'Solução' ?></div>
                        <?php
                        }
                        ?>

                    </div>
                <?php
                }
                ?>
            </div>

            <?php
            for ($i = 0; $i < $lin; $i++) {
            ?> <div class="row row-auto">
                    <div class="col col-auto">
                        <div class="my-2 fw-bold" style="width: 100px; height: 30px;">
                            <?php
                            if ($i == 0) {
                                echo 'z (' . substr($_POST['options'], 0, 3) . ')';
                            } else {
                                echo $GLOBALS['base'][$i - 1];
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    for ($j = 0; $j < $col; $j++) {
                    ?>
                        <div class="col col-auto">
                            <input class="form-control my-2" type="text" value="
<?php
                        if ($i == 0) {
                            if (round($mat[$i][$j], 2) == 0) {
                                echo round($mat[$i][$j], 2);
                            } else {
                                echo -1 * round($mat[$i][$j], 2);
                            }
                        } else {
                            echo round($mat[$i][$j], 2);
                        }
?>
                        " aria-label="Disabled input example" disabled readonly style="width: 100px;
<?php
                        if ($i == $piv[0] && $j == $piv[1]) {
                            print 'background-color:green; color: white';
                        } elseif ($i == $piv[0] || $j == $piv[1]) {
                            print 'background-color:red; color: white';
                        }
?>
                        ">
                        </div>
                    <?php
                    }
                    ?>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
<?php
}

function printMatSolved($mat, $iteracao, $piv)
{
    $lin = count($mat);
    $col = count($mat[0]);
?>
    <div class="card text-center border-dark mt-5">
        <div class="card-header" style="font-family: Krona One;">
            <?php echo 'Iteração ' . $iteracao . ' - Solução Ótima' ?>
        </div>

        <div class="m-2">
            <div class="row row-auto">
                <div class="col col-auto">
                    <div class="my-2 fw-bold" style="width: 100px; height: 30px;">
                    </div>
                </div>
                <?php
                for ($j = 0; $j < $col; $j++) {
                ?>
                    <div class="col col-auto">
                        <?php
                        if ($j < $GLOBALS['m']) {
                        ?>
                            <div class="my-2 fw-bold" style="width: 100px; height: 30px;"><?php echo 'x' . $j + 1 ?></div>
                        <?php
                        }
                        if ($j > $GLOBALS['m'] - 1 && $j != $col - 1) {
                        ?>
                            <div class="my-2 fw-bold" style="width: 100px; height: 30px;"><?php echo 'sx' . $j + 1 ?></div>
                        <?php
                        }
                        if ($j == $col - 1) {
                        ?>
                            <div class="my-2 fw-bold" style="width: 100px; height: 30px;"><?php echo 'Solução' ?></div>
                        <?php
                        }
                        ?>

                    </div>
                <?php
                }
                ?>
            </div>

            <?php
            for ($i = 0; $i < $lin; $i++) {
            ?> <div class="row row-auto">
                    <div class="col col-auto">
                        <div class="my-2 fw-bold" style="width: 100px; height: 30px;">
                            <?php
                            if ($i == 0) {
                                echo 'z (' . substr($_POST['options'], 0, 3) . ')';
                            } else {
                                echo $GLOBALS['base'][$i - 1];
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    for ($j = 0; $j < $col; $j++) {
                    ?>
                        <div class="col col-auto">
                            <input class="form-control my-2" type="text" value="
<?php
                        if ($i == 0) {
                            if (round($mat[$i][$j], 2) == 0) {
                                echo round($mat[$i][$j], 2);
                            } else {
                                echo -1 * round($mat[$i][$j], 2);
                            }
                        } else {
                            echo round($mat[$i][$j], 2);
                        }
?>
                        " aria-label="Disabled input example" disabled readonly style="width: 100px;
<?php
                        if ($j == $col - 1) {
                            print 'background-color:green; color: white';
                        }
?>
                        ">
                        </div>
                    <?php
                    }
                    ?>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
<?php
}

//----------------------------------------------------------------------------------------

//FUNÇÕES PARA REALIZAR O SIMPLEX MAXIMIZAÇÃO

function checkOptimality($mat)
{ //teste de otimalidade
    for ($j = 0; $j < count($mat[0]); $j++) {
        if ($mat[0][$j] > 0) {
            return false;
        }
    }
    return true;
}

function escalona($mat, $pivot)
{ //escalona a matriz para transformar o pivo em 1 e os elementos acima e abaixo dele em 0
    $GLOBALS['base'][$pivot[0] - 1] = 'x' . $pivot[1] + 1;
    $div = $mat[$pivot[0]][$pivot[1]];
    for ($i = 0; $i < count($mat[0]); $i++) {
        $mat[$pivot[0]][$i] = ($mat[$pivot[0]][$i]) / $div; //divide a linha pivo pelo elemento pivo para transforma-lo em 1
    }

    for ($i = 0; $i < count($mat); $i++) {
        $mult = $mat[$i][$pivot[1]];
        if ($i != $pivot[0]) {
            for ($j = 0; $j < count($mat[0]); $j++) {
                $mat[$i][$j] -= $mult * $mat[$pivot[0]][$j]; //zera o elemento acima do pivo e faz a subtração entre as demais colunas
            }
        }
    }
    return $mat;
}
function findPivot($mat)
{ //encontra a linha e coluna do elemento pivo
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

    for ($i = 1; $i < $lin; $i++) { //encontra a linha pivo
        if ($mat[$i][$pivotCol] != 0) {
            if (($mat[$i][$col - 1] / $mat[$i][$pivotCol]) < $maxRow  && ($mat[$i][$col - 1] / $mat[$i][$pivotCol])  >= 0) { //teste da razão mínima
                $maxRow = ($mat[$i][$col - 1] / $mat[$i][$pivotCol]);
                $pivotRow = $i;
            }
        }
    }
    $pivot = array($pivotRow, $pivotCol);
    return $pivot;
}
function maximizeSimplex($mat)
{ //realiza maximização pelo método simplex tabular
    $it = 1;
    do {
        if ($it >= 20) break; // para de executar caso efetue mais de 20 iterações
        printMat($mat, $it);
        $piv = findPivot($mat);
        printMatPivot($mat, $it, $piv);
        $mat = escalona($mat, $piv);
        if (checkOptimality($mat)) {
            $it++;
            printMatSolved($mat, $it, $piv);
            break;
        }
        $it++;
    } while (!checkOptimality($mat)); //realiza outra iteração enquanto não encontrar uma solução ótima
}

//----------------------------------------------------------------------------------------

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
        <div class="container d-flex flex-column justify-content-center align-items-center p-3">
            <?php maximizeSimplex(mkMatriz($n, $m)) ?>
        </div>
    </div>
</body>

</html>