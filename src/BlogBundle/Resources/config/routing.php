<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('blog_homepage', new Route('/', array(
    '_controller' => 'BlogBundle:Default:index',
)));

return $collection;
