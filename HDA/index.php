<?php

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

require 'vendor/autoload.php';

use App\Entity\User;
$userResource = new \App\Resource\UserResource();
$alumnoResource = new \App\Resource\AlumnoResource();
$cuotasResource = new \App\Resource\CuotasResource();
$app = new \Slim\Slim(array(
	'view' => new \Slim\Views\Twig()
));

$view = $app->view();
$twig =  new Twig_Environment();
$view->parserOptions = array(
	'debug' => true
);
$twig->addGlobals = array('session' => 'seba' );
$app->get('/', function () use ($app) {
    echo $app->view->render("home.twig");
});

$app->get('/users(/(:id)(/))', function($id = null) use ($userResource) {
    print_r($userResource->get($id));
});

// Ruta para alumnos#index
$app->get('/alumnos', function() use($app, $alumnoResource){
	echo $app->view->render(
		"alumnos/index.twig", 
		array('alumnos' => ($alumnoResource->get()))
	);
});

// Ruta para alumnos#show
$app->get('/alumnos(/(:id)(/))', function($id) use ($app, $alumnoResource) {
    echo $app->view->render(
		"alumnos/show.twig", 
		array('alumno' => ($alumnoResource->get($id)))
	);
});

// Ruta para Cuotas#index
$app->get('/cuotas', function() use($app, $cuotasResource){
	echo $app->view->render(
		"cuotas/index.twig", 
		array('cuotas' => ($cuotasResource->get()))
	);
});

$app->get('/cuotas(/show((:id)(/)))', function($id) use ($app, $cuotasResource) {
    echo $app->view->render(
		"cuotas/show.twig", 
		array('cuota' => ($cuotasResource->get($id)))
	);
});

$app->get('/cuotas(/editar(/(:id)(/)))', function($id) use ($app, $cuotasResource) {
    echo $app->view->render(
		"cuotas/edit.twig", 
		array('cuota' => ($cuotasResource->get($id)))
	);
});

$app->post('/cuotas(/editar(/(:id)(/)))', function($id) use ($app, $cuotasResource) {
    $cuotasResource->edit($id,
			$app->request->post('numero'),
					$app->request->post('monto'),
					$app->request->post('tipo'),
					$app->request->post('comco'));
			$app->redirect('/cuotas');
		
});


$app->get('/cuotas(/insert)', function() use($app, $cuotasResource){
	echo $app->view->render(
		"cuotas/insert.twig", 
		array()
	);
});

$app->post('/cuotas(/insert)', function() use($app, $cuotasResource){
	$cuotasResource->insert($app->request->post('anio'),
					$app->request->post('mes'),
					$app->request->post('numero'),
					$app->request->post('monto'),
					$app->request->post('tipo'),
					$app->request->post('comco'));
	$app->redirect('/cuotas');
});


$app->get('/cuotas(/eliminar(/(:id)(/)))', function($id) use ($app, $cuotasResource) {
    $cuotasResource->delete($id);
    		$app->redirect('/cuotas');
			/*echo $app->view->render(
		"cuotas/index.twig", 
		array('cuotas' => ($cuotasResource->get())));*/
		
});

$app->post('/login', function() use ($app, $userResource) {
		/*$usr=$app->request->post('name');
		$pass=$app->request->post('Password');
		if ($userResource->login($usr,$pass);
	    $app['session']->set('usuario', $usr);
        $a = $request->headers->get('referer');
        return $app->redirect($a);
      }else{
        return $app['twig']->render('login.twig', array( 'msj' => 'Usuario o Password incorrecta' ));    
      }
  }else{
    return $app['twig']->render('login.twig', array( 'msj' => 'Usuario o Password incorrecta' ));  
  }*/
 return  $userResource->login('seba',2);
});

$app->get('/usuarios', function() use ($app, $userResource) {
   echo $app->view->render(
		"usuarios/index.twig", 
		array('users' => ($userResource->get()))
	);
});
		
$app->get('/usuarios(/editar(/(:id)(/)))', function($id) use ($app, $userResource) {
    echo $app->view->render(
		"usuarios/edit.twig", 
		array('user' => ($userResource->get($id)))
	);
});

$app->post('/usuarios(/editar(/(:id)(/)))', function($id) use ($app, $userResource) {
    $userResource->edit($id,
			'sebaaaaa',
			$app->request->post('email'),
			$app->redirect('/usuarios'));
		
});
$app->get('/usuarios(/eliminar(/(:id)(/)))', function($id) use ($app, $userResource) {
    		$userResource->delete($id);
    		$app->redirect('/usuarios');
			/*echo $app->view->render(
		"cuotas/index.twig", 
		array('cuotas' => ($cuotasResource->get())));*/
		
});

$app->run();