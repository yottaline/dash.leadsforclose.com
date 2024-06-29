<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rt_client extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'rt_code',
        'rt_firstName',
        'rt_lastName',
        'rt_email',
        'rt_phone',
        'rt_umberSeats',
        'rt_state',
        'rt_status',
        'rt_created'
    ];


}