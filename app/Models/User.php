<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_code',
        'user_name',
        'user_email',
        'user_password',
        'user_active',
        'user_modified',
        'user_modified_by',
        'user_created'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'user_password' => 'hashed',
    ];

    static function fetch($id = 0, $params = null, $limit = null, $lastId = null)
    {
        $users = self::limit($limit);

        if (isset($params['q'])) {
            $users->where(function (Builder $query) use ($params) {
                $query->where('rt_code', 'like', '%' . $params['q'] . '%')
                    ->orWhere('rt_firstName', $params['q'])
                    ->orWhere('rt_lastName', $params['q'])
                    ->orWhere('rt_phone', $params['q'])
                    ->orWhere('rt_state', $params['q'])
                    ->orWhere('ro_phone', $params['q']);
            });

            unset($params['q']);
        }

        if ($params) $users->where($params);
        if ($lastId) $users->where('id', '<', $lastId);
        if ($id) $users->where('id', $id);

        return $id ? $users->first() : $users->get()->all();
    }

    static function submit($param, $id = null)
    {
        if ($id) return self::where('id', $id)->update($param) ? $id : false;
        $status = self::create($param);
        return $status ? $status->id : false;
    }
}
