<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Panel;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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

    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, 'superadmin1@gmail.com') && $this->hasVerifiedEmail();
    }


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
        return $this->hasOne(LaporanKeuangan::class);
    }

    public function catatan_iuran()
    {
        return $this->hasOne(CatatanIuran::class, 'anggota_catatan_iuran');
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
