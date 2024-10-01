<?php

use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::setDefaultNamespace('sistema\Controllers');

//SiteController é a classe requisitada e "index" é a função apontada
SimpleRouter::get(URL_SITE, 'SiteController@index');
SimpleRouter::get(URL_SITE . 'about', 'SiteController@about');

SimpleRouter::start();
