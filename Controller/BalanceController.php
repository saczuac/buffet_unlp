<?php

namespace Controller;
use mpdf;
use Model\Resource\EgresoDetalleResource;
use Model\Resource\IngresoDetalleResource;
use Model\Resource\PedidoResource;
use Model\Resource\BalanceResource;
use Controller\Validator;
class BalanceController {
    private $paramDesde;
    private $paramHasta;
public function valoresGanancias($app,$desde,$hasta)
{

    $egresos=EgresoDetalleResource::getInstance()->getSumEgresontre($desde,$hasta);
    $ingresos=IngresoDetalleResource::getInstance()->getSumIngresos($desde,$hasta);
    $pedidos=PedidoResource::getInstance()->getSumPedidos($desde,$hasta);
    foreach ($pedidos as &$valor) {
        $valor['name']=$valor['name']->format('Y-m-d');
    }
    foreach ($egresos as &$valor) {
        $valor['name']=$valor['name']->format('Y-m-d');
    }
        foreach ($ingresos as &$valor) {
        $valor['name']=$valor['name']->format('Y-m-d');
    }
    $params=$this->myMergeMas($ingresos,$pedidos);
    $params=$this->myMergeMenos($params,$egresos);
    foreach ($params as &$valor) {
      $valor['y']=(float)$valor['y'];
      /*$valor['name']=$valor['name']->format('Y-m-d');*/
    }
    return $params;
}

public function ganancias($app,$desde,$hasta,$token)
  {
    CSRF::getInstance()->control($app,$token);
    $app->applyHook('must.be.gestion.or.administrador');
    $errors=$this->validarFechas($desde,$hasta);
    if (sizeof($errors) == 0) {
        echo $app->view->render( "ganancias.twig", array('json' => $this->armoJsonGanancias(BalanceResource::getInstance()->gananciasEntre($desde,$hasta)),'ganancias' => BalanceResource::getInstance()->gananciasEntre($desde,$hasta),'desde'=>$desde,'hasta'=>$hasta));
    }else{
        $app->flash('errors', $errors);
        echo $app->redirect('/');
    }
  }
  public function exportGanancias($app,$desde,$hasta)
{   
    $app->applyHook('must.be.gestion.or.administrador');
    $mpdf=new mPDF('');
    $listado=$this->valoresGanancias($app,$desde,$hasta);
    $html .= "
    <div style=\"font-family:arialunicodems;\">
    <table border=\"1\">
    <thead>
    <tr style=\"text-rotate:0\">
            <th>Dia  </th>
            <th>Ganancia</th>
    </tr>
    </thead>
    ";
    foreach($listado as $row) {
            $html .= "<tr>";
      $html .= '<td style="font-family: arial;">'.$row['name'].'</td>';
      $html .= '<td style="font-family: arial;">'.$row['y'].'</td>';
      $html .= "</tr>
    ";
    }
    $html .= "</table>
    </div>
    ";
    $html = utf8_encode($html);
    if ($_REQUEST['html']) { echo $html; exit; }
    $mpdf->WriteHTML($html);
    $mpdf->Output('nombre.pdf','D'); exit;
    $app->flash('success', 'El responsable a sido desasignado exitosamente.');
    header("Refresh:0");
      }
public function armoJsonGanancias($values)
{
    foreach ($values as &$valor) {
        $valor['name']=$valor['name']->format('Y-m-d');
    }
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
                    'format'=>'${point.y:.1f}'
                )
            )
        ),

        'tooltip'=>array(
            'headerFormat'=>'<span style="font-size:11px">{series.name}</span><br>',
            'pointFormat'=>'<span style="color:{point.color}">{point.name.date}</span>: <b>${point.y:.2f}</b><br/>'
        ),

        'series'=>[array(
            'name'=>'Brands',
            'colorByPoint'=>true,
            'data'=>$values)
      ])
    ;
  return $arregloJson;


}

public function armoJsonVentas($values)
{
    foreach ($values as &$valor) {
      $valor['y']=(float)$valor['y'];
      /*$valor['name']=$valor['name']->format('Y-m-d');*/
    }
  $arregloJson=
        array(
            'chart'=>array(
                'plotBackgroundColor'=>null,
                'plotBorderWidth'=>null,
                'plotShadow'=>false,
                'type'=>'pie'
            ),
            'title'=>array(
                'text'=>'Browser market shares January, 2015 to May, 2015'
            ),
            'tooltip'=>array(
                'pointFormat'=>'{series.name}: <b>{point.percentage:.1f}%</b>'
            ),
            'plotOptions'=>array(
                'pie'=>array(
                    'allowPointSelect'=>true,
                    'cursor'=>'pointer',
                    'dataLabels'=>array(
                        'enabled'=>false
                    ),
                    'showInLegend'=>true
                )
            ),
          'series'=>[array(
            'name'=>'Brands',
            'colorByPoint'=>true,
            'data'=>$values)
      ])
    ;

  return $arregloJson;


}

public function myMergeMenos($ingresos,$egresos)
{   foreach ($ingresos as &$ingreso) {
      foreach ($egresos as $key=>&$egreso) {
        if ($ingreso['name']==$egreso['name']) {
          $ingreso['y']=$ingreso['y']-$egreso['y'];
          unset($egresos[$key]);
        }
      }
    }
    foreach ($egresos as &$egreso) {
      $egreso['y']=$egreso['y']*-1;
      array_push($ingresos,$egreso);
    }
    return $ingresos;
}
public function myMergeMas($ingresos,$pedidos)
{   foreach ($ingresos as &$ingreso) {
      foreach ($pedidos as $key=>&$pedido) {
        if ($ingreso['name']==$pedido['name']) {
          $ingreso['y']=$ingreso['y']+$pedido['y'];
          unset($pedido[$key]);
        }
      }
    }
    foreach ($pedidos as &$pedido) {
      array_push($ingresos,$pedido);
    }
    return $ingresos;
}
public function ventas($app,$desde,$hasta,$token)
  {CSRF::getInstance()->control($app,$token);
    $app->applyHook('must.be.gestion.or.administrador');
    $errors=$this->validarFechas($desde,$hasta);
    if (sizeof($errors) == 0) {
    $ingresos=IngresoDetalleResource::getInstance()->getVentasEntre($desde,$hasta);
    $pedidos=PedidoResource::getInstance()->getVentasEntre($desde,$hasta);
    foreach ($ingresos as &$valor) {
      $valor['y']=(float)$valor['y'];
      /*$valor['name']=$valor['name']->format('Y-m-d');*/
    }
    foreach ($pedidos as &$valor) {
      $valor['y']=(float)$valor['y'];
      /*$valor['name']=$valor['name']->format('Y-m-d');*/
    }
    $params=$this->myMergeMas($ingresos,$pedidos);
    $app->applyHook('must.be.gestion.or.administrador');
    echo $app->view->render( "balanceIngresos.twig", array('json' => $this->armoJsonVentas(BalanceResource::getInstance()->ventaProductosEntre($desde,$hasta)),'ventas'=>BalanceResource::getInstance()->ventaProductosEntre($desde,$hasta),'desde'=>$desde,'hasta'=>$hasta));
    }else{
        $app->flash('errors', $errors);
        echo $app->redirect('/');
    }
  }
public function exportVentas($app,$desde,$hasta)
{ 
    $app->applyHook('must.be.gestion.or.administrador');
    $mpdf=new mPDF('');
    $listado=IngresoDetalleResource::getInstance()->getVentasEntre($desde,$hasta);
    $html .= "
    <div style=\"font-family:arialunicodems;\">
    <table border=\"1\">
    <thead>
    <tr style=\"text-rotate:0\">
            <th>Producto  </th>
            <th>Cantidad</th>
    </tr>
    </thead>
    ";
    foreach($listado as $row) {
      $html .= "<tr>";
      $html .= '<td style="font-family: arial;">'.$row['name'].'</td>';
      $html .= '<td style="font-family: arial;">'.$row['y'].'</td>';
      $html .= "</tr>
    ";
    }
    $html .= "</table>
    </div>
    ";
    $html = utf8_encode($html);
    if ($_REQUEST['html']) { echo $html; exit; }
    $mpdf->WriteHTML($html);
    $mpdf->Output('nombre.pdf','D'); exit;
    $app->flash('success', 'El responsable a sido desasignado exitosamente.');
    header("Refresh:0");
      }
public function validarFechas($desde,$hasta) {
    $errors = [];
    if (!Validator::isDate($desde)) {
         $errors[] = 'Fecha desde incorrecta';
    }
    if (!Validator::isDate($hasta)) {
         $errors[] = 'Fecha hasta incorrecta';
    }
    return $errors;
  }
}

