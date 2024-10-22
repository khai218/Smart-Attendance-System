<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event_History extends Model
{
    use HasFactory;

    // Add the table name if it does not follow Laravel's naming convention
    protected $table = 'event_history'; // Assuming the table name is 'event_histories'
    
    // Add fillable fields if needed
    protected $fillable = ['name', 'location', 'time_held'];
}

