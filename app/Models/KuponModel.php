<?php

namespace App\Models;

use CodeIgniter\Model;

class KuponModel extends Model
{
    protected $table = 'kupon';
    protected $primaryKey = 'id_kupon';
    protected $allowedFields = ['kode_kupon', 'diskon', 'tanggal_expired', 'qr_code'];

    public function deleteExpiredKupon()
    {
        $this->where('tanggal_expired <', date('Y-m-d'))->delete();
    }
}
