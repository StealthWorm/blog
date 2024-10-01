<?php

namespace sistema\Controllers;

use sistema\Core\Controller;

class SiteController extends Controller
{
  public function __construct()
  {
    parent::__construct('resources/site/views');
  }

  public function index(): void
  {
    echo $this->template->render('index.html', [
      'title' => 'Home',
      'subtitle' => 'Site subtitle'
    ]);
  }

  public function about(): void
  {
    echo $this->template->render('about.html', [
      'title' => 'About',
      'subtitle' => 'Sobre subtitle',
      'email' => 'email@test.com',
      'phone' => '123456789',
      'country' => 'BR',
      'city' => 'Ponta Grossa'
    ]);
  }
}
