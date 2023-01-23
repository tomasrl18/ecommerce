<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'image', 'icon'];

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class);
    }

    // Donde el primer parámetro es con qué modelo establecemos la relación
    // y el segundo parámetro es a través de quién se hace
    public function products()
    {
        return $this->hasManyThrough(Product::class, Subcategory::class);
    }

    // para que en la ruta no se vea el id si no el nombre de la categoria
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
