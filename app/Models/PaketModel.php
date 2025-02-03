<?php

namespace App\Models;

use CodeIgniter\Model;

class PaketModel extends Model
{
    protected $table      = 'paket_menu';
    protected $primaryKey = 'id_paket';
    protected $allowedFields = ['nama_paket', 'harga', 'deskripsi', 'status', 'created_at', 'foto'];

    public function getPaketMenus()
    {
        return $this->findAll(); // Mengambil semua paket
    }
}
