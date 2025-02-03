<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kupon</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <h2 class="mb-4">Data Kupon</h2>

        <!-- Tombol Tambah Kupon -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahKupon">Tambah Kupon</button>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID Kupon</th>
                    <th>Kode Kupon</th>
                    <th>Diskon (%)</th>
                    <th>Tanggal Expired</th>
                    <th>QR Code</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kupon as $row) : ?>
                    <tr>
                        <td><?= esc($row['id_kupon']) ?></td>
                        <td><?= esc($row['kode_kupon']) ?></td>
                        <td><?= esc($row['diskon']) ?>%</td>
                        <td><?= esc($row['tanggal_expired']) ?></td>
                        <td>
                            <img src="<?= base_url('upload/qrcode/' . $row['qr_code']) ?>" alt="QR Code" width="100" class="img-thumbnail">
                        </td>
                        <td>
                            <a href="<?= base_url('home/edit/' . $row['id_kupon']) ?>" class="btn btn-warning btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row['id_kupon'] ?>">Hapus</button>
                        </td>
                    </tr>

                    <!-- Modal Konfirmasi Hapus -->
                    <div class="modal fade" id="modalHapus<?= $row['id_kupon'] ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel">Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus kupon <b><?= esc($row['kode_kupon']) ?></b>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <a href="<?= base_url('home/hapus/' . $row['id_kupon']) ?>" class="btn btn-danger">Hapus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal -->

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah Kupon -->
    <div class="modal fade" id="modalTambahKupon" tabindex="-1" aria-labelledby="modalTambahKuponLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahKuponLabel">Tambah Kupon Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('home/simpanKupon') ?>" method="post">
                        <div class="mb-3">
                            <label for="diskon" class="form-label">Diskon (%)</label>
                            <input type="number" class="form-control" id="diskon" name="diskon" required min="1" max="100">
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_expired" class="form-label">Tanggal Expired</label>
                            <input type="date" class="form-control" id="tanggal_expired" name="tanggal_expired" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Kupon</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Tambah Kupon -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>