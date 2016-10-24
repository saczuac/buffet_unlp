<?php 

namespace App\Controller;

use App\Controller\AbstractController;

class HomeController extends AbstractController
{
	public function index($request) {
		if($request->isGet()) {
			return $this->getView()->render("home.twig");
		}
	}
}

 ?>