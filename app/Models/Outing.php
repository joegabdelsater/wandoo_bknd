<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outing extends Model
{
    use HasFactory;

    public function guests() {
        return $this->hasMany(OutingGuest::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class, "outing_categories");
    }
}
