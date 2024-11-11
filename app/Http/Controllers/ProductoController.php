<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Cliente;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
        return Inertia::render('Productos/Index',[
            'productos' => Producto::paginate(10)
        ]);
    }

    public function create()
    {
        return Inertia::render('Productos/Create',[
        'clientes' => Cliente::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:15',
            'descripcion' => 'required|max:300',
            'precio' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'required|file|mimes:png,jpg,gif',
            'clientes' => 'required|array'
        ]);
        $producto = Producto::create($request->all());
        if($request->hasFile('image')){
            $imgName = microtime(true).'.'.$request->file('image')
            ->getClientOriginalExtension();
            $request->file('image')->storeAs('img', $imgName, 'public');
            $producto->image = '/img/'.$imgName;
            $producto->save();
        }
        $producto->clientes()->sync($request->clientes);
        return redirect('productos/create')->with('success','Producto creado');
    }

    public function updateProducto(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:30',
            'descripcion' => 'required|max:300',
            'precio' => 'required|numeric',
            'stock' => 'required|numeric',
            'id' => 'required|numeric',
            'clientes' => 'required|array'
        ]);
        $producto = Producto::find($request->id);
        $producto->update($request->input());
        if($request->hasFile('image')){
            Storage::disk('public')->delete($producto->image);
            $imgName = microtime(true).'.'.$request->file('image')
            ->getClientOriginalExtension();
            $request->file('image')->storeAs('img', $imgName, 'public');
            $producto->image = '/img/'.$imgName;
            $producto->save();
        }
        $producto->clientes()->sync($request->clientes);
        return redirect('productos')->with('success','Producto actualizado :)');
    }

    public function show(Producto $producto)
    {
        return Inertia::render('Productos/Show',[
            'producto' => $producto, 'clientes' => $producto->clientes
        ]);
    }

    public function edit(Producto $producto)
    {
        return Inertia::render('Productos/Edit',[
            'clientes' => Cliente::all(),
            'producto' => $producto,
            'clientesOfProducto' => $producto->clientes
            ]);
    }

    public function update(Request $request, Producto $producto)
    {
        //
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect('productos')->with('success','Producto eliminado');
    }
}
