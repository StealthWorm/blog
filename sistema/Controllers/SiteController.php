<?php

namespace sistema\Controllers;

use sistema\Core\Controller;
use sistema\Core\Helpers;
use sistema\Models\Category;
use sistema\Models\Post;

class SiteController extends Controller
{
  public function __construct()
  {
    parent::__construct('resources/site/views');
  }

  public function index(): void
  {
    $posts = (new Post())->findAll();

    echo $this->template->render('index.html', [
      'posts' => $posts,
      'categories' => $this->categories()
    ]);
  }

  public function post(int $id): void
  {
    $post = (new Post())->findById($id);

    if (!$post) {
      Helpers::redirectPathURL('404');
    }

    echo $this->template->render('post-by-id.html', [
      'post' => $post,
      'categories' => $this->categories()
    ]);
  }

  public function category(int $id): void
  {
    // echo $id;
    $posts = (new Category())->findPosts($id);

    if (!$posts) {
      Helpers::redirectPathURL('404');
    }

    echo $this->template->render('categories.html', [
      'posts' => $posts,
      'categories' => $this->categories()
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

  public function categories()
  {
    return (new Category())->findAll();
  }

  public function error404(): void
  {
    echo $this->template->render('404.html', [
      'title' => 'Página não encontrada',
    ]);
  }
}
