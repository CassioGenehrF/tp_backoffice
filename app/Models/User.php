<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'wp_users';

    protected $fillable = [
        'ID',
        'user_login',
        'user_pass',
        'user_nicename',
        'user_email',
        'user_url',
        'user_registered',
        'user_activation_key',
        'user_status',
        'display_name'
    ];

    protected $appends = ['role', 'phone', 'cpf', 'street', 'streetNumber', 'city', 'state', 'cep'];

    public function getAuthIdentifier()
    {
        return $this->ID;
    }

    public function getAuthPassword()
    {
        return Hash::make($this->user_pass);
    }

    protected function getRoleAttribute(): string
    {
        $role = DB::query()
            ->select('meta_value')
            ->from('wp_usermeta')
            ->where('meta_key', 'wp_capabilities')
            ->where('user_id', $this->ID)
            ->first();

        $role = $role ? str_replace('"', '', substr(substr($role->meta_value, 0, -7), 10)) : '';

        return $role;
    }

    protected function getCPFAttribute(): string
    {
        $cpf = DB::query()
            ->select('meta_value')
            ->from('wp_usermeta')
            ->where('meta_key', 'facebook')
            ->where('user_id', $this->ID)
            ->first();

        $cpf = $cpf ? $cpf->meta_value : '';
        return $cpf;
    }

    protected function getPhoneAttribute(): string
    {
        $phone = DB::query()
            ->select('meta_value')
            ->from('wp_usermeta')
            ->where('meta_key', 'phone')
            ->where('user_id', $this->ID)
            ->first();

        $phone = $phone ? $phone->meta_value : '';
        return $phone;
    }

    protected function getStreetAttribute(): string
    {
        $street = DB::query()
            ->select('meta_value')
            ->from('wp_usermeta')
            ->where('meta_key', 'twitter')
            ->where('user_id', $this->ID)
            ->first();

        $street = $street ? $street->meta_value : '';
        return $street;
    }

    protected function getStreetNumberAttribute(): string
    {
        $streetNumber = DB::query()
            ->select('meta_value')
            ->from('wp_usermeta')
            ->where('meta_key', 'linkedin')
            ->where('user_id', $this->ID)
            ->first();

        $streetNumber = $streetNumber ? $streetNumber->meta_value : '';
        return $streetNumber;
    }

    protected function getCityAttribute(): string
    {
        $city = DB::query()
            ->select('meta_value')
            ->from('wp_usermeta')
            ->where('meta_key', 'pinterest')
            ->where('user_id', $this->ID)
            ->first();

        $city = $city ? $city->meta_value : '';
        return $city;
    }

    protected function getStateAttribute(): string
    {
        $state = DB::query()
            ->select('meta_value')
            ->from('wp_usermeta')
            ->where('meta_key', 'website')
            ->where('user_id', $this->ID)
            ->first();

        $state = $state ? $state->meta_value : '';
        return $state;
    }

    protected function getCEPAttribute(): string
    {
        $cep = DB::query()
            ->select('meta_value')
            ->from('wp_usermeta')
            ->where('meta_key', 'instagram')
            ->where('user_id', $this->ID)
            ->first();

        $cep = $cep ? $cep->meta_value : '';
        return $cep;
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'post_author', 'ID');
    }
}
