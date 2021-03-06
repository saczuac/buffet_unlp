<?php

$mensaje = 'No tiene los permisos para acceder a esa seccion.';

$app->hook('must.be.administrador', function () use ($app, $mensaje) {
    if (!isset($_SESSION['rol'])) {
        $app->flash('error', $mensaje);
        $app->redirect('/');
    }else{
        if ($_SESSION['rol'] !== 1) {
            $app->flash('error', $mensaje);
            $app->redirect('/');
        }
    }
});

$app->hook('must.be.habilitado', function () use ($app, $mensaje) {
    $mensaje = 'El usuario no se encuentra habilitado, contacte un administrador';
    if (!isset($_SESSION['habilitado'])) {
        $app->flash('error', $mensaje);
        $app->redirect('/');
    }else{
        if ($_SESSION['habilitado'] !== 1) {
            $app->flash('error', $mensaje);
            $app->redirect('/');
        }
    }
});

$app->hook('must.be.gestion', function () use ($app, $mensaje) {
    if (!isset($_SESSION['rol'])) {
        $app->flash('error', $mensaje);
        $app->redirect('/');
    }else{
        if ($_SESSION['rol'] !== 3) {
            $app->flash('error', $mensaje);
            $app->redirect('/');
        }
    }
});

$app->hook('must.be.online', function () use ($app, $mensaje) {
    if (!isset($_SESSION['rol'])) {
        $app->flash('error', $mensaje);
        $app->redirect('/');
    }else{
        if ($_SESSION['rol'] !== 2) {
            $app->flash('error', $mensaje);
            $app->redirect('/');
        }
    }
});

$app->hook('must.be.gestion.or.administrador', function () use ($app, $mensaje) {
    if (!isset($_SESSION['rol'])) {
        $app->flash('error', $mensaje);
        $app->redirect('/');
    }else{
        if ($_SESSION['rol'] == 2) {
            $app->flash('error', $mensaje);
            $app->redirect('/');
        }
    }
});

$app->hook('must.be.logueado', function () use ($app, $mensaje) {
    if (!isset($_SESSION['rol'])) {
        $app->flash('error', $mensaje);
        $app->redirect('/');
    }
});
$app->hook('must.be.checked', function () use ($app, $token) {
    if ($_SESSION['csrf_token']!=$_SESSION['token_received']) {
        $app->flash('error', "No esta seguro ".$_SESSION['token_received']."-".$_SESSION['csrf_token']);
        $app->redirect('/');
    }
});

 ?>
