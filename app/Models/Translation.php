<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Translation extends Model
{
    use HasFactory; // Ensure this trait is included
    protected $fillable = [
        'key', // Add the key here
        'content', // Add other attributes as needed
        'locale', // Add other attributes as needed
        'tag' // Add other attributes as needed
    ];
}
