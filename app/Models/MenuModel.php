<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table      = 'menu';
    protected $primaryKey = 'id_menu';
    protected $allowedFields = ['nama_menu', 'harga', 'kategori', 'deskripsi', 'status', 'created_at', 'foto'];

    public function getMenus()
    {
        return $this->findAll(); // Mengambil semua menu
    }
}
