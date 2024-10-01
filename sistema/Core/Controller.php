<?php

namespace Sistema\Core;

use sistema\Helpers\Template;

// é a classe padrão de Contoller que vai instanciar o template que irá redirecionar para a rota
class Controller
{
  protected Template $template;
  //contructors são chamados toda vez que a instancia da classe é gerada, ou quando precisamos interagir com a mesma
  public function __construct(string $dir)
  {
    $this->template = new Template($dir);
  }
}
