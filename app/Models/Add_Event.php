<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Add_Event extends Model
{
    use HasFactory;

    protected $table = 'add_event'; 
    
    protected $fillable = ['event_name', 'matrixno', 'location','event_id'];
}

