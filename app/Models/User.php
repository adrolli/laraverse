<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use App\Models\Traits\FilamentTrait;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use FilamentTrait;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasRoles;
    use Notifiable;
    use Searchable;
    use TwoFactorAuthenticatable;

    protected $fillable = ['name', 'email', 'password'];

    protected $searchableFields = ['*'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        //return str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
        return $this->hasVerifiedEmail();
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function stacksCreated()
    {
        return $this->hasMany(Stack::class, 'user_id');
    }

    public function stacks()
    {
        return $this->belongsToMany(Stack::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }
}
