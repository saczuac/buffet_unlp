<?php

namespace Controller;
use Model\Resource\EgresoDetalleResource;
use Model\Resource\IngresoDetalleResource;
class BalanceController {

public function ganancias($app,$desde,$hasta)
  {
    $egresos=EgresoDetalleResource::getInstance()->getSumEgresontre($desde,$hasta);
    $ingresos=IngresoDetalleResource::getInstance()->getSumIngresos($desde,$hasta);
    foreach ($egresos as &$valor) {
        $valor['name']=$valor['name']->format('Y-m-d');
    }
        foreach ($ingresos as &$valor) {
        $valor['name']=$valor['name']->format('Y-m-d');
    }
    $params=$this->myMerge($ingresos,$egresos);
    foreach ($params as &$valor) {
      $valor['y']=(float)$valor['y'];
      /*$valor['name']=$valor['name']->format('Y-m-d');*/
    }
    $app->applyHook('must.be.gestion.or.administrador');
    echo $app->view->render( "ganancias.twig", array('ganancias' => $this->armoJson($params)));
  }
public function armoJson($values=null)
{

  $arregloJson=
        array(
        'chart'=>array(
            'type'=> 'column'
        ),
        'title'=>array(
            'text'=>'Browser market shares. January, 2015 to May, 2015'
        ),
        'subtitle'=>array(
            'text'=>'Click the columns to view versions. Source: <a href="http://netmarketshare.com">netmarketshare.com</a>.'
        ),
        'xAxis'=>array(
            'type'=>'category'
        ),
        'yAxis'=>array(
            'title'=>array(
                'text'=>'Total percent market share'
            )

        ),
        'legend'=>array(
            'enabled'=>false
        ),
        'plotOptions'=>array(
            'series'=>array(
                'borderWidth'=>0,
                'dataLabels'=>array(
                    'enabled'=>true,
                    'format'=>'{point.y:.1f}'
                )
            )
        ),

        'tooltip'=>array(
            'headerFormat'=>'<span style="font-size:11px">{series.name}</span><br>',
            'pointFormat'=>'<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        ),

        'series'=>[array(
            'name'=>'Brands',
            'colorByPoint'=>true,
            'data'=>$values)
      ])
    ;
  return $arregloJson;


}

public function myMerge($ingresos,$egresos)
{   foreach ($ingresos as &$ingreso) {
      foreach ($egresos as $key=>&$egreso) {
        if ($ingreso['name']==$egreso['name']) {
          $ingreso['y']=$ingreso['y']-$egreso['y'];
          unset($egresos[$key + 1]);
        }
      }
    }
    foreach ($egresos as &$egreso) {
      $egreso['y']=$egreso['y']*-1;
      array_push($ingresos,$egreso);
    }
    return $ingresos;
}
}
