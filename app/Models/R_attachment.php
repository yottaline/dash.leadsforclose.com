<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class R_attachment extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'attach_file',
        'attach_reClient',
        'attach_created'
    ];
}