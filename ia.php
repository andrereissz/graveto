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
    problema: 'Maximizar',
    objetivo: [2, 3],
    restricoes: [
      [1, 1],
      [2, 2],
      [10, 3],
    ],
    relacoes: ['<=', '=', '>='],
    rhs: [5, 8, 7],
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

// Imprima a resposta
if (isset($responseData['choices'][0]['message']['content'])) {
    $reply = $responseData['choices'][0]['message']['content'];
    echo $reply;
} else {
    echo 'Erro ao obter a resposta do ChatGPT';
}
