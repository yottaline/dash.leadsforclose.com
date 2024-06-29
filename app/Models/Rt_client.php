<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

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

    static function fetch($id = 0, $params = null, $limit = null, $lastId = null)
    {
        $rt_clients = self::limit($limit)->orderBy('rt_created', 'DESC');

        if (isset($params['q'])) {
            $rt_clients->where(function (Builder $query) use ($params) {
                $query->where('rt_code', 'like', '%' . $params['q'] . '%')
                    ->orWhere('rt_firstName', $params['q'])
                    ->orWhere('rt_lastName', $params['q'])
                    ->orWhere('rt_phone', $params['q'])
                    ->orWhere('rt_state', $params['q'])
                    ->orWhere('ro_phone', $params['q']);
            });

            unset($params['q']);
        }

        if($params) $rt_clients->where($params);

        if($lastId) $rt_clients->where('rt_id', '<', $lastId);

        return $id ? $rt_clients->first() : $rt_clients->get();
    }

    static function submit($id, $clientParam, $attParam)
    {
        try {
            DB::beginTransaction();
            $status = $id ? self::where('rt_id', $id)->update($clientParam) : self::create($clientParam);
            $id = $id ? $id : $status->id;
            if (!empty($attParam)) {
                for ($i = 0; $i < count($attParam); $i++) {
                    $attParam[$i]['attach_reClient'] = $id;
                }
                R_attachment::insert($attParam);
            }
            DB::commit();
            return ['status' => true, 'id' => $id];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['status' => false, 'message' => 'error: ' . $e->getMessage()];
        }
    }


}