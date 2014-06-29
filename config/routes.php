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
    'admin#get_relation_data' => array('admin/{type}/get_relation_data'),

    'article#new_article' => array('admin/article/new'),
    'article#create' => array('admin/article/create'),
    'article#edit_article' => array('admin/article/edit/{id}'),
    'article#update' => array('admin/article/update'),
    'article#delete_article' => array('admin/article/delete'),
    'article#article_list' => array('admin/article/list'),
    'article#index' => array('admin/article/{page_no}','admin/article'),

    'case#new_case' => array('admin/case/new'),
    'case#create' => array('admin/case/create'),
    'case#edit_case' => array('admin/case/edit/{id}'),
    'case#update' => array('admin/case/update'),
    'case#delete_case' => array('admin/case/delete'),
    'case#case_list' => array('admin/case/list'),
    'case#index' => array('admin/case/{page_no}','admin/case'),

    'product#new_product' => array('admin/product/new'),
    'product#create' => array('admin/product/create'),
    'product#edit_product' => array('admin/product/edit/{id}'),
    'product#update' => array('admin/product/update'),
    'product#delete_product' => array('admin/product/delete'),
    'product#product_list' => array('admin/product/list'),
    'product#index' => array('admin/product/{page_no}','admin/product'),

    'slide#new_slide' => array('admin/slide/new'),
    'slide#create' => array('admin/slide/create'),
    'slide#edit_slide' => array('admin/slide/edit/{id}'),
    'slide#update' => array('admin/slide/update'),
    'slide#delete_slide' => array('admin/slide/delete'),
    'slide#slide_list' => array('admin/slide/list'),
    'slide#index' => array('admin/slide/{page_no}','admin/slide'),

    'category#index' => array('admin/{type}/category'),
    'category#new_category' => array('admin/{type}/category/new'),
    'category#edit_category' => array('admin/{type}/category/edit'),
    'category#delete_category' => array('admin/{type}/category/delete'),

    'tags#index' => array('admin/tags'),
    'tags#new_tag' => array('admin/tags/new'),
    'tags#edit_tag' => array('admin/tags/edit'),
    'tags#delete_tag' => array('admin/tags/delete'),

    'setting#index' => array('admin/setting'),
    'setting#update' => array('admin/setting/update'),

    'modal#filemanage' => array('modal/filemanage'),
    'modal#delete_confirm' => array('modal/confirm'),
    'modal#delete_category' => array('modal/category'),
    'modal#delete_tag' => array('modal/tag')
  );

?>