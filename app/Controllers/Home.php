<?php

namespace App\Controllers;

use App\Models\MenuModel;
use App\Models\PaketModel;
use App\Models\KuponModel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use CodeIgniter\Controller;

class Home extends BaseController
{
	public function index()
	{
		echo view('welcome_message');
	}

	public function menu()
	{
		$menuModel = new MenuModel();
		$paketModel = new PaketModel();

		$data = [
			'menus' => $menuModel->getMenus(),
			'pakets' => $paketModel->getPaketMenus()
		];

		echo view('header');
		echo view('sidebar');
		echo view('menu', $data);
	}

	public function tambahMenu()
	{
		$menuModel = new MenuModel();

		$data = [
			'nama_menu' => $this->request->getPost('nama_menu'),
			'harga' => $this->request->getPost('harga'),
			'kategori' => $this->request->getPost('kategori'),
			'deskripsi' => $this->request->getPost('deskripsi'),
			'status' => 'tersedia',
			'created_at' => date('Y-m-d H:i:s'),
			'foto' => $this->request->getFile('foto')->getName()
		];

		// Pindahkan file ke folder public/upload/menu
		$this->request->getFile('foto')->move(WRITEPATH . '../public/upload/menu');

		$menuModel->insert($data);

		return redirect()->to('home/menu');
	}

	public function tambahPaket()
	{
		$paketModel = new PaketModel();

		$data = [
			'nama_paket' => $this->request->getPost('nama_paket'),
			'harga' => $this->request->getPost('harga'),
			'deskripsi' => $this->request->getPost('deskripsi'),
			'status' => 'tersedia',
			'created_at' => date('Y-m-d H:i:s'),
			'foto' => $this->request->getFile('foto')->getName()
		];

		// Pindahkan file ke folder public/upload/paket
		$this->request->getFile('foto')->move(WRITEPATH . '../public/upload/paket');

		$paketModel->insert($data);

		return redirect()->to('home/menu');
	}

	public function changeStatusMenu($id)
	{
		$menuModel = new MenuModel();
		$menu = $menuModel->find($id);

		if ($menu) {
			$newStatus = ($menu['status'] === 'tersedia') ? 'tidak tersedia' : 'tersedia';
			$menuModel->update($id, ['status' => $newStatus]);
		}

		return redirect()->to('home/menu');
	}

	public function changeStatusPaket($id)
	{
		$paketModel = new PaketModel();
		$paket = $paketModel->find($id);

		if ($paket) {
			$newStatus = ($paket['status'] === 'tersedia') ? 'tidak tersedia' : 'tersedia';
			$paketModel->update($id, ['status' => $newStatus]);
		}

		return redirect()->to('home/menu');
	}

	public function deleteMenu($id)
	{
		$menuModel = new MenuModel();
		$menu = $menuModel->find($id);

		if ($menu) {
			// Hapus file foto jika diperlukan
			$filePath = WRITEPATH . '../public/upload/menu/' . $menu['foto'];
			if (file_exists($filePath) && !is_dir($filePath)) { // Pastikan ini adalah file, bukan direktori
				unlink($filePath);
			}

			$menuModel->delete($id);
		}

		return redirect()->to('home/menu');
	}

	public function deletePaket($id)
	{
		$paketModel = new PaketModel();
		$paket = $paketModel->find($id);

		if ($paket) {
			// Hapus file foto jika diperlukan
			$filePath = WRITEPATH . '../public/upload/paket/' . $paket['foto'];
			if (file_exists($filePath) && !is_dir($filePath)) { // Pastikan ini adalah file, bukan direktori
				unlink($filePath);
			}

			$paketModel->delete($id);
		}

		return redirect()->to('home/menu');
	}

	public function kupon()
	{
		$kuponModel = new KuponModel();
		$kuponModel->deleteExpiredKupon(); // Hapus kupon yang kadaluarsa
		$data['kupon'] = $kuponModel->findAll();

		echo view('header');
		echo view('sidebar');
		echo view('kupon', $data);
	}

	public function hapus($id_kupon)
	{
		$kuponModel = new KuponModel();
		$kupon = $kuponModel->find($id_kupon);

		// Hapus QR Code file jika ada
		if ($kupon) {
			$qrPath = FCPATH . 'upload/qrcode/' . $kupon['qr_code'];
			if (file_exists($qrPath)) {
				unlink($qrPath); // Menghapus file QR Code
			}

			// Hapus data kupon dari database
			$kuponModel->delete($id_kupon);

			return redirect()->to(base_url('home/kupon'))->with('success', 'Kupon berhasil dihapus!');
		}

		return redirect()->to(base_url('home/kupon'))->with('error', 'Kupon tidak ditemukan!');
	}
}
