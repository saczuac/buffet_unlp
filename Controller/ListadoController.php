<?php

namespace Controller;
use Model\Entity\Producto;
use Model\Resource\ProductoResource;
use Model\Resource\ConfiguracionResource;

class ListadoController {

    public function indexActionStockMin($app,$page = 1) {
        $app->applyHook('must.be.gestion');
        $_SESSION['pageMin'] = $page;
        $productos = ProductoResource::getInstance()->get();
        $pageSize = ConfiguracionResource::getInstance()->get('paginacion')->getValor();
        $paginator = ProductoResource::getInstance()->getPaginateStockMin($pageSize,$page);
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $pageSize);
        $_SESSION['minCount'] = intval($pagesCount);
        echo $app->view->render('listados/stockMinimo/index.twig', array(
            "productos"     => $paginator,
            "totalItems" => $totalItems,
            "pagesCount" => $pagesCount
        ));
    }

    public function faltantesPrev($app) {
        $currentPage = $_SESSION['pageFaltante'];
        $page;
        if ($currentPage - 1 <= 0 ){
            $page = 1;
        } else {
            $page = $currentPage - 1;
        }
        $this->indexActionFaltantes($app,$page);
    }

    public function faltantesNext($app) {
        $currentPage = $_SESSION['pageFaltante'];
        $max = $_SESSION['faltanteCount'];
        $page;
        if ($currentPage + 1 > $max ){
            $page = $max;
        } else {
            $page = $currentPage + 1;
        }
        $this->indexActionFaltantes($app,$page);
    }   

     public function stockMinPrev($app) {
        $currentPage = $_SESSION['pageMin'];
        $page;
        if ($currentPage - 1 <= 0 ){
            $page = 1;
        } else {
            $page = $currentPage - 1;
        }
        $this->indexActionStockMin($app,$page);
    }

    public function stockMinNext($app) {
        $currentPage = $_SESSION['pageMin'];
        $max = $_SESSION['minCount'];
        $page;
        if ($currentPage + 1 > $max ){
            $page = $max;
        } else {
            $page = $currentPage + 1;
        }
        $this->indexActionStockMin($app,$page);
    }

    public function indexActionFaltantes($app,$page = 1) {
        $_SESSION['pageFaltante'] = $page;
        $app->applyHook('must.be.gestion');
        $productos = ProductoResource::getInstance()->get();
        $pageSize = ConfiguracionResource::getInstance()->get('paginacion')->getValor();
        $paginator = ProductoResource::getInstance()->getPaginateFaltantes($pageSize,$page);
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $pageSize);
        $_SESSION['faltanteCount'] = intval($pagesCount);
        echo $app->view->render('listados/faltantes/index.twig', array(
            "productos"     => $paginator,
            "totalItems" => $totalItems,
            "pagesCount" => $pagesCount
        ));
    }
}
