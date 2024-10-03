<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<!-- composer ajuda a orquestrar dependencias, útil para evitar importações repetitivas -->
<!-- "composer init" para gerar o arquivo -->
<!-- "composer update" para atualziar o arquivo .json em casa de alterações nele  -->
<!-- "composer require" para adicionar dependencias -->
<!-- "composer remove" para remover dependencias -->
<?php

require 'vendor/autoload.php';
// require 'rotas.php';
use sistema\Core\Connection;
use sistema\Models\Post;

// $pdo = Connection::getInstance();

// $posts = (new Post())->findAll();
// foreach ($posts as $post) {
//   echo $post->title . '<br>';
// }

$postIndex = (new Post())->findById(1);
foreach ($postIndex as $post) {
  echo $post->title . '<br>';
}

// require_once 'sistema/config.php';
// include_once 'sistema/core/Helpers.php';
// include 'sistema/Core/Message.php';

// $meses = []; // ou  $meses = array();
// $meses[1] = 'Janeiro';
// $meses[2] = 'Fevereiro';
// $meses[3] = 'Março';
// $meses[4] = 'Abril';
// $meses[5] = 'Maio';

// $meses = [
//   1 => 'Janeiro',
//   2 => 'Fevereiro',
//   'Março',
//   4 => 'Abril'
// ];

// foreach ($meses as $mes) {
//   echo $mes . '<br>';
// }

// maneira mais elegante de tratar chaves e valores
// foreach ($meses as $chave => $value) {
//   echo $chave . ' - ' . $value . '<br>';
// }

// echo $_SERVER['SERVER_PORT'];
// echo '<br>';
// var_dump($_SERVER);

// echo saudacao() . '<br> Hoje é ' . dataAtual();
// echo createSlug('Olá Mundo! Isto é um Teste. */@');

// echo $msg
//   ->success('mensagem')
//   ->render(); //encadeamento de métodos

// echo (new Message())->error('mensagem de erro')->render(); // equivale a // $msg = new Message();
// echo (new Message())->success('mensagem de erro'); // método _toString da classe permite que ela decida como reagirá quando for tratada como uma string, nesse caso ja executamos o render() 

// $helper = new Helpers();
// echo $helper->validateCPF('09624196990');
// $cpf = "123.456.786-09";
// $document =  new \Bissolli\ValidadorCpfCnpj\CPF($cpf);

// métodos "static" são uteis para cálculos diretos, que não variam, apenas precisando de inputs
// a sintaxe com "::" anbaixo, permite acessar os métodos "static" diretamente da classe, mas APENAS eles
// try {
//   Helpers::validateCPF($cpf);
// } catch (Exception $e) {
//   echo $e->getMessage();
// }

// echo (\Sistema\Core\Helpers::saudacao());