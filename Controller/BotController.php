<?php

namespace Controller;
use Model\Entity\Subscripto;
use Model\Resource\MenuResource;
use Model\Resource\SubscriptoResource;

class BotController {
  private static $instance;

  public static function getInstance() {
      if (!isset(self::$instance)) {
        self::$instance = new self();
      }
      return self::$instance;
  }

  private function __construct() {}

  public function hoy() {
    return MenuResource::getInstance()->hoy();
  }

  public function manana() {
    return MenuResource::getInstance()->manana();
  }


}
