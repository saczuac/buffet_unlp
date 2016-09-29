<?php
// Initialize Slim (the router/micro framework used)
require_once 'vendor/autoload.php';
require_once 'Model/Resource/UsuarioResource.php';
use Model\Entity\Usuario;
use Model\Resource\UsuarioResource;
use Controller\UsuarioController;
use Model\Resource\ConfiguracionResource;

session_start();
// <------ SLIM CONFIGURATION ---------->

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
$view->getEnvironment()->addGlobal('session', $_SESSION);
$view->getEnvironment()->addGlobal('server', $_SERVER);
// <------ END SLIM CONFIGURATION---------->

$userResource = UsuarioResource::getInstance();

require_once 'permissions.php';

$app->get('/', '\Controller\HomeController:showHome')->setParams(array($app));

$app->get('/logout', function() use ($app, $userResource) {
    session_destroy();
    $app->view->getEnvironment()->addGlobal('session',$_SESSION);
    $app->flash('success', 'Sesión cerrada correctamente');
    $app->redirect('/');
});

// login...
$app->post('/', function() use ($app, $userResource) {
	  $name = $app->request->post('username');
    $pass = $app->request->post('pass');
    $user = $userResource->login($name, $pass);
    if ($user) {
    	$_SESSION['id']=$user->getId();
    	$_SESSION['user']=$user->getUsuario();
    	$_SESSION['rol']=$user->getRol_Id();
    	$app->flash('success', 'Usuario logueado correctamente como '. $user->getUsuario());
    	$app->redirect('/');
    } else {
      $app->flash('error', 'Usuario o contraseña incorrecto');
      $app->redirect('/');
	}
});

// register

$app->post('/registrar', '\Controller\UsuarioController:registrarUsuario')->setParams(
        array($app, $app->request->post('user'),
        $app->request->post('pass'),
        $app->request->post('nombre'),
        $app->request->post('apellido'),
        $app->request->post('documento'),
        $app->request->post('telefono'),
        2,
        $app->request->post('email'),
        $app->request->post('ubicacion_id'))
);

$app->group('/balanceGastos', function() use($app) {
  $app->applyHook('must.be.logueado');
	$app->get('/', function() use($app){
		echo $app->view->render('balanceGastos.twig');
	});
});


$app->group('/balanceIngresos', function() use($app) {
  $app->applyHook('must.be.logueado');
	$app->get('/', function() use($app){
		echo $app->view->render('balanceIngresos.twig');
	});
});


$app->group('/config', function() use($app) {
  $app->applyHook('must.be.logueado');
  $app->get('/', '\Controller\ConfigController:showConfig')->setParams(array($app));

  $app->post('/setPaginacion', '\Controller\ConfigController:setPaginacion')->setParams(
           array($app, $app->request->post('paginacionInt')));
  $app->post('/setDescripcion', '\Controller\ConfigController:setDescripcion')->setParams(
           array($app, $app->request->post('titleInfo'),$app->request->post('descInfo')));
  $app->post('/setMenu', '\Controller\ConfigController:setMenu')->setParams(
           array($app, $app->request->post('menuTitulo'),$app->request->post('menuInfo')));
});



$app->group('/gastos', function() use($app) {
  $app->applyHook('must.be.logueado');
	$app->get('/', function() use($app){
		echo $app->view->render('gastos.twig');
	});
});


$app->group('/menu', function() use($app) {
  $app->applyHook('must.be.logueado');
	$app->get('/', function() use($app){
		echo $app->view->render('menu.twig');
	});
});


$app->group('/pedidos', function() use($app) {
  $app->applyHook('must.be.logueado');
	$app->get('/', function() use($app){
		echo $app->view->render('pedidos.twig');
	});
});


$app->group('/productos', function() use($app) {
  $app->applyHook('must.be.logueado');
	$app->get('/', function() use($app){
		echo $app->view->render('productos.twig');
	});
});


$app->group('/productosFaltantes', function() use($app) {
  $app->applyHook('must.be.logueado');
	$app->get('/', function() use($app){
		echo $app->view->render('productosFaltantes.twig');
	});
});


$app->group('/stockMinimo', function() use($app) {
  $app->applyHook('must.be.logueado');
	$app->get('/', function() use($app){
		echo $app->view->render('stockMinimo.twig');
	});
});

$app->group('/usuarios', function() use ($app, $userResource) {
    $app->applyHook('must.be.logueado');
    // Listar
    $app->get('/', '\Controller\UsuarioController:listUsuarios')->setParams(array($app));
    // Alta
    echo '<script language="javascript">';
    $message = $app->request->post('ubicacion_id');
    echo 'alert(' . $message . ')';
    echo '</script>';
    $app->post('/', '\Controller\UsuarioController:newUsuario')->setParams(
            array($app, $app->request->post('user'),
            $app->request->post('pass'),
            $app->request->post('nombre'),
            $app->request->post('apellido'),
            $app->request->post('documento'),
            $app->request->post('telefono'),
            $app->request->post('rol_id'),
            $app->request->post('email'),
            $app->request->post('ubicacion_id'))
    );
   // Baja
    $app->get('/delete', '\Controller\UsuarioController:deleteUsuario')->setParams(array($app, $app->request->get('id')));
   // Show
   $app->get('/show', '\Controller\UsuarioController:showUsuario')->setParams(array($app, $app->request->get('id')));

});

$app->group('/ventas', function() use($app) {
  $app->applyHook('must.be.logueado');
	$app->get('/', function() use($app){
		echo $app->view->render('ventas.twig');
	});
});


$app->run();
?>
