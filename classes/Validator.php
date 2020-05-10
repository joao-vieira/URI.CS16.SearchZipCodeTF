<?php

namespace PHPTF;

class Validator
{

  /**
   * Read a input from user
   *
   * @param integer $check
   * @param string $label
   * @param string $errorMessage
   *
   * @return int
   */
  public function readFromUser(int $check = 1, string $label, string $errorMessage): string
  {
    $isValid = false;
    while (!$isValid) {
      echo "\e[0m";
      $input = readline($label);

      switch ($check) {
        case 1:
          $isValid = $this->validateZipCode($input);
        break;

        case 2:
          $isValid = $this->validateOption($input);
        break;
        
        case 3:          
          $isValid = true; //ignore validation
        break;

        default:
          echo 'Revisar switch =/ \n';
          $isValid = false;
        break;
      }
      

      if (!$isValid) {
        echo "$errorMessage \n\n";
      } else {
        return $input;
      }
    }
  }

  /**
   * Check if input is a valid zip code
   *
   * @param string $zipCode
   *
   * @return boolean
   */
  public function validateZipCode(string $zipCode): bool
  {
    $formattedZipCode = preg_replace("/[^0-9]/", "", $zipCode);

    if (preg_match('/^[0-9]{8}?$/', $formattedZipCode)) {
      return true;
    }
    
    return false;
  }

  /**
   * Check if input is a valid menu option
   *
   * @param string $option
   * 
   * @return boolean
   */
  public function validateOption(string $option): bool
  {
    if ($option >= 0 && $option <= 4) {
      return true;
    }
    
    return false;
  }

}
