<?php

namespace sistema\Helpers;

use Twig\Lexer;
use sistema\Core\Helpers;

// template criado para instanciar as views a partir dos controllers, indicando qual view a rota irá apontar
class Template
{
  private \Twig\Environment $twig;

  public function __construct(string $dir)
  {
    $loader = new \Twig\Loader\FilesystemLoader($dir);
    $this->twig = new \Twig\Environment($loader);

    $lexer = new Lexer($this->twig, array(
      $this->helpers()
    ));

    $this->twig->setLexer($lexer);
  }

  public function render(string $template, array $data = []): string
  {
    return $this->twig->render($template, $data);
  }

  private function helpers(): void
  {
    array(
      $this->twig->addFunction(
        new \Twig\TwigFunction('url', function (string $url = null) {
          return Helpers::url($url);
        })
      ),

      $this->twig->addFunction(
        new \Twig\TwigFunction('saudacao', function () {
          return Helpers::saudacao();
        })
      ),

      $this->twig->addFunction(
        new \Twig\TwigFunction('resumirText', function (string $text, int $limite) {
          return Helpers::sumarize($text, $limite);
        })
      ),
    );
  }
}
