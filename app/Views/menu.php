<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu & Paket</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .not-available {
            opacity: 0.5;
            /* Mengurangi opacity untuk item yang tidak tersedia */
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center">Daftar Menu</h2>
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahMenuModal">
            Tambah Menu
        </button>
        <div class="row">
            <?php
            // Menampilkan menu yang tersedia
            foreach ($menus as $menu) :
                if ($menu['status'] === 'tersedia') : ?>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="<?= base_url('upload/menu/' . esc($menu['foto'])) ?>" class="card-img-top" alt="<?= esc($menu['nama_menu']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($menu['nama_menu']) ?></h5>
                                <p class="card-text">Harga: Rp<?= number_format($menu['harga'], 0, ',', '.') ?></p>
                                <p class="card-text"><?= esc($menu['deskripsi']) ?></p>
                                <p class="card-text">Status: <?= esc($menu['status']) ?></p>
                                <a href="/home/changeStatusMenu/<?= $menu['id_menu'] ?>" class="btn btn-warning">
                                    <?= $menu['status'] === 'tersedia' ? 'Ubah Menjadi Tidak Tersedia' : 'Ubah Menjadi Tersedia' ?>
                                </a>
                                <a href="/home/deleteMenu/<?= $menu['id_menu'] ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?');">Delete</a>
                            </div>
                        </div>
                    </div>
            <?php endif;
            endforeach; ?>

            <?php
            // Menampilkan menu yang tidak tersedia
            foreach ($menus as $menu) :
                if ($menu['status'] === 'tidak tersedia') : ?>
                    <div class="col-md-4 mb-3 not-available">
                        <div class="card">
                            <img src="<?= base_url('upload/menu/' . esc($menu['foto'])) ?>" class="card-img-top" alt="<?= esc($menu['nama_menu']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($menu['nama_menu']) ?></h5>
                                <p class="card-text">Harga: Rp<?= number_format($menu['harga'], 0, ',', '.') ?></p>
                                <p class="card-text"><?= esc($menu['deskripsi']) ?></p>
                                <p class="card-text">Status: <?= esc($menu['status']) ?></p>
                                <a href="/home/changeStatusMenu/<?= $menu['id_menu'] ?>" class="btn btn-warning">
                                    <?= $menu['status'] === 'tersedia' ? 'Ubah Menjadi Tidak Tersedia' : 'Ubah Menjadi Tersedia' ?>
                                </a>
                                <a href="/home/deleteMenu/<?= $menu['id_menu'] ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?');">Delete</a>
                            </div>
                        </div>
                    </div>
            <?php endif;
            endforeach; ?>
        </div>

        <h2 class="text-center mt-4">Daftar Paket</h2>
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahPaketModal">
            Tambah Paket
        </button>
        <div class="row">
            <?php
            // Menampilkan paket yang tersedia
            foreach ($pakets as $paket) :
                if ($paket['status'] === 'tersedia') : ?>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="<?= base_url('upload/paket/' . esc($paket['foto'])) ?>" class="card-img-top" alt="<?= esc($paket['nama_paket']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($paket['nama_paket']) ?></h5>
                                <p class="card-text">Harga: Rp<?= number_format($paket['harga'], 0, ',', '.') ?></p>
                                <p class="card-text"><?= esc($paket['deskripsi']) ?></p>
                                <p class="card-text">Status: <?= esc($paket['status']) ?></p>
                                <a href="/home/changeStatusPaket/<?= $paket['id_paket'] ?>" class="btn btn-warning">
                                    <?= $paket['status'] === 'tersedia' ? 'Ubah Menjadi Tidak Tersedia' : 'Ubah Menjadi Tersedia' ?>
                                </a>
                                <a href="/home/deletePaket/<?= $paket['id_paket'] ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus paket ini?');">Delete</a>
                            </div>
                        </div>
                    </div>
            <?php endif;
            endforeach; ?>

            <?php
            // Menampilkan paket yang tidak tersedia
            foreach ($pakets as $paket) :
                if ($paket['status'] === 'tidak tersedia') : ?>
                    <div class="col-md-4 mb-3 not-available">
                        <div class="card">
                            <img src="<?= base_url('upload/paket/' . esc($paket['foto'])) ?>" class="card-img-top" alt="<?= esc($paket['nama_paket']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($paket['nama_paket']) ?></h5>
                                <p class="card-text">Harga: Rp<?= number_format($paket['harga'], 0, ',', '.') ?></p>
                                <p class="card-text"><?= esc($paket['deskripsi']) ?></p>
                                <p class="card-text">Status: <?= esc($paket['status']) ?></p>
                                <a href="/home/changeStatusPaket/<?= $paket['id_paket'] ?>" class="btn btn-warning">
                                    <?= $paket['status'] === 'tersedia' ? 'Ubah Menjadi Tidak Tersedia' : 'Ubah Menjadi Tersedia' ?>
                                </a>
                                <a href="/home/deletePaket/<?= $paket['id_paket'] ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus paket ini?');">Delete</a>
                            </div>
                        </div>
                    </div>
            <?php endif;
            endforeach; ?>
        </div>
    </div>

    <!-- Modal Tambah Menu -->
    <div class="modal fade" id="tambahMenuModal" tabindex="-1" aria-labelledby="tambahMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahMenuModalLabel">Tambah Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/home/tambahMenu" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama_menu" class="form-label">Nama Menu</label>
                            <input type="text" class="form-control" id="nama_menu" name="nama_menu" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" required>
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <input type="text" class="form-control" id="kategori" name="kategori" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Paket -->
    <div class="modal fade" id="tambahPaketModal" tabindex="-1" aria-labelledby="tambahPaketModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPaketModalLabel">Tambah Paket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/home/tambahPaket" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama_paket" class="form-label">Nama Paket</label>
                            <input type="text" class="form-control" id="nama_paket" name="nama_paket" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>