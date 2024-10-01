<?php

namespace Sistema\Core; // a partir do momento que voce declara um namespace, as instancias da classe precisam de um "use" no caminho do projeto onde a mesma se encontra

/**
 * @author Thierry
 */
class Message
{
  private $text = '';
  private $css = '';

  public function __toString()
  {
    return $this->render();
  }

  // public function __construct(string $text = '', string $css = '')
  /**
   * Método responsável pela renderização
   * @param string $message Texto a ser renderizado
   * @return string mensagem filtrada
   */
  private function filter($message): string
  {
    return filter_var(strip_tags($message), FILTER_SANITIZE_SPECIAL_CHARS);
  }

  public function success(string $message): Message
  {
    $this->text = $message;
    $this->css = 'alert alert-success';
    return $this;
  }

  public function error(string $message): Message
  {
    $this->text = $message;
    $this->css = 'alert alert-danger';
    return $this;
  }

  public function render(): string
  {
    return "<div class='{$this->css}'>{$this->text}</div>";
  }
}