<?php namespace App\Resources\Novedades\JornadasLaborales;

use App\Resources\Empleados\Repositories\EmpleadosRepository;
use App\Resources\Novedades\Models\DiasFestivos;
use App\Resources\Novedades\Models\Empleado;
use App\Resources\Novedades\Models\IntervalosJornadaLegal;
use App\Resources\Novedades\Models\JornadaLaboral;
use Bosnadev\Repositories\Eloquent\Repository;
use DateInterval;
use DateTime;

class JornadasRepository extends Repository
{

    protected $intervalos = null;
    /**
     * Specify Model class name
     *
     * @return JornadaLaboral
     */
    public function model()
    {
        return JornadaLaboral::class;
    }

    public function all($columns = array('*'))
    {
        return $this->model->periodoActual();
    }

    public function getEmpleadosJornadasPeriodoActual()
    {
        $empleadosRepo = app(EmpleadosRepository::class);
        $empleadosRepo->setModel(Empleado::class);
        return $empleadosRepo->with(['jornadas'])->get();
    }

    public function getEmpleadosJornadasfecha($fecha)
    {
        $empleadosRepo = app(EmpleadosRepository::class);
        $empleadosRepo->setModel(Empleado::class);
        return $empleadosRepo->with(['jornadas' => function($query) use($fecha){
            $query->where('fecha', $fecha);
        }])->get();
    }

    public function create(array $data)
    {
        if(!$data['hora_entrada2']) unset($data['hora_entrada2']);
        if(!$data['hora_salida2']) unset($data['hora_salida2']);
        $jornada = parent::create($data);
        if ($jornada) {
            $this->saveHorasJornada($jornada);
        }
        return $jornada;
    }

    public function update(array $data, $id, $attribute = "id")
    {
        $jornada = $this->model->find($id);
        if($jornada->update($data)) {
            $jornada->horas()->delete();
            $this->saveHorasJornada($jornada);
        }
        return $jornada;
    }

    private function saveHorasJornada($jornada)
    {
        $horas = $this->calcularHorasExta(null,
            new DateTime($jornada->fecha),
            $jornada->hora_entrada1,
            $jornada->hora_salida1,
            $jornada->hora_entrada2,
            $jornada->hora_salida2
        );
        foreach ($horas as $tipo => $hora) {
            if ($hora) {
                $jornada->horas()->create([
                    'tipo' => $tipo,
                    'tiempo' => $hora
                ]);
            }
        }
    }

    public function calcularHorasExta($tiempos = null, DateTime $fecha, $e1, $s1, $e2 = '', $s2 = '')
    {
        $tiempos = $tiempos ?: [
            'ttl' => 0,   //tiempo total laborado
            'ho' => 0,   //horas ordinarias
            'ed' => 0,   //extra diurno
            'en' => 0,   //estra nocturno
            'fo' => 0,   //festivo ordinarias
            'efd' => 0,  //estra festivo diurno
            'efn' => 0,  //estra festivo noctruno
            'rn' => 0,   //recargo nocturno
            'ds' => 0    //dia siguiente
        ];

        $horaEntrada = strtotime($e1);
        $horaSalida = strtotime($s1);

        if ($horaEntrada > $horaSalida) {
            $tiempos = $this->calcularHorasExta($tiempos, $fecha, date('H:i', $horaEntrada), '24:00', '', '');
            $tiempos['ds'] = 1;
            $fecha->add(new DateInterval('P1D'));
            $horaEntrada = strtotime('00:00');
        }

        $minutosTrabajados = ($horaSalida - $horaEntrada) / 60;
        $cont = 0;

        $HOEstablecidas = $this->getIntervalosjornadaLegal()->horas_laborales_ordinarias * 60;

        $esfestivo = $this->esFestivo($fecha);
        do {
            if ($tiempos['ttl'] < $HOEstablecidas) {
                $esfestivo ? ++$tiempos['fo'] : ++$tiempos['ho'];
                if (!$this->esDiruna($horaEntrada)) {
                    ++$tiempos['rn'];
                }
            } else {
                if ($this->esDiruna($horaEntrada)) {
                    $esfestivo ? ++$tiempos['efd'] : ++$tiempos['ed'];
                } else {
                    $esfestivo ? ++$tiempos['efn'] : ++$tiempos['en'];
                }
            }
            ++$tiempos['ttl'];
            ++$cont;
            $horaEntrada += 60;
        } while ($cont < $minutosTrabajados);

        if ($e2 != '' and $s2 != '') {
            $tiempos = $this->calcularHorasExta($tiempos, $fecha, $e2, $s2);
        }

        return $tiempos;
    }

    private function getIntervalosjornadaLegal()
    {
        if($this->intervalos == null) {
            $this->intervalos = IntervalosJornadaLegal::get();
        }
        return $this->intervalos;
    }

    private function esDiruna($hora)
    {
        $horaDiurnaInicio = strtotime($this->getIntervalosjornadaLegal()->jornada_diurna_hora_inicio);
        $horaDiurnaFin = strtotime($this->getIntervalosjornadaLegal()->jornada_diurna_hora_fin);
        return (($hora >= $horaDiurnaInicio) && ($hora <= $horaDiurnaFin));
    }

    private function esFestivo($fecha)
    {
        return DiasFestivos::where('fecha', $fecha)->exists() ? true : false;
    }
}