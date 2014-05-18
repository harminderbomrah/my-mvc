<?php

/*
  * Controller#action => array(<all the routes here>), can put more than one route; eg 'home#index' => array("home","home1") both /home and /home1 will goto same controller and action.
  * routes can also have inbuilt params like "user/{name}" this will create a param called name which can be accessed in controller using $this->params['name'];
*/

  // Routes start here
  $ROUTE_RULES = array(
    'home#index' => array('home'),
    'user#login' => array('user/login'),
    'user#resets' => array('user/resets'),
    'user#resets_new' => array('user/resets/{id}'),
    'user#success' => array('user/success'),
    'user#check' => array('login/check'),
    'user#logout' => array('user/logout'),
    'admin#index' => array('admin'),

    // backend
    'article#new_article' => array('admin/article/new'),
    'article#category' => array('admin/article/category'),
    'article#index' => array('admin/article/{page_no}','admin/article'),
    'article#edit_article' => array('admin/article/edit/{id}'),
    'product#new_product' => array('admin/product/new'),
    'product#category' => array('admin/product/category'),
    'product#index' => array('admin/product/{page_no}','admin/product'),
    'product#edit_product' => array('admin/product/edit/{id}'),
    'case#new_case' => array('admin/case/new'),
    'case#category' => array('admin/case/category'),
    'case#index' => array('admin/case/{page_no}','admin/case'),
    'case#edit_case' => array('admin/case/edit/{id}'),
    'tags#index' => array('admin/tags')
  );

?>