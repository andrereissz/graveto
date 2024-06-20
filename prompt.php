<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>GRAVETO</title>
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
                    Input usando IA
                </div>
                <div class="card-body">
                    <form action="ia.php" method="POST">
                        <div class="row row-auto mb-3">
                            <div class="col col-auto">
                                <textarea name="input" id="input" rows="6" style="width: 500px; padding: 5px;" placeholder="Lembre-se, deixe bem clara a definição do problema. Apresente variáveis, restrições e limites em seu problema..."></textarea>
                            </div>
                        </div>
                        <div class="row row-auto">
                            <div class="col col-sm">
                                <input type="submit" class="btn btn-primary" value="Enviar">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="js/bootstrap/bootstrap.bundle.js"></script>
</body>

</html>