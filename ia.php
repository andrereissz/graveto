<?php

include('apykey.php');

$questao = $_POST['prompt'];

// A URL da API OpenAI
$url = 'https://api.openai.com/v1/chat/completions';

// O cabeçalho HTTP com a chave da API
$headers = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey,
];

const json_modelo = "{
    problema: 'Maximize',
    objetivo: [2, 3],
    restricoes: [
      [1, 1],
      [2, 2],
      [10, 3],
    ],
    sinais: ['<=', '=', '>='],
    rhs: [5, 8, 7],
  };";

$mensagem = "
    `Você é um assistente capaz de extrair dados de um problema linear descrito em linguagem natural e propor a função de maximização ou minimização do problema bem como suas equações de restrição. Sua resposta deve ser no formato de JSON, da seguinte forma:
    Após analizar o problema em linguagem natural e chegar nas equações:
    Max(z) = 2x1 + 3x2
    Sujeito a:
    x1 + x2 <= 5
    2x1 + 2x2 = 8
    10x1 + 3x2 >= 7

    A resposta no formato JSON, considerando o problema acima, deve ser:
    "
    . json_decode(json_modelo) .
    "

    Onde as seguintes regras devem ser estritamente seguidas:
    Caso a função objetivo seja de maximização, você deve usar o valor 'Maximize' no campo 'problema'. Caso contrário você deve usar o valor 'Minimize'.
    para cada restrição, existe uma relação atrelada. No campo relações, deve ser colocado na ordem em que as restrições se apresentam, de modo que caso a restrição seja do tipo <=, você deve usar o valor '<=' no campo. Caso a restrição seja do tipo =, você deve usar o valor '=' no campo e caso a restrição seja do tipo >=, você deve usar o valor '>=' no campo.
    Note que o problema só pode ser de minimização ou maximização, e pode ter 2 ou mais variáveis e 2 ou mais restrições.
    Não use nomes relativos ao problema em linguagem natural dentro de sua resposta, pois ela deve ser exclusivamente da forma que o JSON de exemplo está estruturado.
    Em caso de uma variável não ser usada em uma restrição mas ser usada em outra, ela deve constar como 0 na restrição em que não é usada.
    Sua resposta deve conter apenas o JSON, conforme o padrão apresentado, com os valores das equações do problema sem nenhuma explicação adicional.
    `

    ";

// O corpo da requisição
$data = [
    'model' => 'gpt-3.5-turbo', // ou 'gpt-3.5-turbo'
    'messages' => [
        [
            'role' => 'user',
            'content' => '
                "
                ' . $mensagem . '
                "
                "
                ' . $prompt . '
                "
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
var_dump($responseData);

// Imprima a resposta
if (isset($responseData['choices'][0]['message']['content'])) {
    $reply = $responseData['choices'][0]['message']['content'];
    echo 'Resposta do ChatGPT: ' . $reply;
} else {
    echo 'Erro ao obter a resposta do ChatGPT';
}
