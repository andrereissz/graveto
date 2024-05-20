<?php
    
    var_dump($_POST);
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>teste</title>
</head>
<body>
    <?php

    for($i=0;$i<$_POST["rest"];$i++){
        print("<p>");
        for($j=0;$j<$_POST["var"];$j++){
            echo($_POST["v".$i.$j]);
            if($j != $_POST["var"] - 1){
                echo(" + ");
            }else{
                echo(" ");
            }
        }
        echo(implode($_POST["s".$i])." ".$_POST["r".$i]);
        print("</p>");
    }

    ?>
</body>
</html>