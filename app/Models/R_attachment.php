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

    static function fetch($id = 0, $params)
    {
        $attachments = self::join('rt_clients', 'attach_reClient', 'rt_id');

        if($params) $attachments->where($params);
        if($id)     $attachments->where('attach_id', $id);

        return $id ? $attachments->first() : $attachments->get();
    }
}