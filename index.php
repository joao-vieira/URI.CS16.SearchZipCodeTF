<?php

require 'vendor/autoload.php';

$manager = new \PHPTF\Manager();
$validator = new \PHPTF\Validator();

echo "\n\n \033[34m \t\t== Seja bem-vindo ao buscador de CEP (tolerante à falhas) == \n";
echo "\033[94m \tPrimeiro, informe o CEP desejado (apenas 8 números) e depois escolha uma das ações abaixo! \n";
echo "\033[94m \t0. Finaliza; 1. Execução Paralela; 2. Falha ViaCEP; 3. Falha República Virtual \n\n";

$zipCode = $validator->readFromUser(1, 'CEP: ', 'A gente disse pra utilizar apenas 8 números :)');
$option = $validator->readFromUser(2, 'Opção de Execução: ', 'Tem como usar apenas as opções disponibilizadas? çç');

$manager->run((int) $zipCode, $option);