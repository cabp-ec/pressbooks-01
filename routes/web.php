<?php

// Default
$router->get('/', 'IndexController@index');
$router->post('/search', 'SearchController@searchByTag');
