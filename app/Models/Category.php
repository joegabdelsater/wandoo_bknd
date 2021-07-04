<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function outings() {
        return $this->belongsToMany(Outing::class, 'outing_categories');
    }
}
