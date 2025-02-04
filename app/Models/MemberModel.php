<?php

namespace App\Models;

use CodeIgniter\Model;

class MemberModel extends Model
{
    protected $table = 'member';
    protected $primaryKey = 'id_member';
    protected $allowedFields = ['nama', 'email', 'no_hp', 'tanggal_daftar', 'tanggal_expired', 'status'];

    public function isValidMember($id)
    {
        return $this->where('id_member', $id)
                    ->where('tanggal_expired >=', date('Y-m-d'))
                    ->where('status', 'aktif')
                    ->first();
    }
}
