<?php

namespace App\Http\Controllers;

use App\Models\ReservacionCajon;
use App\Models\Cajon;
use App\Http\Requests\ReservacionCajonRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class ReservacionCajonController
 * @package App\Http\Controllers
 */
class ReservacionCajonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservacionCajons = ReservacionCajon::paginate();

        return view('admin.reservacion-cajon.index', compact('reservacionCajons'))
            ->with('i', (request()->input('page', 1) - 1) * $reservacionCajons->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $reservacionCajon = new ReservacionCajon();
        return view('admin.reservacion-cajon.create', compact('reservacionCajon'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservacionCajonRequest $request)
    {
        ReservacionCajon::create($request->validated());

        return redirect()->route('reservacion-cajons.index')
            ->with('success', 'ReservacionCajon created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $reservacionCajon = ReservacionCajon::find($id);

        return view('admin.reservacion-cajon.show', compact('reservacionCajon'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $reservacionCajon = ReservacionCajon::find($id);

        return view('admin.reservacion-cajon.edit', compact('reservacionCajon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReservacionCajonRequest $request, ReservacionCajon $reservacionCajon)
    {
        $reservacionCajon->update($request->validated());

        return redirect()->route('reservacion-cajons.index')
            ->with('success', 'ReservacionCajon updated successfully');
    }

    public function destroy($id)
    {
        ReservacionCajon::find($id)->delete();

        return redirect()->route('reservacion-cajons.index')
            ->with('success', 'ReservacionCajon deleted successfully');
    }

    // public function aprobarReserva(ReservacionCajonRequest $request)
    // {
    //     $id_usuario = $request->input('id_usuario');
    //     $id_cajon = $request->input('id_cajon');

    //     try {
    //         // Actualizar la reserva usando Eloquent
    //         $reserva = ReservacionCajon::where('id_cajon', $id_cajon)
    //             ->where('id_usuario', $id_usuario)
    //             ->update(['estatus' => 1]);

    //         // Verificar si la actualización de la reserva fue exitosa
    //         if ($reserva > 0) {
    //             // Actualizar el cajón usando Eloquent
    //             $cajon = Cajon::where('id', $id_cajon)
    //                 ->update(['estatus' => 2]);

    //             // Verificar si la actualización del cajón fue exitosa
    //             if ($cajon > 0) {
    //                 // Commit la transacción
    //                 return redirect()->route('reservacion-cajons.index')
    //                     ->with('success', 'Reservacion aprobada');
    //             }
    //         }
    //     } catch (\Exception $e) {
    //         return redirect()->route('reservacion-cajons.index')
    //             ->with('error', 'Error al aprobar reserva: ' . $e->getMessage());
    //     }
    // }


    public function aprobarReserva($idCajon, $idUsuario)
    {
        $id_cajon = intval($idCajon);
        $id_usuario = intval($idUsuario);

        try {
            DB::statement('CALL aprobar_reserva_cajon(?, ?)', [$id_usuario, $id_cajon]);

            return redirect()->route('reservacion-cajons.index')
                ->with('success', 'Reservacion aprobada');
           
       } catch (\Exception $e) {
            return redirect()->route('reservacion-cajons.index')
                ->with('error', 'Error al aprobar reserva'. $e->getMessage());
       }
    }


    /**
     * metodos para cliente
     */
    public function crearReserva($id_cajon)
    {
        $reservacionCajon = new ReservacionCajon();
        return view('cliente.reservacion-cajon.create', compact('reservacionCajon', 'id_cajon'));
    }

    public function reservarCajon(ReservacionCajonRequest $request)
    {
        $id_usuario = Auth::id();

        $existingReservation = ReservacionCajon::where('id_usuario', $id_usuario)
            ->where('id_cajon', $request->id_cajon)
            ->where('inicio', $request->inicio)
            ->where('fin', $request->fin)
            ->exists();

        // Si no existe una reservación, proceder con la creación de la nueva reservación
        if (!$existingReservation) {
            ReservacionCajon::create($request->validated());

            return redirect()->route('asignadas.areas')
                ->with('success', 'Cajón reservado correctamente.');
        } else {
            // Si ya existe una reservación, redirigir al usuario con un mensaje de error
            return redirect()->route('asignadas.areas')
                ->with('error', 'Ya tienes una reservación para este cajón.');
        }
    }

    public function listarReservas()
    {
        $id_usuario = Auth::id();
        $rol = Auth::user()->role;

        $reservas = ReservacionCajon::where('id_usuario', $id_usuario)
            ->get();

        if ($rol == 2) {
            return view('cliente.reservacion-cajon.index', compact('reservas'));
        } else {
            return view('usuario.reservacion-cajon.index', compact('reservas'));
        }
    }

    public function cajonesReservados()
    {
        $id_usuario = Auth::id();
        $rol = Auth::user()->role;

        $cajones = ReservacionCajon::select('reservacion_cajons.id AS reserva_id', 'reservacion_cajons.fecha', 'reservacion_cajons.inicio', 'reservacion_cajons.fin', 'cajons.*', 'areas.id AS id_area', 'areas.nombre')
            ->join('cajons', 'reservacion_cajons.id_cajon', '=', 'cajons.id')
            ->join('areas', 'cajons.id_area', '=', 'areas.id')
            ->where('reservacion_cajons.id_usuario', $id_usuario)
            ->where('cajons.estatus', 2)
            ->where('reservacion_cajons.estatus', 1)
            // ->distinct()
            ->get();

        if ($rol == 2) {
            return view('cliente.reservacion-cajon.reservados', compact('cajones'));
        } else {
            return view('usuario.reservacion-cajon.reservados', compact('cajones'));
        }
    }

    /**
     * metodos para usuario
     */
}
