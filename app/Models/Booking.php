<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user',
        'room',
        'event-start',
        'event-end',
        'status'
    ];

    public $timestamps = false;
}
