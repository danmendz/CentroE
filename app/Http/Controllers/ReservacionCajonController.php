<?php

namespace App\Http\Controllers;

use App\Models\ReservacionCajon;
use App\Http\Requests\ReservacionCajonRequest;
use Illuminate\Support\Facades\Auth;

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

     /**
     * metodos para usuario
     */
}
