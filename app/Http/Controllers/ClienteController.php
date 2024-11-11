<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Producto;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        $clientes = Cliente::with('productos:id,nombre')->get();
        return Inertia::render('Clientes/Index',[
            'clientes' => $clientes,
            'productos' => $productos
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' =>'required|max:80',
            'apellido' =>'required|max:80',
            'id_producto' =>'required|numeric'
        ]);
        $cliente = Cliente::create($request->only(['nombre', 'apellido']));
        $cliente->productos()->attach($request->id_producto);
        return redirect('clientes');
    }

    public function show(Cliente $cliente)
    {
        //
    }

    public function edit(Cliente $cliente)
    {
       //
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre' =>'required|max:80',
            'apellido' =>'required|max:80',
            'id_producto' =>'required|numeric'
        ]);
        $cliente->update($request->only(['nombre', 'apellido']));
        $cliente->productos()->sync([$request->id_producto]);
        return redirect('clientes');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect('clientes');
    }
}
