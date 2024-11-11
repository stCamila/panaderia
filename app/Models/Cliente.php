<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Cliente extends Model
{
    use HasFactory;
    protected $fillable = ['nombre','apellido',];

    public function productos(): BelongsToMany
{
    return $this->belongsToMany(Producto::class, 'compras', 'id_cliente', 'id_producto');
    
}
}