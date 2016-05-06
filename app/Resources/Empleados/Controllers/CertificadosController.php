<?php
/**
 * Created by tav0
 * Date: 5/05/16
 * Time: 07:51 PM
 */

namespace app\Resources\Empleados\Controllers;


use App\Core\BaseController;
use App\Models\Certificado;
use App\Resources\Empleados\CertificadosRepository;
use FPDF;
use Illuminate\Support\Facades\DB;

class CertificadosController extends BaseController
{

    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return CertificadosRepository::class;
    }

    public function show()
    {

    }

    public function create($empleado_id, $tipo_crt)
    {
        DB::beginTransaction();
        $certificado_id = $this->generateId($empleado_id, $tipo_crt);
        $certificado = $this->repository->find($certificado_id);
        if (!$certificado) {
            $certificado = $this->repository->create([
                'id' => $certificado_id,
                'cedula_empleado' => $empleado_id,
                'tipo' => $tipo_crt,
                'fecha' => new \DateTime()
            ]);
        }
        if ($this->crearPdf($certificado)){
            DB::commit();
        } else {
            DB::rollBack();
        }
    }

    private function generateId($empleado_id, $tipo_certificado)
    {
        return date('y') . date('m') . date('d') . substr('000' . $empleado_id, -10) . $tipo_certificado;
    }

    public function crearPdf(Certificado $certificado)
    {
        $empleado = $certificado->empleado;
        //echo print_r($empleado);
        //$empleado = new Empleado();
        $pdf = new FPDF('P', 'cm', 'Letter');
        //$pdf = new FPDF_Protection();
        //$pdf->SetProtection(array('print'));
        $pdf->AddPage();
        $pdf->SetMargins(3, 3, 2);
        $pdf->SetAutoPageBreak(true, 1);
        $pdf->SetLineWidth(1.5);
        $pdf->SetFont('Arial');
        $pdf->Image('assets/images/logo.png', 14, 0.3, 5, 'PNG');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(17.5, 6, $certificado->id, 0, 2, 'R');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(0);
        $pdf->Cell(0, 0, 'Valledupar, ' . $this->formatFecha($certificado->fecha) , 0, 2, 'L');
        $pdf->Ln(2);
        $pdf->Cell(0, 0, 'EL DEPARTAMENTO DE TALENTO HUMANO', 0, 2, 'C');
        $pdf->Ln(1);
        $pdf->Cell(0, 0, utf8_decode('DE LÁCTEOS DEL CESAR S.A.'), 0, 2, 'C');
        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'B');
        $pdf->Cell(0, 0, 'CERTIFICA:', 0, 2, 'C');
        $pdf->Ln(2);
        $pdf->SetFont('Arial');

        $contratoEmpleado = $empleado->contrato;
        $salario = '';
        if($certificado->tipo == 2){
            $salario = ', devengando un salario básico mensual de $'.number_format($contratoEmpleado->salario);
        }
        if($certificado->tipo == 3){
            $salario = ', devengando un salario promedio mensual de $'.number_format($contratoEmpleado->salario_promedio, 0, '', '.');
        }

        $labora = 'labora';
        $feca_contratacion = "desde el " . $this->formatFecha($contratoEmpleado->fecha_ingreso);
        if($contratoEmpleado->estado == 'R'){
            $labora = 'laboró';
            $feca_contratacion .= ', hasta el ' . $this->formatFecha($contratoEmpleado->fecha_retiro);
        }else{
            $feca_contratacion = ' mediante contrato '.$contratoEmpleado->tipo.', '.$feca_contratacion;
        }

        $pdf->MultiCell(0, 0.6, utf8_decode('Que el señor(a) '
            .strtoupper($empleado->nombre.' '.$empleado->apellidos.' ')
            .'con cédula de ciudadanía '.$empleado->cedula
            .', '.$labora.' en esta compañía en el cargo de '
//            .$contratoEmpleado->cargo->descripcion .', '
            . $feca_contratacion
            .$salario.'.'), 0, 'J', false);
        $pdf->Ln(2);
        $pdf->Cell(0, 0, utf8_decode('Esta certificación se expide a solicitud del interesado.'), 0, 2);
        $pdf->Ln(5);
//        $pdf->Image('assets/images/Firma.png', 8, 19, 7, 'PNG'); //todo: descomentar
        $pdf->SetFont('Arial', 'B');
        $pdf->Cell(0, 0, 'MAYRA ALEJANDRA CARO DAZA', 0, 2, 'C');
        $pdf->Ln(0.5);
        $pdf->SetFont('Arial');
        $pdf->Cell(0, 0, 'Jefe de Talento Humano', 0, 2, 'C');
        $pdf->Image('assets/images/Pie.JPG', 1, 25.5, 19, 'JPG');
        $pdf->Output();
        return true;
    }

    private function formatFecha($fecha = null)
    {
        $meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        if ($fecha instanceof \DateTime) {
            return $fecha->format('d') . " de " . $meses[$fecha->format('n')] . " de " . $fecha->format('Y');
        } elseif (is_string($fecha)) {
            $año = substr($fecha, 0, 4);
            $mes = substr($fecha, 4, 2);
            $dia = substr($fecha, 6, 2);
            return $dia . " de " . $meses[(int)$mes] . " de " . $año;
        } else {
            throw new \Exception("Error en la generacion del certificado, fecha no valida ".$fecha);
        }
    }

}