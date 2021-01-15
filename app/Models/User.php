<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Translation\HasLocalePreference;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class User extends Authenticatable implements JWTSubject, HasLocalePreference, Searchable
{
    use HasFactory, Notifiable, HasRoles, Uuid, SearchHelper;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'password',
        'avatar',
        'social',
        'email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'social',
        'email'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'social' => 'array',
        'email_verified_at' => 'datetime',
    ];


    protected $guard_name = 'api';

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

    public function preferredLocale(){
        return config('app.locale');
    }


    /**
     * for elasticsearch
     */
    public static function getAliasName(){
        return 'users';
    }
    public static function getProperties(){
        return [
            'id' => [
                'type' => 'text',
                'analyzer' => 'standard'
            ],
            'name' => [
                'type' => 'text',
                'analyzer' => 'standard'
            ],
            'email' => [
                'type' => 'text',
                'analyzer' => 'standard'
            ]
        ];
    }
    public function toESArray(){
        return Arr::only((array) DB::table('users')->find($this->id), [
                'id',
                'name',
                'email'
            ]
        );
    }
}
