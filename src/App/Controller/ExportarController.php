<?php 

namespace App\Controller;
use mpdf;
use App\Controller\AbstractController;
use App\Controller\MultiResourceController;

class ExportarController extends MultiResourceController
{

	public function exportarCuotasPagas() {	
		$mpdf=new mPDF('');
		$listado = $this->getResources('cuotas')->cuotasPagas();
		$html .= "
		<div style=\"font-family:arialunicodems;\">
		<table border=\"1\">
		<thead>
		<tr style=\"text-rotate:0\">
						<th>Anio  </th>
						<th>Mes</th>
						<th>Numero</th>
						<th>Monto</th>
						<th>Nombre</th>
						<th>Apellido</th>
		</tr>
		</thead>
		";
		foreach($listado as $row) {
			$html .= '<tr><td>'.$row['anio'].'</td>';
			$html .= '<td style="font-family: arial;">'.$row['mes'].'</td>';
			$html .= '<td style="font-family: arial;">'.$row['numero'].'</td>';
			$html .= '<td style="font-family: arial;">'.$row['monto'].'</td>';
			$html .= '<td style="font-family: arial;">'.$row['nombre'].'</td>';
			$html .= '<td style="font-family: arial;">'.$row['apellido'].'</td>';
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

	public function exportarComision() {	
		$mpdf=new mPDF('');
		$listado = $this->getResources('pagos')->comision($_SESSION['user']);
		$html .= "
		<div style=\"font-family:arialunicodems;\">
		<table border=\"1\">
		<thead>
		<tr style=\"text-rotate:0\">
						<th>Anio  </th>
						<th>Mes</th>
						<th>Comision</th>
		</tr>
		</thead>
		";
		foreach($listado as $row) {
			$html .= '<tr><td>'.$row['anio'].'</td>';
			$html .= '<td style="font-family: arial;">'.$row['mes'].'</td>';
			$html .= '<td style="font-family: arial;">'.$row['comision'].'</td>';
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
	public function exportarMatriculasPagas() {	
		$mpdf=new mPDF('');
		$listado = $this->getResources('pagos')->matriculasPagasEx();
		$html .= "
		<div style=\"font-family:arialunicodems;\">
		<table border=\"1\">
		<thead>
		<tr style=\"text-rotate:0\">
						<th>Nombre </th>
						<th>Tipo Doc.</th>
						<th>N° Doc.</th>
						<th>Responsables</th>
						<th>Fecha Nac.</th>
		</tr>
		</thead>
		";
		foreach($listado as $row) {
			$html .= '<tr><td>'.$row['nombre']." ".$row['apellido'].'</td>';
			$html .= '<td style="font-family: arial;">'.$row['tipo_documento'].'</td>';
			$html .= '<td style="font-family: arial;">'.$row['numero_documento'].'</td>';
			$html .= '<td style="font-family: arial;">'.$row['nombre'].'</td>';
			$html .= '<td style="font-family: arial;">'.date_format($row['fecha_nacimiento'],'Y-m-d').'</td>';
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

	public function exportarCuotasImpagas() {	
		$mpdf=new mPDF('');
		$listado = $this->getResources('cuotas')->cuotasInpagas();
		$html .= "
		<div style=\"font-family:arialunicodems;\">
		<table border=\"1\">
		<thead>
		<tr style=\"text-rotate:0\">
						<th>Anio  </th>
						<th>Mes</th>
						<th>Numero</th>
						<th>Monto</th>
						<th>Nombre</th>
						<th>Apellido</th>
		</tr>
		</thead>
		";
		foreach($listado as $row) {
			$html .= '<tr><td>'.$row['anio'].'</td>';
			$html .= '<td style="font-family: arial;">'.$row['mes'].'</td>';
			$html .= '<td style="font-family: arial;">'.$row['numero'].'</td>';
			$html .= '<td style="font-family: arial;">'.$row['monto'].'</td>';
			$html .= '<td style="font-family: arial;">'.$row['nombre'].'</td>';
			$html .= '<td style="font-family: arial;">'.$row['apellido'].'</td>';
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


		}
?>