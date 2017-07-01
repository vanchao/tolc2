<?php
require_once __DIR__ . '/vendor/autoload.php';
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
date_default_timezone_set('PRC');
$request = Request::createFromGlobals();
$input = $request->get('name', 'World');
$response = new Response(sprintf('Hello %s', htmlspecialchars( $input, ENT_QUOTES, 'UTF-8' )));
$response->send();
