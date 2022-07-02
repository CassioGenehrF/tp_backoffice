<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

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

    protected $appends = ['role'];

    protected function getRoleAttribute(): string
    {
        $role = DB::query()
            ->select('meta_value')
            ->from('wp_usermeta')
            ->where('meta_key', 'wp_capabilities')
            ->where('user_id', $this->ID)
            ->first();
        
        $role = $role ? substr(substr($role->meta_value, 0, -7), 11) : '';
        
        return $role;
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'post_author', 'ID');
    }
}
