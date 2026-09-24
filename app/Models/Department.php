<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name', 'description', 'image'];

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}
