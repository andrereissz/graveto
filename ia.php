<?php

include('apikey.php');

$questao = $_POST['input'];

// A URL da API OpenAI
$url = 'https://api.openai.com/v1/chat/completions';

// O cabeçalho HTTP com a chave da API
$headers = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey,
];

$json_modelo = "{
    'problema': 'Maximizar',
    'objetivo': [2, 3],
    'restricoes': [
      [1, 1],
      [2, 2],
      [10, 3],
    ],
    'relacoes': ['<=', '=', '>='],
    'rhs': [5, 8, 7],
  }";

$mensagem = "
    Você é um assistente capaz de resolver problemas de programação linear, a sua solução deve ser retornada como um json seguindo o modelo abaixo:

    Após analizar o problema em linguagem natural e chegar nas equações: Max(z) = 2x1 + 3x2 Sujeito a: x1 + x2 <= 5 2x1 + 2x2 = 8 10x1 + 3x2 >= 7 
    A resposta no formato JSON, considerando o problema acima, deve ser: { problema: 'Maximizar', objetivo: [2, 3], restricoes: [ [1, 1], [2, 2], [10, 3], ], relacoes: ['<=', '=', '>='], rhs: [5, 8, 7], }

        " . $json_modelo . "

    Não use nomes relativos ao problema em linguagem natural dentro de sua resposta, pois ela deve ser exclusivamente da forma que o JSON de exemplo está estruturado.

    Para um bom funcionamento as seguintes regras devem ser estritamente seguidas:
    Caso a função objetivo seja de maximização, você deve usar o valor 'Maximize' no campo 'problema'. Caso contrário você deve usar o valor 'Minimize'.
    para cada restrição, existe uma relação atrelada. No campo relações, deve ser colocado na ordem em que as restrições se apresentam, de modo que caso a restrição seja do tipo <=, você deve usar o valor '<=' no campo. Caso a restrição seja do tipo =, você deve usar o valor '=' no campo e caso a restrição seja do tipo >=, você deve usar o valor '>=' no campo.
    Sua resposta deve conter apenas o JSON, conforme o padrão apresentado, com os valores das equações do problema sem nenhuma explicação adicional.

    Problema a ser resolvido seguindo o modelo, retorne a resposta sem explicações:";

// O corpo da requisição
$data = [
    'model' => 'gpt-3.5-turbo-1106', // ou 'gpt-3.5-turbo'
    'messages' => [
        [
            'role' => 'user',
            'content' => '
                ' . $mensagem . $questao . '
            '
        ],
    ],
    'max_tokens' => 150,
];

// Inicialize o cURL
$ch = curl_init($url);

// Configure as opções do cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Execute a requisição e obtenha a resposta
$response = curl_exec($ch);

// Feche a conexão cURL
curl_close($ch);

// Converta a resposta JSON em um array PHP
$responseData = json_decode($response, true);
$json = $responseData["choices"][0]["message"]["content"];
$jsonData = json_decode($json, true);

$problema = $jsonData['problema'];
$objetivo = $jsonData['objetivo'];
$restricoes = $jsonData['restricoes'];
$relacoes = $jsonData['relacoes'];
$rhs = $jsonData['rhs'];


$var = count($objetivo);
$rest = count($restricoes);

function like($needle, $haystack)
{
    $regex = '/' . str_replace('%', '.*?', $needle) . '/';

    return preg_match($regex, $haystack) > 0;
}
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
                        <input type="hidden" name="var" value="<?php echo $var ?>">
                        <input type="hidden" name="rest" value="<?php echo $rest ?>">

                        <!-- Corpo do card -->
                        <div class="col col-auto">

                            <!-- Primeira linha ( definir se é maximização ou minimização ) -->
                            <div class="row mb-2">
                                <div class="col col-auto">
                                    <p>Informe o tipo de problema</p>
                                </div>
                                <div class="col">
                                    <input type="radio" class="btn-check" name="options" id="option1" value="Maximizar" autocomplete="off" <?php if ($problema == 'Maximizar') print 'checked'; ?>>
                                    <label class="btn btn-outline-warning btn-sm" for="option1">Maximizar</label>
                                    <input type="radio" class="btn-check" name="options" id="option2" value="Minimizar" autocomplete="off" <?php if ($problema == 'Minimizar') print 'checked'; ?>>
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
                                            <input class="num" type="number" name="z<?php echo ($j) ?>" id="z<?php echo ($j) ?>" value="<?php echo $objetivo[$j] ?>">
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
                                            <input class="num" type="number" name="v<?php echo ($i . $j) ?>" id="v<?php echo ($i . $j) ?>" value="<?php echo $restricoes[$i][$j] ?>">
                                        </div>
                                    <?php } ?>

                                    <!-- Define os sinais -->
                                    <div class="col col-auto">
                                        <div class="btn-group" role="group" aria-label="Basic example" style="margin-bottom: 7px; height: 30px">

                                            <input type="checkbox" class="btn-check" name="s<?php echo ($i) ?>1" value="<" id="s<?php echo ($i) ?>1" autocomplete="off" <?php if (like('<%', $relacoes[$i])) print 'checked'; ?>>
                                            <label class="btn btn-outline-warning btn-sm" for="s<?php echo ($i) ?>1"><?php echo "<" ?></label>

                                            <input type="checkbox" class="btn-check" name="s<?php echo ($i) ?>2" value="=" id="s<?php echo ($i) ?>2" autocomplete="off" <?php if (like('%=%', $relacoes[$i])) print 'checked'; ?>>
                                            <label class="btn btn-outline-warning btn-sm" for="s<?php echo ($i) ?>2">=</label>

                                            <input type="checkbox" class="btn-check" name="s<?php echo ($i) ?>3" value=">" id="s<?php echo ($i) ?>3" autocomplete="off" <?php if (like('%>', $relacoes[$i])) print 'checked'; ?>>
                                            <label class="btn btn-outline-warning btn-sm" for="s<?php echo ($i) ?>3">></label>

                                        </div>
                                    </div>
                                    <div class="col col-auto">
                                        <input class="num" type="number" name="r<?php echo ($i) ?>" id="r<?php echo ($i . "_" . $j) ?>" value="<?php echo $rhs[$i] ?>">
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
    <script src="js/bootstrap/bootstrap.bundle.js"></script>
</body>