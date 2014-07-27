<?php

/*
  * Controller#action => array(<all the routes here>), can put more than one route; eg 'home#index' => array("home","home1") both /home and /home1 will goto same controller and action.
  * routes can also have inbuilt params like "user/{name}" this will create a param called name which can be accessed in controller using $this->params['name'];
*/

  // Routes start here
  $ROUTE_RULES = array(
    'home#index' => array('home'),
    'collections#index' => array('collections'),
    'collections#show' => array('collections/{id}'),
    'blog#index' => array('blog'),
    'blog#show' => array('blog/{id}'),
    'casestudy#index' => array('case_study'),
    'casestudy#show' => array('case_study/{id}'),

    'admin/user#login' => array('user/login'),
    'admin/user#resets' => array('user/resets'),
    'admin/user#resets_new' => array('user/resets/{id}'),
    'admin/user#success' => array('user/success'),
    'admin/user#check' => array('login/check'),
    'admin/user#logout' => array('user/logout'),
    'admin#index' => array('admin'),

    // backend
    'admin/assets#new_asset' => array('admin/assets/new'),
    'admin/assets#delete_asset' => array('admin/assets/delete'),
    'admin#get_relation_data' => array('admin/{type}/get_relation_data'),

    'admin/slide#new_slide' => array('admin/slide/new'),
    'admin/slide#create' => array('admin/slide/create'),
    'admin/slide#edit_slide' => array('admin/slide/edit/{id}'),
    'admin/slide#update' => array('admin/slide/update'),
    'admin/slide#delete_slide' => array('admin/slide/delete'),
    'admin/slide#slide_list' => array('admin/slide/list'),
    'admin/slide#index' => array('admin/slide/{page_no}','admin/slide'),

    'admin/category#index' => array('admin/{type}/category'),
    'admin/category#new_category' => array('admin/{type}/category/new'),
    'admin/category#edit_category' => array('admin/{type}/category/edit'),
    'admin/category#delete_category' => array('admin/{type}/category/delete'),

    'admin/article#new_article' => array('admin/article/new'),
    'admin/article#create' => array('admin/article/create'),
    'admin/article#edit_article' => array('admin/article/edit/{id}'),
    'admin/article#update' => array('admin/article/update'),
    'admin/article#delete_article' => array('admin/article/delete'),
    'admin/article#article_list' => array('admin/article/list'),
    'admin/article#index' => array('admin/article/{page_no}','admin/article'),

    'admin/case#new_case' => array('admin/case/new'),
    'admin/case#create' => array('admin/case/create'),
    'admin/case#edit_case' => array('admin/case/edit/{id}'),
    'admin/case#update' => array('admin/case/update'),
    'admin/case#delete_case' => array('admin/case/delete'),
    'admin/case#case_list' => array('admin/case/list'),
    'admin/case#index' => array('admin/case/{page_no}','admin/case'),

    'admin/product#new_product' => array('admin/product/new'),
    'admin/product#create' => array('admin/product/create'),
    'admin/product#edit_product' => array('admin/product/edit/{id}'),
    'admin/product#update' => array('admin/product/update'),
    'admin/product#delete_product' => array('admin/product/delete'),
    'admin/product#product_list' => array('admin/product/list'),
    'admin/product#index' => array('admin/product/{page_no}','admin/product'),

    'admin/tags#index' => array('admin/tags'),
    'admin/tags#new_tag' => array('admin/tags/new'),
    'admin/tags#edit_tag' => array('admin/tags/edit'),
    'admin/tags#delete_tag' => array('admin/tags/delete'),

    'admin/setting#index' => array('admin/setting'),
    'admin/setting#update' => array('admin/setting/update'),
    'admin/setting#checkpassword' => array('admin/setting/checkpassword'),
    'admin/setting#changepassword' => array('admin/setting/changepassword'),

    'modal#filemanage' => array('modal/filemanage'),
    'modal#delete_confirm' => array('modal/confirm'),
    'modal#delete_category' => array('modal/category'),
    'modal#delete_tag' => array('modal/tag')
  );

?>