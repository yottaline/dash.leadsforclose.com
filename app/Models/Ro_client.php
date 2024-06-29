<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Ro_client extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'ro_code',
        'ro_fullName',
        'ro_email',
        'ro_phone',
        'ro_active',
        'ro_created'
    ];

    static function fetch($id = 0, $params = null, $limit = null, $lastId = NULL)
    {
        $ro_clients = self::limit($limit)->orderBy('ro_created', 'DESC');

        if (isset($params['q'])) {
            $ro_clients->where(function (Builder $query) use ($params) {
                $query->where('ro_code', 'like', '%' . $params['q'] . '%')
                    ->orWhere('ro_fullName', $params['q'])
                    ->orWhere('ro_email', $params['q'])
                    ->orWhere('ro_phone', $params['q']);
            });

            unset($params['q']);
        }

        if($params) $ro_clients->where($params);

        if($lastId) $ro_clients->where('ro_id', '<', $lastId);

        return $id ? $ro_clients->first() : $ro_clients->get();
    }

    static function submit($id, $param)
    {
        if($id) return self::where('ro_id', $id)->update($param) ? $id : false;
        $status = self::create($param);
        return $status ? $status->id : false;
    }
}