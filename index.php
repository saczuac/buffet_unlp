<?php 
// Initialize Slim (the router/micro framework used)
require_once 'vendor/autoload.php';
 
$app = new \Slim\Slim([
        'debug' => true,
        'templates.path' => 'templates'
    ]);
 
// and define the engine used for the view @see http://twig.sensiolabs.org
$app->view = new \Slim\Views\Twig();
$app->view->setTemplatesDirectory("templates");
 
// Twig configuration
$view = $app->view();
$view->parserOptions = ['debug' => true];
$view->parserExtensions = [new \Slim\Views\TwigExtension()];
 
$app->get('/', function () use ($app) {
    $app->render('index.twig');
});

$app->get('/logedIndex', function () use ($app) {
    $app->render('logedIndex.twig');
});


$app->group('/balanceGastos', function() use($app) {
	$app->get('/', function() use($app){
		echo $app->view->render('balanceGastos.twig');
	});
});


$app->group('/balanceIngresos', function() use($app) {
	$app->get('/', function() use($app){
		echo $app->view->render('balanceIngresos.twig');
	});
});


$app->group('/config', function() use($app) {
	$app->get('/', function() use($app){
		echo $app->view->render('config.twig');
	});
});
 

$app->group('/gastos', function() use($app) {
	$app->get('/', function() use($app){
		echo $app->view->render('gastos.twig');
	});
});
 

$app->group('/menu', function() use($app) {
	$app->get('/', function() use($app){
		echo $app->view->render('menu.twig');
	});
});


$app->group('/pedidos', function() use($app) {
	$app->get('/', function() use($app){
		echo $app->view->render('pedidos.twig');
	});
});


$app->group('/productos', function() use($app) {
	$app->get('/', function() use($app){
		echo $app->view->render('productos.twig');
	});
});


$app->group('/productosFaltantes', function() use($app) {
	$app->get('/', function() use($app){
		echo $app->view->render('productosFaltantes.twig');
	});
});


$app->group('/stockMinimo', function() use($app) {
	$app->get('/', function() use($app){
		echo $app->view->render('stockMinimo.twig');
	});
});


$app->group('/usuarios', function() use($app) {
	$app->get('/', function() use($app){
		echo $app->view->render('usuarios.twig');
	});
});

$app->group('/ventas', function() use($app) {
	$app->get('/', function() use($app){
		echo $app->view->render('ventas.twig');
	});
});


$app->run();
?>