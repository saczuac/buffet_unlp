<?php
require_once '../vendor/autoload.php';

use Chatwork\JsonRequestMiddleware;

$app = new \Slim\Slim([
        'debug' => true
    ]);

$app->add(new JsonRequestMiddleware());

$url = 'https://api.telegram.org/bot296497556:AAFlvyDLjO921sqBVHhpTaV1W5D5GoUFRUw/sendMessage';
$msg = array();
$msg['disable_web_page_preview'] = true;
$msg['reply_markup'] = null;

$app->post('/hoy', function() use ($app) {
    $idchat = $app->json_body['message']['chat']['id'];
    $msg['chat_id'] = $idchat;
    $msg['text']  = 'El menú del día es ensalada tropical';
    $msg['reply_to_message_id'] = $app->json_body['message']['message_id'];
    $options = array(
      'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($msg)
      )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
});

$app->post('/maniana', function() use ($app) {
  $idchat = $app->json_body['message']['chat']['id'];
  $msg['chat_id'] = $idchat;
  $msg['text']  = 'El menú de mañana es pollo';
  $msg['reply_to_message_id'] = $app->json_body['message']['message_id'];
  $options = array(
    'http' => array(
      'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
      'method'  => 'POST',
      'content' => http_build_query($msg)
    )
  );
  $context  = stream_context_create($options);
  $result = file_get_contents($url, false, $context);
});

$app->post('/help', function() use ($app) {
  $idchat = $app->json_body['message']['chat']['id'];
  $msg['chat_id'] = $idchat;
  $msg['text']  = 'Los comandos disponibles son estos:' . PHP_EOL;
  $msg['text'] .= '/start Inicializa el bot';
  $msg['text'] .= '/menú Muestra el menú del día';
  $msg['text'] .= '/help Muestra esta ayuda';
  $msg['reply_to_message_id'] = $app->json_body['message']['message_id'];
  $options = array(
    'http' => array(
      'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
      'method'  => 'POST',
      'content' => http_build_query($msg)
    )
  );
  $context  = stream_context_create($options);
  $result = file_get_contents($url, false, $context);
});

$app->run();
 ?>
