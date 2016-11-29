<?php
// Initialize Slim (the router/micro framework used)
require_once 'vendor/autoload.php';
require_once 'Model/Resource/UsuarioResource.php';
require_once 'mpdf/mpdf.php';
use Model\Entity\Usuario;
use Model\Resource\UsuarioResource;
use Controller\UsuarioController;
use Controller\BotController;
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
$view->getEnvironment()->addGlobal('mail', ConfiguracionResource::getInstance()->get('mail'));


// <------ END SLIM CONFIGURATION---------->

$userResource = UsuarioResource::getInstance();
$botController = BotController::getInstance();

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
      $_SESSION['csrf_token'] = rand(0,999999);
      $_SESSION['token_received'] = 0;
      $_SESSION['habilitado'] = $user->getHabilitado();
      if ($user->getRol_Id() == 2) { $app->applyHook('must.be.habilitado'); };
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
        $app->request->post('ubicacion_id'),0)
);

$app->group('/balanceGastos', function() use($app) {
	$app->post('/','\Controller\BalanceController:ganancias')->setParams(
        array($app,$app->request->post('fechaDesde'),$app->request->post('fechaHasta')));
  $app->get('/exportar/','\Controller\BalanceController:exportGanancias')->setParams(array($app,$app->request->get('desde'),$app->request->get('hasta')));
});


$app->group('/balanceIngresos', function() use($app) {
  $app->post('/','\Controller\BalanceController:ventas')->setParams(
        array($app,$app->request->post('fechaDesde'),$app->request->post('fechaHasta')));
    $app->get('/exportar/','\Controller\BalanceController:exportVentas')->setParams(
        array($app,$app->request->get('desde'),$app->request->get('hasta')));
  });


$app->group('/config', function() use($app) {
  $app->get('/', '\Controller\ConfigController:showConfig')->setParams(array($app,$_SESSION['csrf_token']));
  $app->post('/setPaginacion', '\Controller\ConfigController:setPaginacion')->setParams(
           array($app, $app->request->post('paginacionInt'),$app->request->post('token')));
  $app->post('/setDescripcion', '\Controller\ConfigController:setDescripcion')->setParams(
           array($app, $app->request->post('titleInfo'),$app->request->post('descInfo'),$app->request->post('mail'),$app->request->post('token')));
  $app->post('/setMenu', '\Controller\ConfigController:setMenu')->setParams(
           array($app, $app->request->post('menuTitulo'),$app->request->post('menuInfo'),$app->request->post('token')));
  $app->post('/setHabilitado', '\Controller\ConfigController:setFormHabilitado')->setParams(
           array($app, $app->request->post('habilitado'),$app->request->post('msg'),$app->request->post('token')));
});



$app->group('/gastos', function() use($app) {
	$app->get('/', function() use($app){
    $app->applyHook('must.be.logueado');
		echo $app->view->render('gastos.twig');
	});
});

$app->group('/menu', function() use($app) {
  $app->get('/', '\Controller\MenuController:index')->setParams(array($app,$_SESSION['csrf_token']));
    $app->get('/delete', '\Controller\MenuController:deleteMenu')->setParams(array($app, $app->request->get('fecha')));
  $app->get('/edit', '\Controller\MenuController:showEdit')->setParams(array($app ,$app->request()->get('id'),$_SESSION['csrf_token']));
  $app->post('/edit', '\Controller\MenuController:edit')->setParams(
    array($app,$app->request->post('paramArray'),$app->request->post('editFecha'),$app->request->post('habilitado'),$app->request->post('token')));
  $app->post('/new', '\Controller\MenuController:nuevo')->setParams(
    array($app,$app->request->post('paramArray'),$app->request->post('newFecha'),$app->request->post('habilitado'),$app->request->post('token')));
    $app->get('/show', '\Controller\MenuController:showFecha')->setParams(array($app, $app->request->get('fecha')));
});

$app->group('/pedidos', function() use($app) {
  $app->get('/', '\Controller\PedidoController:index')->setParams(array($app,$_SESSION['csrf_token']));
  $app->post('/search', '\Controller\PedidoController:search')->setParams(array($app, $app->request->post('desde'), $app->request->post('hasta')));
  $app->post('/new', '\Controller\PedidoController:nuevo')->setParams(
    array($app,$app->request->post('paramArray'), null, $app->request->post('observacion'),$app->request->post('token')));
  $app->get('/show', '\Controller\PedidoController:show')->setParams(array($app, $app->request->get('id')));
  $app->post('/cancelar', '\Controller\PedidoController:cancelar')->setParams(array($app, $app->request->post('idPedido'),$app->request->post('comentario')));
  $app->Post('/cancelarOnline/', '\Controller\PedidoController:cancelarOnline')->setParams(array($app, $app->request->post('idPedidoOnline'),$app->request->post('comentario')));
  $app->get('/aceptar', '\Controller\PedidoController:aceptar')->setParams(array($app, $app->request->get('id')));
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
  $app->get('/goprev', '\Controller\ListadoController:faltantesPrev')->setParams(array($app));
  $app->get('/gonext', '\Controller\ListadoController:faltantesNext')->setParams(array($app));
});


$app->group('/stockMinimo', function() use($app) {
  $app->get('/', '\Controller\ListadoController:indexActionStockMin')->setParams(array($app));
  $app->get('/page', '\Controller\ListadoController:indexActionStockMin')->setParams(array($app, $app->request->get('id')));
  $app->get('/goprev', '\Controller\ListadoController:stockMinPrev')->setParams(array($app));
  $app->get('/gonext', '\Controller\ListadoController:stockMinNext')->setParams(array($app));
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
            $app->request->post('ubicacion_id'),
            $app->request->post('habilitado'))
    );
   // Baja
    $app->get('/delete', '\Controller\UsuarioController:deleteUsuario')->setParams(array($app, $app->request->get('id')));
   // Show
   $app->get('/show', '\Controller\UsuarioController:showUsuario')->setParams(array($app, $app->request->get('id')));
   // Editar
   $app->post('/show', '\Controller\UsuarioController:editUsuario')->setParams(
           array($app, $app->request->post('user'),
           $app->request->post('nombre'),
           $app->request->post('apellido'),
           $app->request->post('documento'),
           $app->request->post('telefono'),
           $app->request->post('rol_id'),
           $app->request->post('email'),
           $app->request->post('ubicacion_id'),
           $app->request->post('userid'),
           $app->request->post('habilitado'))
   );
});

$app->group('/ventas', function() use($app) {
  $app->get('/', '\Controller\VentasController:index')->setParams(array($app));
  $app->post('/new', '\Controller\VentasController:nuevo')->setParams(
    array($app,$app->request->post('newSellProductName'),
      $app->request->post('newSellQuantity'),
      $app->request->post('newSellPrice'),
      "1",
      $app->request->post('newSellDate'),
      $app->request->post('newSellDesc')));
  $app->get('/edit(/(:id)(/))', '\Controller\VentasController:edit')->setParams(array($app),$app->request()->get('id'));
  $app->post('/edit', '\Controller\VentasController:editar')->setParams(
     array($app,$app->request->post('id'),
      $app->request->post('newSellProductName'),
      $app->request->post('newSellQuantity'),
      $app->request->post('newSellPrice'),
      "1",
      $app->request->post('newSellDate'),
      $app->request->post('newSellDesc')));
    $app->get('/delete(/(:id)(/))', '\Controller\VentasController:delete')->setParams(array($app),$app->request()->get('id'));
});

$app->group('/compras', function() use($app) {
  $app->get('/', '\Controller\CompraController:index')->setParams(array($app));
  $app->post('/new', '\Controller\CompraController:nuevo')->setParams(
    array($app,$app->request->post('newProveedor'),
      $app->request->post('newCUIL'),
      $app->request->post('paramArray')));
  $app->get('/show(/(:id)(/))', '\Controller\CompraController:show')->setParams(array($app),$app->request()->get('id'));
  $app->get('/edit(/(:id)(/))', '\Controller\CompraController:edit')->setParams(array($app),$app->request()->get('id'));
  $app->post('/edit', '\Controller\CompraController:editar')->setParams(
    array($app,$app->request->post('paramID'),
      $app->request->post('newProveedor'),
      $app->request->post('newCUIL'),
      $app->request->post('paramArray')));
  $app->get('/delete(/(:id)(/))', '\Controller\CompraController:delete')->setParams(array($app),$app->request()->get('id'));
  $app->post('/factura', '\Controller\CompraController:addFactura')->setParams(array($app,
    $app->request->post('idCompra')));
  $app->get('/factura(/(:id)(/))', '\Controller\CompraController:factura')->setParams(array($app),$app->request()->get('id'));
});

$app->get('/bot', function() use ($app, $botController) {
    if ($botController->notificar()) {
      $app->flash('success', 'Se han realizado las notificaciones correctamente');
    } else {
      $app->flash('error', 'No se pudo notificar a los subscriptos o no hay menu habilitado para hoy');
    }
    $app->redirect('/menu');
});

$app->run();
?>
