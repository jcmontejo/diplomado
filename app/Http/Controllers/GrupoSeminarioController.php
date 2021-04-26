<?php

namespace App\Http\Controllers;

use App\Account;
use App\DeudaSeminario;
use App\GrupoSeminario;
use App\InscripcionSeminarioGrupo;
use App\PagoRecibidoSeminario;
use App\PagoSeminario;
use App\PaymentMethod;
use App\Seminario;
use App\Student;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

class GrupoSeminarioController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admon.grupos.index');
    }

    public function data()
    {
        $rows = GrupoSeminario::select(['id', 'nombre']);

        return Datatables::of($rows)
            ->addColumn('action', function ($cat) {
                return '<div class="btn-group">
          <button type="button" class="btn btn-primary" value="' . $cat->id . '" onClick="editCat(' . $cat->id . ');" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-edit"></i>
          </button>
          <button type="button" value="' . $cat->id . '" OnClick="DeleteMod('.$cat->id.');" class="btn btn-danger" data-toggle="modal" data-target="#modalDelete"><i class="fa fa-trash"></i>
          </button>
          <a href="/admon/CATgrupos/estudiantes/' . $cat->id . '" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Estudiantes"><i class="fa fa-eye"></i>
          </a>
          </div>';
            })
            ->make(true);
    }

    public function getCats(Request $request)
    {
        $data = [];

        if ($request->has('q')) {
            $search = $request->q;
            $data = GrupoSeminario::select("id", "name")
                ->where('name', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($data);
    }

    public function showStudents($id)
    {
        $grupo = GrupoSeminario::find($id);
        $metodos = PaymentMethod::all();
        $cuentas = Account::all();

        $estudiantes = InscripcionSeminarioGrupo::join('seminarios', 'inscripcion_seminario_grupos.seminario_id', '=', 'seminarios.id')
            ->join('students', 'inscripcion_seminario_grupos.student_id', '=', 'students.id')
            ->join('grupo_seminarios', 'inscripcion_seminario_grupos.grupo_id', '=', 'grupo_seminarios.id')
            ->join('deuda_seminarios', 'inscripcion_seminario_grupos.id', '=', 'deuda_seminarios.inscripcion_id')
            ->select([
                'seminarios.nombre as seminario',
                'seminarios.clave as clave_seminario',
                'grupo_seminarios.nombre as grupo',
                'students.enrollment as matricula',
                DB::raw('CONCAT(students.last_name,"/", students.mother_last_name," ",students.name) AS estudiante'),
                'inscripcion_seminario_grupos.costo_final as costo_final',
                'inscripcion_seminario_grupos.descuento as descuento',
                'inscripcion_seminario_grupos.primer_pago as primer_pago',
                'deuda_seminarios.monto as deuda',
                'inscripcion_seminario_grupos.id as ID'
            ])
            ->where('inscripcion_seminario_grupos.grupo_id', '=', $id)
            ->where('inscripcion_seminario_grupos.activo', '=', true)
            ->get();

        return view('admon.grupos.estudiantes', compact('estudiantes', 'grupo', 'metodos', 'cuentas'));
    }

    public function dataStudents($id)
    {
        $inscription = InscripcionSeminarioGrupo::find($id);
        $student = Student::where('id', '=', $inscription->student_id)->first();
        $debt = DeudaSeminario::where('inscripcion_id', '=', $inscription->id)->first();
        $vendedor = User::where('id', '=', $inscription->id_vendedor)->first();
        $payments = PagoSeminario::where('deuda_id', '=', $debt->id)->get();
        $seminario = Seminario::where('id', '=', $inscription->seminario_id)->first();
        $grupo = GrupoSeminario::where('id', '=', $inscription->grupo_id)->first();

        return response()->json([
            'inscripcion' => $inscription,
            'estudiante' => $student,
            'seminario' => $seminario,
            'vendedor' => $vendedor,
            'grupo' => $grupo,
            'deuda' => $debt,
            'pagos' => $payments
        ]);
    }

    public function newPayment(Request $request)
    {
        $fecha = Carbon::now()->toDateString();

        $inscripcion = InscripcionSeminarioGrupo::find($request->id_inscripcion);
        $deuda = DeudaSeminario::where('inscripcion_id', '=', $request->id_inscripcion)->first();

        $ultimo_pago = PagoSeminario::where('deuda_id', '=', $deuda->id)->latest('id')->first();

        $nuevo_pago = new PagoSeminario();
        $nuevo_pago->monto = 0;
        $nuevo_pago->fecha_de_pago = $fecha;
        $nuevo_pago->numero_de_pago = $ultimo_pago->numero_de_pago + 1;
        $nuevo_pago->deuda_id = $ultimo_pago->deuda_id;
        $nuevo_pago->save();

        return response()->json($inscripcion);
    }

    function storePayment(Request $request)
    {
        try {
            $pago = PagoSeminario::findOrFail($request->id_pago);
            $deuda = DeudaSeminario::where('id', '=', $pago->deuda_id)->first();
            $inscripcion = InscripcionSeminarioGrupo::where('id', '=', $deuda->inscripcion_id)->first();

            $pago_recibido = new PagoRecibidoSeminario();
            $pago_recibido->numero_de_pago = $pago->numero_de_pago;
            $pago_recibido->fecha_pago = $request->fecha_pago;
            $pago_recibido->monto_recibido = $request->monto;
            $pago_recibido->metodo_de_pago = $request->metodo_pago;
            $pago_recibido->cuenta_destino = $request->cuenta_destino;
            $pago_recibido->inscripcion_id = $inscripcion->id;
            $pago_recibido->deuda_id = $deuda->id;
            $pago_recibido->grupo_id = $inscripcion->grupo_id;
            $pago_recibido->student_id = $inscripcion->student_id;
            $pago_recibido->save();

            $pago->activo = false;
            $pago->save();

            $deuda->monto = $deuda->monto - $pago_recibido->monto_recibido;
            $deuda->save();

            if ($deuda->monto <= 0) {
                $deuda->activo = false;
                $deuda->save();

                $pagos_pendientes = PagoSeminario::where('deuda_id', '=', $deuda->id)
                    ->where('activo', '=', true)
                    ->get();

                if ($pagos_pendientes) {
                    foreach ($pagos_pendientes as $key => $pago) {
                        $pago->activo = false;
                        $pago->save();
                    }
                }
            }

            return response()->json([
                'i' => $inscripcion,
                'd' => $deuda,
                'p' => $pago,
                'pr' => $pago_recibido
            ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            try {
                $row = new GrupoSeminario();
                $row->nombre = $request->nombre;
                $row->save();

                return response()->json("success");
            } catch (\Exception $e) {
                return response()->json($e->getMessage());
            }
        }
    }

    public function get($id)
    {
        $cat = GrupoSeminario::find($id);
        return response()->json(['cat' => $cat]);
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            try {

                $cat = GrupoSeminario::find($id);
                $cat->nombre = $request->nombre;
                $cat->save();

                return response()->json("success");
            } catch (\Exception $e) {
                return response()->json($e->getMessage());
            }
        }
    }

    public function delete($id)
    {
        $cat = GrupoSeminario::find($id);
        $cat->delete();
        return response()->json("sucess");
    }

    public function destroy(Request $request)
    {
        $cat = GrupoSeminario::find($request->id);
        $cat->delete();
        
        return response()->json("sucess");
    }

    public function deleteStudent($id)
    {
        $estudiante = InscripcionSeminarioGrupo::find($id);
        $estudiante->activo = false;
        $estudiante->save();

        return response()->json("sucess");
    }
}
