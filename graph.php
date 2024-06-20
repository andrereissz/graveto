<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>SOLUÇÃO GRÁFICA</title>

    <link rel="stylesheet" href="css/graph.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link href='https://fonts.googleapis.com/css?family=Krona One' rel='stylesheet'>

    <script type="text/javascript" src="js/graph/jquery-1.10.2.min.js"></script>
</head>

<body>

    <canvas id="canvas"></canvas>

    <script type="text/javascript" src="js/graph/functions.js"></script>
    <script type="text/javascript" src="js/graph/core.js"></script>


    <!--<div style="position:absolute;padding:2px;">Y = <input id="Function" onKeyUp="keyPress()" size="30" type="text" value="x*x" placeholder="Function"/></div>-->

    <div class="size">
        <img class="color_change" src="images/color_1.png" alt="Color changing" />
        <img class="default" src="images/default.png" alt="default" />
        <img class="minus" src="images/minus.png" alt="minus" />
        <img class="plus" src="images/plus.png" alt="plus" />
    </div>

    <div id="graphs">
        <div class="graphs"></div>
        <div class='add_graph'>ADD GRAPH</div>
    </div>

    <div id="add_graph_form">
        <div class="bg"></div>

        <div class="little_form" id="add">
            <label>Y = </label><input id="Function" type="text" value="" placeholder="Function" />
            <div class="color"></div>
            <button class="function_submit">ADD</button>
            <button class="function_back">BACK</button>
        </div>

        <div class="little_form" id="edit">
            <label>Y = </label><input id="Function_edit" type="text" value="" placeholder="Function" />
            <div class="color_edit"></div>
            <button class="function_submit_edit">EDIT</button>
            <button class="function_back_edit">BACK</button>
            <div class="graph_id"></div>
        </div>

        <div class="message">WARNING: If you write bad graph input, graph will not show! Example:
            Math.sin(x*x)+Math.tan(x)</div>
        <div id="functions">
            <table>
                <tr>
                    <td rowspan="17"><strong>Mathematical functions in Javascript: </strong></td>
                    <td>abs(x)</td>
                    <td>Returns the absolute value of x</td>
                </tr>
                <tr>
                    <td>pow(x,y)</td>
                    <td>Returns the value of x to the power of y</td>
                </tr>
                <tr>
                    <td>sqrt(x)</td>
                    <td>Returns the square root of x</td>
                </tr>
                <tr>
                    <td>round(x)</td>
                    <td>Rounds x to the nearest integer</td>
                </tr>
                <tr>
                    <td>floor(x)</td>
                    <td>Returns x, rounded downwards to the nearest integer</td>
                </tr>
                <tr>
                    <td>ceil(x)</td>
                    <td>Returns x, rounded upwards to the nearest integer</td>
                </tr>
                <tr>
                    <td>sin(x)</td>
                    <td>Returns the sine of x (x is in radians)</td>
                </tr>
                <tr>
                    <td>asin(x)</td>
                    <td>Returns the arcsine of x, in radians</td>
                </tr>
                <tr>
                    <td>cos(x)</td>
                    <td>Returns the cosine of x (x is in radians)</td>
                </tr>
                <tr>
                    <td>acos(x)</td>
                    <td>Returns the arccosine of x, in radians</td>
                </tr>
                <tr>
                    <td>tan(x)</td>
                    <td>Returns the tangent of an angle</td>
                </tr>
                <tr>
                    <td>atan(x)</td>
                    <td>Returns the arctangent of x as a numeric value between -PI/2 and PI/2 radians</td>
                </tr>
                <tr>
                    <td>atan2(y,x)</td>
                    <td>Returns the arctangent of the quotient of its arguments</td>
                </tr>
                <tr>
                    <td>exp(x)</td>
                    <td>Returns the value of E on x</td>
                </tr>
                <tr>
                    <td>log(x)</td>
                    <td>Returns the natural logarithm (base E) of x</td>
                </tr>
                <tr>
                    <td>max(x,y,z,...,n)</td>
                    <td>Returns the number with the highest value</td>
                </tr>
                <tr>
                    <td>min(x,y,z,...,n)</td>
                    <td>Returns the number with the lowest value</td>
                </tr>
            </table>
        </div>
    </div>

    <div id="loading">Loading...</div>
    <a target="_blank" href="http://filfar.eu/"><img id="filfar" style="width:32px; height:32px;" src="images/filfar.png" alt="filfar.eu" /></a>

</body>

</html>