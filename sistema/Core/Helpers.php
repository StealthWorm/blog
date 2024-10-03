<?php

namespace Sistema\Core;

use Exception;

class Helpers
{
  public static function redirectPathURL(string $url = null): void
  {
    header('HTTP/1.1 302 Found');

    $local = ($url ? self::url($url) : self::url());

    // Check if the constructed URL is valid
    if (filter_var($local, FILTER_VALIDATE_URL) === false) {
      // Fallback to a default URL (like home or an error page)
      $local = self::url(); // Adjust this as needed
    }

    header("Location: " . $local);
    exit();
  }

  /**
   * Validate CPF number
   * @param string $cpf CPF number
   * @return bool
   */
  public static function validateCPF(string $cpf): bool // static permite chamar a função sem instanciar
  {
    $cpf = self::removeNonNumericChars($cpf); // para chamar funções estáticas INTERNAS precisamos do "self::"

    if (strlen($cpf) != 11) {
      throw new Exception("O CPF precisa ter 11 digitos");
    }
    // Check if all digits are the same (e.g., "11111111111"), which is invalid
    if (preg_match('/(\d)\1{10}/', $cpf)) {
      return false;
    }
    // Calculate the first verification digit
    for ($i = 0, $j = 10, $sum = 0; $i < 9; $i++, $j--) {
      $sum += $cpf[$i] * $j;
    }
    $firstCheckDigit = $sum % 11 < 2 ? 0 : 11 - ($sum % 11);
    // Calculate the second verification digit
    for ($i = 0, $j = 11, $sum = 0; $i < 10; $i++, $j--) {
      $sum += $cpf[$i] * $j;
    }
    $secondCheckDigit = $sum % 11 < 2 ? 0 : 11 - ($sum % 11);

    // Check if the calculated check digits match the input CPF's last two digits
    if ($firstCheckDigit != $cpf[9] || $secondCheckDigit != $cpf[10]) {
      throw new Exception('CPF Inválido');
    };

    return $firstCheckDigit == $cpf[9] && $secondCheckDigit == $cpf[10];
  }

  /**
   * Remove any non-numeric characters
   * @param string $cpf
   * @return string
   */
  public static function removeNonNumericChars(string $cpf): string
  {
    return  preg_replace('/[^0-9]/', '', $cpf);
  }

  public static function url(string $url = null): string
  {
    $servidor = filter_input(INPUT_SERVER, 'SERVER_NAME');
    $ambiente = ($servidor === 'localhost' ? URL_DESENVOLVIMENTO : URL_PRODUCAO);

    if (str_starts_with($url, '/')) {
      return $ambiente . $url;
    }

    return $ambiente . '/' . $url;
  }

  public static function localhost(): bool
  {
    // resgata um campo da var global '$_SERVER', util para verificar o tipo de ambiente, por exemplo
    $servidor = filter_input(INPUT_SERVER, 'SERVER_NAME');

    if ($servidor == 'localhost') {
      return True;
    }

    return False;
  }

  public static function saudacao(): string
  {
    $currentHour = date('H');
    $saudacao = '';

    // if ($currentHour >= 0 && $currentHour <= 5) {
    //   $saudacao = 'boa madrugada';
    // } elseif ($currentHour >= 6 && $currentHour < 12) {
    //   $saudacao = 'Bom dia';
    // } elseif ($currentHour >= 12 && $currentHour < 18) {
    //   $saudacao = 'Boa tarde';
    // } else {
    //   $saudacao = 'Boa noite';
    // }

    // switch ($currentHour) {
    //   case $currentHour >= 0 && $currentHour <= 5:
    //     $saudacao = 'Boa madrugada';
    //     break;
    //   case $currentHour >= 6 && $currentHour < 12:
    //     $saudacao = 'Bom dia';
    //     break;
    //   case $currentHour >= 12 && $currentHour < 18:
    //     $saudacao = 'Boa tarde';
    //     break;
    //   default:
    //     $saudacao = 'Boa noite';
    // }

    $saudacao = match (true) {
      $currentHour >= 0 && $currentHour <= 5 => 'Boa madrugada',
      $currentHour >= 6 && $currentHour < 12 => 'Bom dia',
      $currentHour >= 12 && $currentHour < 18 => 'Boa tarde',
      default => 'Boa noite',
    };

    return $saudacao;
  }

  // para criar documentação
  /** 
   * Resume um texto
   * @param string $text Texto a ser resumido
   * @param int $limit Quantidade de caracteres para limitar o resumo
   * @param string $continue (opcional) - o que será usado para aplicar a elipse do texto
   * @return string texto resumido
   */
  public static function sumarize(string $text, int $limit, string $continue = '...'): string
  {
    $textoLimpo = trim(strip_tags($text)); //strip tags remove tags do HTML

    if (mb_strlen($textoLimpo) <= $limit) {
      return $textoLimpo;
    }

    $resumeTexto = mb_substr($textoLimpo, 0, mb_strrpos(mb_substr($textoLimpo, 0, $limit), ''));

    return $resumeTexto . $continue;
  }

  /** 
   * Formata um dado valor
   * @param float $value Valor para ser formatado
   * @param bool $currency Definir se o formato é para números ou valores
   * @return string Valor formatado
   */
  public static function formatValue(float $value = null, bool $currency = false): string
  {
    return $currency
      ? number_format(($value ? $value : 0), 2, ',', '.') // 1.000,00
      : number_format(($value ? $value : 0), 0, '.', '.'); // 1.000

  }

  /**
   * Retorna a diferença de tempo de uma data para a data atual
   * @param string $data (opcional) - data de recebimento
   * @return string Valor da diferença entre as datas
   */
  public static function DateTimeCounter(string $data = null): string
  {
    $timeNow = strtotime(date('Y-m-d H:i:s'));
    $timeReceived = strtotime($data);

    $diffSeconds = $timeNow - $timeReceived;
    $diffMinutes = round($diffSeconds / 60);
    $diffHours = round($diffMinutes / 60);
    $diffDays = round($diffHours / 24);
    $diffWeeks = round($diffDays / 7);
    $diffMonths = round($diffDays / 30.44); // Average days in a month
    $diffYears = round($diffDays / 365.25); // Average days in a year

    if ($diffSeconds <= 60) {
      return 'Agora mesmo';
    } elseif ($diffMinutes <= 60) {
      return ($diffMinutes == 1) ? 'Ha um minuto' : 'Ha ' . $diffMinutes . ' minutos';
    } elseif ($diffHours <= 24) {
      return ($diffHours == 1) ? 'Ha uma hora' : 'Ha ' . $diffHours . ' horas';
    } elseif ($diffDays <= 7) {
      return ($diffDays == 1) ? 'Ha um dia' : 'Ha ' . $diffDays . ' dias';
    } elseif ($diffWeeks <= 4) {
      return ($diffWeeks == 1) ? 'Ha uma semana' : 'Ha ' . $diffWeeks . ' semanas';
    } elseif ($diffMonths <= 12) {
      return ($diffMonths == 1) ? 'Ha um mês' : 'Ha ' . $diffMonths . ' meses';
    } else {
      return ($diffYears == 1) ? 'Ha um ano' : 'Ha ' . $diffYears . ' anos';
    };

    // var_dump($data);
  }

  /**
   * Valida um email
   * @param string $email email para ser validado
   * @return bool retorna verdadeiro/falso para a avalidação do email
   */
  public static function validateEmail(string $email): bool
  {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
  }

  /**
   * Valida uma URL
   * @param string $url URL para ser validada
   * @return bool retorna verdadeiro/falso para a avalidação da URL
   */
  public static function validateURL(string $url): bool
  {
    return filter_var($url, FILTER_VALIDATE_URL);
  }

  public static function dataAtual(): string
  {
    $diaMes = date('d');
    $diaSemana = date('w');
    $mes = number_format(date('n') - 1);
    $ano = date('Y');

    $weekDays = [
      'Domingo',
      'Segunda',
      'Terça',
      'Quarta',
      'Quinta',
      'Sexta',
      'Sábado'
    ];

    $months = [
      'Janeiro',
      'Fevereiro',
      'Março',
      'Abril',
      'Maio',
      'Junho',
      'Julho',
      'Agosto',
      'Setembro',
      'Outubro',
      'Novembro',
      'Dezembro'
    ];

    echo ($diaMes . '<br>');
    echo ($diaSemana . '<br>');
    echo ($mes . '<br>');

    $formattedDate = $weekDays[$diaSemana] . ', Dia ' . $diaMes . ' de ' . $months[$mes] . ' de ' . $ano;

    return $formattedDate;
    // $timeReceived = strtotime($data);
  }

  public static function createSlug(string $string): string
  {
    // Convert the string to UTF-8 encoding
    $string = mb_convert_encoding($string, 'UTF-8', 'auto');
    // Convert the string to lowercase
    $slug = strtolower($string);
    // Replace non-ASCII characters with their closest ASCII equivalents
    $slug = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $slug);
    // Remove special characters
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug); //preg_replace Perform a regular expression search and replace 
    // Replace multiple spaces or hyphens with a single hyphen
    $slug = preg_replace('/[\s-]+/', '-', $slug);
    // Trim hyphens from the beginning and end of the string
    $slug = trim($slug, '-');

    return $slug;
  }
}