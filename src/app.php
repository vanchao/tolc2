<?php
use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\Response;
function is_leap_year($year = null) {
    if (null === $year) {
        $year = date('Y');
    }

    return 0 === $year % 400 || (0 === $year % 4 && 0 !== $year % 100);
}
$routes = new Routing\RouteCollection();
// $routes->add('hello', new Routing\Route('/hello/{name}', array('name' => 'World')));
// $routes->add('bye', new Routing\Route('/bye'));
$routes->add('leap_year', new Routing\Route('/is_leap_year/{year}', array(
    'year' => null,
    '_controller' => 'Calendar\Controller\LeapYearController::indexAction',
)));
return $routes;
