<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

require __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/..');
$dotenv->load();

$idTransazione = substr(uniqid(), 0, 20);

$client = new Client([
    'timeout' => 2.0,
    'cert' => $_ENV['AUTH_CERT'], // Percorso al certificato client
    'ssl_key' => $_ENV['AUTH_KEY'], // Percorso della chiave privata
    'verify' => $_ENV['CA_CERT'], // Percorso al certificato CA per verificare il server
    'headers' => [
        'Content-Type' => 'application/json',
        'X-Bps-Tt-IdOperazione-CodiceApplicazioneChiamante' => 'SERVIZIO',
        'X-Bps-Tt-IdOperazione-CodiceOperazione' => $idTransazione,
        'X-Bps-Tt-IdConversazione' => $idTransazione,
        'X-Bps-Tc-CodiceApplicazione' => 'SERVIZIO',
        'X-Bps-Tc-CodiceCanale' => 'ITN',
        'X-Bps-Tc-CodiceIstituto' => '05696',
    ],
]);

$xml = base64_encode(file_get_contents('../xml/file.xml'));

try {
    $response = $client->request('POST', $_ENV['POPSO_ENDPOINT'], [
            'json' => [
                'IdTransazione' => $idTransazione,
                'CodiceServizio' => '00001',
                'XmlMavOnline' => $xml,
            ]
        ]
    );
}
catch (RequestException $e) {
    echo $e->getResponse()->getBody();
    exit;
}

echo "RESPONSE:".PHP_EOL;
echo $response->getStatusCode().PHP_EOL;

echo $response->getBody().PHP_EOL;

echo "Decoded XML:".PHP_EOL;
$response->getBody();

$dataArray = json_decode($response->getBody(), true);
$outXml = $dataArray['xmlResponse'];
echo base64_decode($outXml);

