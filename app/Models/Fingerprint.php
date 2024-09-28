<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fingerprint extends Model
{
    use HasFactory;

    // Define the table if it's not the plural of the model name
    protected $table = 'fingerprint_id'; // Adjust if necessary
    protected $fillable = ['fingerprint_id']; // Fillable fields
}
