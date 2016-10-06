<?php
// Initialize Slim (the router/micro framework used)
require_once 'vendor/autoload.php';
require_once 'Model/Resource/UsuarioResource.php';
use Model\Entity\Usuario;
use Model\Resource\UsuarioResource;
use Controller\UsuarioController;
use Model\Resource\ConfiguracionResource;

session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires');
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
	$app->get('/', function() use($app){
      $app->applyHook('must.be.logueado');
		echo $app->view->render('balanceGastos.twig');
	});
});


$app->group('/balanceIngresos', function() use($app) {
	$app->get('/', function() use($app){
      $app->applyHook('must.be.logueado');
		echo $app->view->render('balanceIngresos.twig');
	});
});


$app->group('/config', function() use($app) {
  $app->get('/', '\Controller\ConfigController:showConfig')->setParams(array($app));
  $app->post('/setPaginacion', '\Controller\ConfigController:setPaginacion')->setParams(
           array($app, $app->request->post('paginacionInt')));
  $app->post('/setDescripcion', '\Controller\ConfigController:setDescripcion')->setParams(
           array($app, $app->request->post('titleInfo'),$app->request->post('descInfo')));
  $app->post('/setMenu', '\Controller\ConfigController:setMenu')->setParams(
           array($app, $app->request->post('menuTitulo'),$app->request->post('menuInfo')));
});



$app->group('/gastos', function() use($app) {
	$app->get('/', function() use($app){
    $app->applyHook('must.be.logueado');
		echo $app->view->render('gastos.twig');
	});
});


$app->group('/menu', function() use($app) {
	$app->get('/', function() use($app){
    $app->applyHook('must.be.logueado');
		echo $app->view->render('menu.twig');
	});
});


$app->group('/pedidos', function() use($app) {
	$app->get('/', function() use($app){
    $app->applyHook('must.be.logueado');
		echo $app->view->render('pedidos.twig');
	});
});


$app->group('/productos', function() use ($app, $userResource) {
    // Listar
    $app->get('/', '\Controller\ProductoController:listProductos')->setParams(array($app));
    // Alta
    $app->post('/', '\Controller\ProductoController:newProducto')->setParams(
            array($app, $app->request->post('nombre'),
            $app->request->post('marca'),
            $app->request->post('stock'),
            $app->request->post('stock_minimo'),
            $app->request->post('proovedor'),
            $app->request->post('precio_venta_unitario'),
            $app->request->post('categoria_id'),
            $app->request->post('descripcion'))
    );
   // Baja
    $app->get('/delete', '\Controller\ProductoController:deleteProducto')->setParams(array($app, $app->request->get('id')));
   // Show
   $app->get('/show', '\Controller\ProductoController:showProducto')->setParams(array($app, $app->request->get('id')));
   // Editar
   $app->post('/show', '\Controller\ProductoController:editProducto')->setParams(
        array($app, $app->request->post('nombre'),
            $app->request->post('marca'),
            $app->request->post('stock'),
            $app->request->post('stock_minimo'),
            $app->request->post('proovedor'),
            $app->request->post('precio_venta_unitario'),
            $app->request->post('categoria_id'),
            $app->request->post('descripcion'),
            $app->request->post('prodid'))
   );
});

$app->group('/productosFaltantes', function() use($app) {
  $app->get('/', '\Controller\ListadoController:indexActionFaltantes')->setParams(array($app));
  $app->get('/page', '\Controller\ListadoController:indexActionFaltantes')->setParams(array($app, $app->request->get('id')));
});


$app->group('/stockMinimo', function() use($app) {
  $app->get('/', '\Controller\ListadoController:indexActionStockMin')->setParams(array($app));
  $app->get('/page', '\Controller\ListadoController:indexActionStockMin')->setParams(array($app, $app->request->get('id')));
});

$app->group('/usuarios', function() use ($app, $userResource) {
    // Listar
    $app->get('/', '\Controller\UsuarioController:listUsuarios')->setParams(array($app));
    // Alta
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
   // Editar
   $app->post('/show', '\Controller\UsuarioController:editUsuario')->setParams(
           array($app, $app->request->post('user'),
           $app->request->post('pass'),
           $app->request->post('nombre'),
           $app->request->post('apellido'),
           $app->request->post('documento'),
           $app->request->post('telefono'),
           $app->request->post('rol_id'),
           $app->request->post('email'),
           $app->request->post('ubicacion_id'),
           $app->request->post('userid'))
   );
});

$app->group('/ventas', function() use($app) {
	$app->get('/', function() use($app){
    $app->applyHook('must.be.logueado');
		echo $app->view->render('ventas.twig');
	});
});


$app->run();
?>
