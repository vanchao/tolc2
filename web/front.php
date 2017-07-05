<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;
use Symfony\Component\EventDispatcher\EventDispatcher;
date_default_timezone_set('PRC');
function render_template(Request $request)
{
    extract($request->attributes->all(), EXTR_SKIP);
    ob_start();
    include sprintf(__DIR__.'/../src/pages/%s.php', $_route);

    return new Response(ob_get_clean());
}
$request = Request::createFromGlobals();
$routes  = include __DIR__ . '/../src/app.php';
$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);
$controllerResolver = new HttpKernel\Controller\ControllerResolver();
$argumentResolver = new HttpKernel\Controller\ArgumentResolver();
$dispatcher = new EventDispatcher();
$dispatcher->addListener('response', function (Clot\ResponseEvent $event) {
    $response = $event->getResponse();

    if ($response->isRedirection()
        || ($response->headers->has('Content-Type') && false === strpos($response->headers->get('Content-Type'), 'html'))
        || 'html' !== $event->getRequest()->getRequestFormat()
    ) {
        return;
    }

    $response->setContent($response->getContent().'GA CODE');
}, -255);
$dispatcher->addSubscriber(new Clot\ContentLengthListener());
$dispatcher->addSubscriber(new Clot\GoogleListener());
$framework = new Clot\Framework($matcher, $controllerResolver, $argumentResolver);
$response = $framework->handle($request);
$response->send();
