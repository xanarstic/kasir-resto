<?php

namespace App\Controllers;

use App\Models\MenuModel;
use App\Models\PaketModel;
use App\Models\KuponModel;
use App\Models\memberModel;
use CodeIgniter\Controller;

class Home extends BaseController
{
	public function index()
	{
		echo view('welcome_message');
	}

	public function menu()
	{
		$model = new MenuModel();

		// Ambil kategori unik dari tabel menu
		$data['kategori'] = $model->select('kategori')->distinct()->find();

		// Cek apakah ada kategori yang dipilih di URL atau request
		$kategori_filter = $this->request->getVar('kategori');

		// Jika ada kategori filter, ambil menu yang sesuai
		if ($kategori_filter) {
			$data['menu'] = $model->where('kategori', $kategori_filter)->findAll();
		} else {
			$data['menu'] = $model->findAll(); // Ambil semua menu jika tidak ada filter
		}

		echo view('header');
		echo view('sidebar');
		echo view('menu', $data);
	}

	public function cek_diskon()
	{
		$kuponModel = new KuponModel();
		$memberModel = new MemberModel();

		$kode_kupon = $this->request->getPost('kode_kupon');
		$kode_member = $this->request->getPost('kode_member');

		$diskon = 0;

		// Cek diskon dari kupon
		if (!empty($kode_kupon)) {
			$kupon = $kuponModel->where('nama_kupon', $kode_kupon)->where('tanggal_expired >=', date('Y-m-d'))->first();
			if ($kupon) {
				$diskon += $kupon['diskon'];
			}
		}

		// Cek diskon dari member
		if (!empty($kode_member)) {
			$member = $memberModel->where('id_member', $kode_member)->where('tanggal_expired >=', date('Y-m-d'))->where('status', 'aktif')->first();
			if ($member) {
				$diskon += 10; // Misalnya diskon member 10%
			}
		}

		return $this->response->setJSON(['diskon' => $diskon]);
	}

	public function tambahMenu()
	{
		// Pastikan model sudah didefinisikan sebelum digunakan
		$menuModel = new MenuModel();

		if ($this->request->getMethod() == 'post') {
			$kategori = $this->request->getPost('kategori');

			// Cek jika kategori baru dimasukkan
			if ($kategori == 'new') {
				$kategori_baru = $this->request->getPost('kategori-input'); // Ambil kategori baru yang dimasukkan
				if ($kategori_baru) {
					// Simpan kategori baru ke dalam database
					$menuModel->db->table('kategori')->insert(['kategori' => $kategori_baru]);
					$kategori = $kategori_baru; // Set kategori ke kategori baru yang dimasukkan
				}
			}

			// Menangani upload foto
			$foto = $this->request->getFile('foto');
			if ($foto->isValid() && !$foto->hasMoved()) {
				$fotoName = $foto->getRandomName();
				$foto->move(WRITEPATH . 'uploads/menu', $fotoName);
			} else {
				$fotoName = 'default.jpg'; // Default image if no file is uploaded
			}

			// Menyimpan data menu
			$data = [
				'nama_menu'  => $this->request->getPost('nama_menu'),
				'harga'      => $this->request->getPost('harga'),
				'kategori'   => $kategori, // Gunakan kategori yang sudah dipilih atau kategori baru
				'deskripsi'  => $this->request->getPost('deskripsi'),
				'foto'       => $fotoName,
				'created_at' => date('Y-m-d H:i:s')
			];

			$menuModel->insert($data); // Gunakan insert untuk menambahkan data baru
			return redirect()->to('home/menu')->with('success', 'Menu berhasil ditambahkan');
		}

		// Ambil kategori unik dari tabel menu
		$kategori = $menuModel->select('kategori')->distinct()->find();

		return view('menu', ['kategori' => $kategori]);
	}
}
