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
    'admin#get_relation_data' => array('admin/{type}/get_relation_data'),
    'category#index' => array('admin/{type}/category'),
    'category#new_category' => array('admin/{type}/category/new'),
    'category#edit_category' => array('admin/{type}/category/edit'),
    'category#delete_category' => array('admin/{type}/category/delete'),
    'article#index' => array('admin/article/{page_no}','admin/article'),
    'article#edit_article' => array('admin/article/edit/{id}'),
    'product#new_product' => array('admin/product/new'),
    'product#index' => array('admin/product/{page_no}','admin/product'),
    'product#edit_product' => array('admin/product/edit/{id}'),
    'case#new_case' => array('admin/case/new'),
    'case#index' => array('admin/case/{page_no}','admin/case'),
    'case#edit_case' => array('admin/case/edit/{id}'),
    'tags#index' => array('admin/tags'),
    'tags#new_tag' => array('admin/tags/new'),
    'tags#edit_tag' => array('admin/tags/edit'),
    'tags#delete_tag' => array('admin/tags/delete'),
    'modal#filemanage' => array('modal/filemanage'),
    'modal#delete_confirm' => array('modal/confirm'),
    'modal#delete_category' => array('modal/category'),
    'modal#delete_tag' => array('modal/tag')
  );

?>