<?php

use Pecee\SimpleRouter\SimpleRouter;
use sistema\Core\Helpers;

try {
  SimpleRouter::setDefaultNamespace('sistema\Controllers');

  //SiteController é a classe requisitada e "index" é a função apontada
  SimpleRouter::get(URL_SITE, 'SiteController@index');
  SimpleRouter::get(URL_SITE . 'about', 'SiteController@about');
  SimpleRouter::get(URL_SITE . '404', 'SiteController@error404');

  SimpleRouter::get(URL_SITE . 'post/{id}', 'SiteController@post');

  SimpleRouter::start();
} catch (Pecee\SimpleRouter\Exceptions\NotFoundHttpException $ex) {
  if (Helpers::localhost()) {
    echo $ex;
  } else {
    Helpers::redirectPathURL('404');
  }
}