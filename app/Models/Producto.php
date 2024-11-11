<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Producto extends Model
{
    use HasFactory;
    protected $fillable =['nombre','descripcion','precio','stock','image'];

    public function clientes(): BelongsToMany
    {
        return $this->belongsToMany(Cliente::class, 'compras', 'id_producto', 'id_cliente');
    }
}
