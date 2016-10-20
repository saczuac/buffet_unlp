<?php
namespace Controller;

require_once '../vendor/autoload.php';
use Slim\Slim;

$app = new Slim(array(
  'debug' => true,
));

$url = 'https://api.telegram.org/bot296497556:AAFlvyDLjO921sqBVHhpTaV1W5D5GoUFRUw/sendMessage';
$msg = array();
$msg['disable_web_page_preview'] = true;
$msg['reply_markup'] = null;

$app->post('/hoy', function() use ($app) {
    $returnArray = true;
    $rawData = file_get_contents('php://input');
    $response = json_decode($rawData, $returnArray);
    $id_del_chat = $response['message']['chat']['id'];
    $msg['chat_id'] = $id_del_chat;
    $msg['text']  = 'El menú del día es ensalada tropical';
    $msg['reply_to_message_id'] = $response['message']['message_id'];
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
  $returnArray = true;
  $rawData = file_get_contents('php://input');
  $response = json_decode($rawData, $returnArray);
  $id_del_chat = $response['message']['chat']['id'];
  $msg['chat_id'] = $id_del_chat;
  $msg['text']  = 'El menú de mañana es: ....';
  $msg['reply_to_message_id'] = $response['message']['message_id'];
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
  $returnArray = true;
  $rawData = file_get_contents('php://input');
  $response = json_decode($rawData, $returnArray);
  $id_del_chat = $response['message']['chat']['id'];
  $msg['chat_id'] = $id_del_chat;
  $msg['text']  = 'Los comandos disponibles son estos:' . PHP_EOL;
  $msg['text'] .= '/start Inicializa el bot';
  $msg['text'] .= '/menú Muestra el menú del día';
  $msg['text'] .= '/help Muestra esta ayuda';
  $msg['reply_to_message_id'] = null;
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

$app->post('/start', function() use ($app) {
  $returnArray = true;
  $rawData = file_get_contents('php://input');
  $response = json_decode($rawData, $returnArray);
  $id_del_chat = $response['message']['chat']['id'];
  $msg['chat_id'] = $id_del_chat;
  $msg['text']  = 'Hola ' . $response['message']['from']['first_name'] . PHP_EOL;
  $msg['text'] .= '¿Como puedo ayudarte? Puedes utilizar el comando /help';
  $msg['reply_to_message_id'] = null;
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
