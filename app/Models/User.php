<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 *  App\Models\User
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property int $zoho_id
 * @property string $country
 * @property string $state
 * @property string $access_token
 * @property string $refresh_token
 * @property int $expires_in
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'zoho_id',
        'first_name',
        'last_name',
        'id',
        'country',
        'state',
        'expires_in',
        'access_token',
        'refresh_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'expires_in' => 'integer',
        ];
    }
}
