<?php

namespace App\Models;

use CodeIgniter\Model;

class KuponModel extends Model
{
    protected $table = 'kupon';
    protected $primaryKey = 'id_kupon';
    protected $allowedFields = ['nama_kupon', 'diskon', 'tanggal_expired'];

    public function getValidKupon($kode)
    {
        return $this->where('nama_kupon', $kode)
            ->where('tanggal_expired >=', date('Y-m-d'))
            ->first();
    }
}
