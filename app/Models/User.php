<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;


    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role == 'admin';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // public function canAccessPanel(\Filament\Panel $panel): bool
    // {
    // if ($panel->getId() === 'admin') {
    //     return $this->role === 'admin';
    // }
    
    // return true;
    // }



    // Fungsi untuk memeriksa apakah pengguna adalah admin
    // public function isAdmin()
    // {
    //     return $this->role === 'admin';
    // }

    // // Fungsi untuk memeriksa apakah pengguna adalah user
    // public function isUser()
    // {
    //     return $this->role === 'user';
    // }

    public function anggota()
    {
        return $this->hasOne(Anggota::class); // Menghubungkan dengan model Anggota
    }

    public function transaksi_keuangan()
    {
        return $this->hasOne(TransaksiKeuangan::class);
    }

    public function laporan_keuangan()
    {
        return $this->hasOne(LaporanKeuangan::class);
    }

    public function catatan_keuangan()
    {
        return $this->hasMany(LaporanKeuangan::class);
    }

    public function catatan_iuran()
    {
        return $this->hasMany(CatatanIuran::class, 'anggota_catatan_iuran');
    }

    // public function canAccessPanel(Panel $panel): bool
    // {
    //     // Hanya user dengan role admin yang bisa akses panel
    //     return $this->role === 'admin';
    // }

    // public function canAccessPanel(\Filament\Panel $panel): bool
    // {
    //     // Hanya user dengan role admin yang boleh masuk /admin
    //     return $this->role === 'admin';
    // }

}
