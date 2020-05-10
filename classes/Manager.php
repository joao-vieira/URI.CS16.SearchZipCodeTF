<?php

namespace PHPTF;

use GuzzleHttp\{Client, Promise};

class Manager
{
  const VIACEP_BASE_URL = 'https://viacep.com.br/ws/';
  const REPVIRTUAL_BASE_URL = 'http://cep.republicavirtual.com.br';

  protected $http;


  public function __construct() {
    $this->viaCepHTTP = new Client(['base_uri' => Manager::VIACEP_BASE_URL]);
    $this->repVirtualHTTP = new Client(['base_uri' => Manager::REPVIRTUAL_BASE_URL]);
  }

  /**
   * Performs the main function of the manager
   *
   * @param int $zipCode
   * @param integer $option
   *
   * @return void
   */
  public function run(string $zipCode, int $option): void
  {
    switch ($option) {
      case 1:
        $this->parallelExecution($zipCode);
      break;
      
      case 2:
        $this->viaCepFault($zipCode);
      break;
      
      case 3:
        $this->repVirtualFault($zipCode);
      break;
      
      case 4:
        $this->sendCepWithoutValidation($zipCode);
      break;

      default:
        echo 'Esperamos que encontre seu destino :P';
      break;
    }
  }

  /**
   * Performs two requests simultaneously and displays the result when both are finished
   *
   * @param string $zipCode
   *
   * @return void
   */
  private function parallelExecution(string $zipCode): void
  {
    $promises = [
      'viaCep' => $this->viaCepHTTP->getAsync("$zipCode/json"),
      'repVirtual' => $this->repVirtualHTTP->getAsync("/web_cep.php?cep=$zipCode&formato=json"),
    ];

    $responses = Promise\settle($promises)->wait();

    ['viaCep' => $viaCep, 'repVirtual' => $repVirtual] = $responses;

    $viaCepResult = json_decode($viaCep['value']->getBody(), true);
    $repVirtualResult = json_decode($repVirtual['value']->getBody(), true);

    $this->showResult("Resultado ViaCEP [$zipCode]", $viaCepResult);
    $this->showResult("Resultado República Virtual [$zipCode]", $repVirtualResult);
  }

  /**
   * Causes a forced error in the viacep request
   *
   * @param string $zipCode
   * 
   * @return void
   */
  private function viaCepFault(string $zipCode): void
  {
    try {
      $this->viaCepHTTP->get("$zipCode/dasdasdasdjson");
    } catch (\Throwable $th) {
      [$errorMessage] = explode('response', $th->getMessage());
      
      echo "\n\n \e[91m \t#### Oops! Resultado ViaCEP [$zipCode] #### \n";
      echo "\t => $errorMessage \n\n";
    }

    $response = $this->repVirtualHTTP->get("/web_cep.php?cep=$zipCode&formato=json");
    $repVirtualResult = json_decode($response->getBody(), true);
    $this->showResult("Ainda bem que temos um plano B! Resultado República Virtual [$zipCode]", $repVirtualResult);
  }

  /**
   * Causes a forced error in the repúblicavirtual request
   *
   * @param string $zipCode
   *
   * @return void
   */
  private function repVirtualFault(string $zipCode): void
  {
    try {
      $this->repVirtualHTTP->get("/web_cep.asdasdsdphp?cep=$zipCode&formato=json");
    } catch (\Throwable $th) {
      [$errorMessage] = explode('response', $th->getMessage());
      
      echo "\n\n \e[91m \t#### Oops! Resultado República Virtual [$zipCode] #### \n";
      echo "\t => $errorMessage \n\n";
    }

    $response = $this->viaCepHTTP->get("$zipCode/json");
    $viaCepResult = json_decode($response->getBody(), true);
    $this->showResult("Ainda bem que temos um plano B! Resultado ViaCEP [$zipCode]", $viaCepResult);
  }

  /**
   * Performs a request without validating the zip code
   *
   * @param string $zipCode
   *
   * @return void
   */
  private function sendCepWithoutValidation(string $zipCode): void
  {
    try {
      $viaCepResponse = $this->viaCepHTTP->get("$zipCode/json");
      $viaCepResult = json_decode($viaCepResponse->getBody(), true);
      if (array_key_exists('erro', $viaCepResult)) {
        throw new \Exception('Não foi possível encontrar o CEP informado!');
      } else {
        $this->showResult("Resultado ViaCep [$zipCode]", $viaCepResult);
      }
    } catch (\Throwable $th) {
      [$errorMessage] = explode('response', $th->getMessage());

      echo "\n\n \033[91m \t#### Oops! Resultado ViaCEP [$zipCode] #### \n";
      echo "\t => $errorMessage \n\n";
    }

    try {
      $repVirtualResponse = $this->repVirtualHTTP->get("/web_cep.php?cep=$zipCode&formato=json");
      $repVirtualResult = json_decode($repVirtualResponse->getBody(), true);
      if ($repVirtualResult['resultado']) {
        $this->showResult("Resultado República Virtual [$zipCode]", $repVirtualResult);
      } else {
        echo "\n\n \033[91m \t#### Oops! Resultado República Virtual [$zipCode] #### \n";
        $errorMessage = $repVirtualResult['debug'];
        echo "\t => $errorMessage \n\n";
      }
    } catch (\Throwable $th) {
      [$errorMessage] = explode('response', $th->getMessage());
      
      echo "\n\n \033[91m \t#### Oops! Resultado República Virtual [$zipCode] #### \n";
      echo "\t => $errorMessage \n\n";
    }    
  }

  /**
   * Displays the result of the request
   *
   * @param string $title
   * @param array $body
   *
   * @return void
   */
  private function showResult(string $title, array $body): void
  {
    echo "\n\n \e[32m \t#### $title #### \n";
    foreach ($body as $key => $value) {
      echo "\t\t ($key)  => $value \n";
    }
    echo "\n";
  }

}