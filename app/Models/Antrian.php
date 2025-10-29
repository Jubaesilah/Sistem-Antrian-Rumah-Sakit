<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    protected $table = 'antrian';

    protected $fillable = [
        'nomor_antrian',
        'loket_id',
        'status',
        'nama_pasien',
        'jenis_layanan',
        'waktu_panggil',
    ];

    protected $casts = [
        'waktu_panggil' => 'datetime',
    ];

    /**
     * Scope untuk mendapatkan antrian yang sedang dipanggil
     */
    public function scopeDipanggil($query)
    {
        return $query->where('status', 'dipanggil');
    }

    /**
     * Scope untuk mendapatkan antrian berdasarkan loket
     */
    public function scopeByLoket($query, $loketId)
    {
        return $query->where('loket_id', $loketId);
    }
}
