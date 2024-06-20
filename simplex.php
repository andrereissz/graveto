<?php

$n = $_POST["rest"];
$m = $_POST["var"];
$base = [];
$zinteira = [];

for ($j = 0; $j < $m; $j++) {
    array_push($zinteira, $_POST['z' . $j]);
}

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
            $z[$j] = $_POST["z" . $j] * -1;
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
        array_push($GLOBALS['base'], 's' . $n + $i);
    }
    return (verificaSinal($matOut));
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
                                echo abs(round($mat[$i][$j], 2));
                            } else {
                                echo round($mat[$i][$j], 2);
                            }
                        } elseif (round($mat[$i][$j], 2) == 0) {
                            echo abs(round($mat[$i][$j], 2));
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
                                echo abs(round($mat[$i][$j], 2));
                            } else {
                                echo round($mat[$i][$j], 2);
                            }
                        } elseif (round($mat[$i][$j], 2) == 0) {
                            echo abs(round($mat[$i][$j], 2));
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
            <form action="inteira.php" method="POST">
                <?php
                $variaveis = [];
                $valores = [];
                $zenviar = [];
                for ($var = 0; $var < $GLOBALS['m']; $var++) {
                ?> <input type="hidden" name="zenviar[<?php $var ?>]" value="<?php echo $GLOBALS['zinteira'][$var] ?>">
                <?php
                }

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
                                <input class="form-control my-2" name="v<?php echo $i . $j ?>" type="text" value="
<?php
                            if ($i == 0) {
                                if (round($mat[$i][$j], 2) == 0) {
                                    echo abs(round($mat[$i][$j], 2));
                                } else {
                                    echo round($mat[$i][$j], 2);
                                }
                            } elseif (round($mat[$i][$j], 2) == 0) {
                                echo abs(round($mat[$i][$j], 2));
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

                            if ($i != 0 && $j == 0 && substr($GLOBALS["base"][$i - 1], 0, 1) == 'x') {
                                array_push($variaveis, 'v' . substr($GLOBALS["base"][$i - 1], 1, 1))
                            ?>
                                <input type="hidden" name="variaveis[<?php echo substr($GLOBALS["base"][$i - 1], 1, 1) - 1 ?>]" value="<?php echo 'x' . substr($GLOBALS["base"][$i - 1], 1, 1) ?>">
                                <input type="hidden" name="valores[<?php echo substr($GLOBALS["base"][$i - 1], 1, 1) - 1 ?>]" value="<?php echo intval($mat[$i][$col - 1]) ?>">
                            <?php
                            }

                            ?>
                        <?php
                        }
                        ?>
                    </div>
                <?php
                }
                ?>
                <div class="row row-auto">
                    <div class="col w-full align-center">
                        <input type="submit" class="btn btn-success w-25 justify-center " id="inteira" value="Solução Inteira">
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php
}

//FUNÇÕES PARA REALIZAR O SIMPLEX MAXIMIZAÇÃO

function findPivot($mat)
{ //encontra a linha e coluna do elemento pivo
    $lin = count($mat);
    $col = count($mat[0]);
    $maxCol = PHP_INT_MIN;
    $pivotCol = 0;
    $maxRow = PHP_INT_MAX;
    $pivotRow = 0;

    for ($j = 0; $j < $col - 1; $j++) { //encontra a coluna pivo
        if ($mat[0][$j] < 0 && abs($mat[0][$j]) > $maxCol) {
            $maxCol = abs($mat[0][$j]);
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

function checkOptimality($mat)
{ //teste de otimalidade
    for ($j = 0; $j < count($mat[0]); $j++) {
        if ($mat[0][$j] < 0) {
            return false;
        }
    }
    return true;
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

//-----------------------------------------------------------------------------------------------------------------------
//FUNÇÕES PARA REALIZAR DUAL SIMPLEX


function verificaSinal($mat)
{
    for ($i = 1; $i <= count($mat); $i++) {
        $substr = '';
        for ($j = 1; $j <= 3; $j++) {
            if (isset($_POST["s" . ($i - 1) . $j])) {
                $substr = $substr . $_POST["s" . ($i - 1) . $j];
            }
        }
        if ($substr == '=>' || $substr == '=') {
            for ($j = 0; $j < count($mat[$i]); $j++) {
                $mat[$i][$j] *= -1;
            }
        }
    }

    return $mat;
}

function findPivotDual($mat)
{ //encontra a linha e coluna do elemento pivo
    $lin = count($mat);
    $col = count($mat[0]);
    $pivotCol = 0;
    $pivotRow = 0;
    $minRow = PHP_INT_MAX;
    $minCol = PHP_INT_MAX;

    for ($i = 1; $i <= $lin - 1; $i++) { //encontra a linha pivo
        if ($mat[$i][$col - 1] < $minRow) {
            $minRow = $mat[$i][$col - 1];
            $pivotRow = $i;
        }
    }

    for ($j = 0; $j < $col - 1; $j++) {
        if ($mat[$pivotRow][$j] != 0 && $mat[0][$j] != 0) {
            if (abs($mat[0][$j] / $mat[$pivotRow][$j]) < $minCol) {
                $minCol = abs($mat[0][$j] / $mat[$pivotRow][$j]);
                $pivotCol = $j;
            }
        }
    }

    $pivot = array($pivotRow, $pivotCol);
    return $pivot;
}


function escalonaDual($mat, $pivot)
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

function checkOptimalityDual($mat)
{ //teste de otimalidade
    for ($i = 1; $i < $GLOBALS['n']; $i++) {
        if ($mat[$i][count($mat[$i]) - 1] < 0) {
            return false;
        }
    }
    return true;
}

function minimizeDualSimplex($mat)
{ //realiza maximização pelo método simplex tabular
    $it = 1;
    do {
        if ($it >= 20) break; // para de executar caso efetue mais de 20 iterações
        printMat($mat, $it);
        $piv = findPivotDual($mat);
        printMatPivot($mat, $it, $piv);
        $mat = escalona($mat, $piv);
        if (checkOptimalityDual($mat)) {
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
        <a href="index.php" class="btn position-absolute rounded-circle m-2" style="width: 100px; height: 100px; background-image: url('views/components/btn.png'); background-size: 100% 100%; scale: -1;"></a>
        <div class="container d-flex flex-column justify-content-center align-items-center p-3">
            <?php
            if (substr($_POST['options'], 0, 3) == 'Max') {
                maximizeSimplex(mkMatriz($n, $m));
            } else minimizeDualSimplex(mkMatriz($n, $m));
            ?>
        </div>
    </div>

    <script src="js/bootstrap/bootstrap.bundle.js"></script>
</body>

</html>