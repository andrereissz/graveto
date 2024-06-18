<?php

var_dump($_POST);

/*$matriz = array(
    array(3,5,0,0,0,0),
    array(1,0,1,0,0,4),
    array(0,2,0,1,0,12),
    array(3,2,0,0,1,18)
);*/

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
