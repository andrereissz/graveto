<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>DEFININDO PROBLEMA</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link href='https://fonts.googleapis.com/css?family=Krona One' rel='stylesheet'>
</head>

<body>
    <div class="divzona d-flex flex-column min-vh-100 min-vw-100" style="background-color: #C6FFCB;">
        <div class="container d-flex flex-grow-1 justify-content-center align-items-center">
            <div class="card text-center border-dark">
                <div class="card-header" style="font-family: Krona One;">
                    Definindo Problema
                </div>
                <div class="card-body">
                    <form action="definicao.php" method="POST">

                        <div class="row mt-2">
                            <div class="col-8">
                                <h6 class="card-title">Informe a quantidade de variáveis</h5>
                            </div>
                            <div class="col-4">
                                <input class="num" type="number" id="var" name="var" min="1">
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col col-8">
                                <h6 class="card-title">Informe a quantidade de restrições</h5>
                            </div>
                            <div class="col col-4">
                                <input class="num" type="number" id="rest" name="rest" min="1">
                            </div>
                        </div>

                        <div class="row mt-2 justify-content-center">
                            <input type="submit" class="btn btn-graveto" style="font-family: Krona One; width: 40%;" value="Continuar">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="js/bootstrap/bootstrap.bundle.js"></script>
</body>

</html>