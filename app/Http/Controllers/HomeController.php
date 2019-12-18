<?php

namespace App\Http\Controllers;

use App\Student;
use Auth;
use App\Incentive;
use Yajra\Datatables\Datatables;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasRole('Control Escolar')) {
            return view('test.test');
        }elseif(Auth::user()->hasRole('clinica')){
            return view('clinic.home');
         }elseif(Auth::user()->hasRole('Vendedor')){
             return view('sales.home');
         }elseif (Auth::user()->hasRole('Administracion')) {
            return view('admon.home');
         } else {
            return view('home');
        }
    }

    public function traffic()
    {
        $user = Auth::user();
        if ($user->hasRole('Vendedor')) {
            $students = Student::select(['id', 'color', 'name', 'last_name', 'mother_last_name', 'facebook', 'interested', 'status', 'created_at'])
                ->where([
                    ['user_id', '=', $user->id],
                    ['status', '!=', '1'],
                    ['keep_going', '=', '1'],
                ])->get();
        } else {
            $students = Student::select(['id', 'color', 'name', 'last_name', 'mother_last_name', 'facebook', 'interested', 'status', 'birthdate', 'sex', 'phone', 'state', 'city', 'address', 'email', 'profession', 'documents', 'status', 'user_id', 'created_at'])
                ->where('status', '!=', '1');
        }

        return Datatables::of($students)
            ->setRowClass(function ($student) {
                //return $student->color == 'red' ? 'bg-danger' : 'bg-warning';
                if ($student->color == 'red') {
                    return 'bg-danger';
                } elseif ($student->color == 'yellow') {
                    return 'bg-warning';
                } else {
                    return 'bg-success';
                }
            })
            ->make(true);
    }

    public function commisionsDebt()
    {
        $user = Auth::user();

        $commissionsDebt = Incentive::select(['id', 'commission', 'full_price', 'created_at'])
            ->where([
                ['user_id', '=', $user->id],
                ['status', '=', 'pendiente'],
            ])->get();

        return Datatables::of($commissionsDebt)->make();
    }

    public function commisionsPayment()
    {
        $user = Auth::user();

        $commissionsDebt = Incentive::select(['id', 'commission', 'full_price', 'created_at'])
            ->where([
                ['user_id', '=', $user->id],
                ['status', '!=', 'pendiente'],
            ])->get();

        return Datatables::of($commissionsDebt)->make();
    }
}
