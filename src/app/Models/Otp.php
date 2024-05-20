<?php

namespace Usermp\LaravelLogin\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Otp extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'username',
        'token',
        'type',
        'expired_at'
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'username'   => 'string',
        'token'      => 'string',
        'type'       => 'string',
        'expired_at' => 'datetime',
    ];


    /**
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        // When creating a new Sms record, add 3 minutes to the expired_at attribute
        static::creating(function ($sms) {
            $sms->expired_at = Carbon::now()->addSeconds(env("OTP_TOKEN_EXPIRE_SECONDS", 180));
        });
    }

    /**
     * @param $expiredAt
     * @return string
     */
    public function getExpiredAtAttribute($expiredAt): string
    {
        return Carbon::parse($expiredAt)->format("Y-m-d H:i:s");
    }

}
