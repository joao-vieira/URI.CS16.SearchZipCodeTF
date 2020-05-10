<?php

require 'vendor/autoload.php';

$manager = new \PHPTF\Manager();
$validator = new \PHPTF\Validator();

echo "\n\n \033[34m \t\t== Seja bem-vindo ao buscador de CEP (tolerante à falhas) == \n";
echo "\033[94m \tPrimeiro, escolha uma das ações abaixo e depois informe o CEP desejado (apenas 8 números) \n";
echo "\033[94m \t0. Finaliza; 1. Execução Paralela; 2. Falha ViaCEP; 3. Falha República Virtual; 4. Simular falha utilizando um CEP incorreto \n\n";

$break = false;
while (!$break) {
    $option = $validator->readFromUser(2, 'Opção de Execução: ', 'Tem como usar apenas as opções disponibilizadas? çç');
    if ($option) {
        $zipCode = $validator->readFromUser($option == 4 ? 3 : 1, 'CEP: ', 'A gente disse pra utilizar apenas 8 números :)');
        $manager->run($zipCode, (int) $option);        
    } else {
        $break = true;
    }
}