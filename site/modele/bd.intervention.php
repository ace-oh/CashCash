<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    protected $fillable = ['date', 'agent', 'description'];
}


?>