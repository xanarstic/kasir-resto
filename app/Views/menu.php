<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesin Kasir</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .menu-card img {
            height: 150px;
            object-fit: cover;
        }

        .cart-summary {
            position: sticky;
            top: 10px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .btn-qty {
            width: 30px;
            height: 30px;
            padding: 0;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container mt-4">
        <div class="row">

            <!-- Kategori & Menu -->
            <div class="col-md-8">
                <h2 class="text-center">Mesin Kasir</h2>

                <!-- Button untuk membuka pop-up -->
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMenuModal">Tambah Menu</button>

                <!-- Pop-up Modal untuk Tambah Menu -->
                <div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addMenuModalLabel">Tambah Menu Baru</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addMenuForm" enctype="multipart/form-data">
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
                                        <div class="input-group">
                                            <!-- Dropdown Pilih Kategori -->
                                            <select class="form-select" id="kategori" name="kategori" required>
                                                <option value="">Pilih Kategori</option>
                                                <?php foreach ($kategori as $kat): ?>
                                                    <option value="<?= $kat['kategori'] ?>"><?= ucfirst($kat['kategori']) ?></option>
                                                <?php endforeach; ?>
                                                <option value="new">Kategori Baru</option> <!-- Opsi kategori baru -->
                                            </select>
                                            <!-- Input untuk kategori baru, hanya tampil jika kategori baru dipilih -->
                                            <input type="text" class="form-control" id="kategori-input" name="kategori-input" placeholder="Tulis kategori baru" style="display:none;">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="foto" class="form-label">Foto</label>
                                        <input type="file" class="form-control" id="foto" name="foto" required>
                                    </div>
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Kategori -->
                <div class="mb-3">
                    <label class="form-label">Pilih Kategori:</label>
                    <select class="form-select" id="filter_kategori" onchange="filterMenu()">
                        <option value="">Semua</option>
                        <?php foreach ($kategori as $kat): ?>
                            <option value="<?= $kat['kategori'] ?>" <?= isset($_GET['kategori']) && $_GET['kategori'] == $kat['kategori'] ? 'selected' : '' ?>><?= ucfirst($kat['kategori']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="row" id="menu-list">
                    <?php foreach ($menu as $item): ?>
                        <div class="col-md-4 menu-card" data-kategori="<?= $item['kategori'] ?>">
                            <div class="card mb-3">
                                <img src="<?= base_url('uploads/' . $item['foto']) ?>" class="card-img-top">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?= $item['nama_menu'] ?></h5>
                                    <p class="card-text">Rp <?= number_format($item['harga'], 0, ',', '.') ?></p>
                                    <button class="btn btn-primary btn-add"
                                        data-id="<?= $item['id_menu'] ?>"
                                        data-name="<?= $item['nama_menu'] ?>"
                                        data-price="<?= $item['harga'] ?>">
                                        Tambah
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Keranjang -->
            <div class="col-md-4">
                <div class="cart-summary">
                    <h4>Keranjang</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Menu</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="cart-body"></tbody>
                    </table>

                    <!-- Input Kupon & Member -->
                    <div class="mb-3">
                        <label>Kode Kupon:</label>
                        <input type="text" id="kode_kupon" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Kode Member:</label>
                        <input type="text" id="kode_member" class="form-control">
                    </div>

                    <!-- Total Harga -->
                    <h5>Total Harga: Rp <span id="total_harga">0</span></h5>
                    <h5 class="text-success">Diskon: Rp <span id="diskon">0</span></h5>
                    <h4 class="text-danger">Total Bayar: Rp <span id="total_bayar">0</span></h4>

                    <button class="btn btn-success mt-3 w-100" id="checkout">Bayar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let cart = [];

        $(document).on('click', '.btn-add', function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let price = parseFloat($(this).data('price'));

            let item = cart.find(i => i.id === id);
            if (item) {
                item.qty++;
            } else {
                cart.push({
                    id,
                    name,
                    price,
                    qty: 1
                });
            }
            updateCart();
        });

        $(document).on('click', '.btn-remove', function() {
            let id = $(this).data('id');
            cart = cart.filter(i => i.id !== id);
            updateCart();
        });

        $(document).on('click', '.btn-plus', function() {
            let id = $(this).data('id');
            let item = cart.find(i => i.id === id);
            if (item) item.qty++;
            updateCart();
        });

        $(document).on('click', '.btn-minus', function() {
            let id = $(this).data('id');
            let item = cart.find(i => i.id === id);
            if (item && item.qty > 1) item.qty--;
            updateCart();
        });

        function updateCart() {
            let totalHarga = 0;
            let cartHTML = '';

            cart.forEach(item => {
                let total = item.qty * item.price;
                totalHarga += total;
                cartHTML += `
                <tr>
                    <td>${item.name}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary btn-minus" data-id="${item.id}">-</button>
                        ${item.qty}
                        <button class="btn btn-sm btn-outline-primary btn-plus" data-id="${item.id}">+</button>
                    </td>
                    <td>Rp ${total.toLocaleString('id-ID')}</td>
                    <td><button class="btn btn-danger btn-sm btn-remove" data-id="${item.id}">Hapus</button></td>
                </tr>
            `;
            });

            $('#cart-body').html(cartHTML);
            $('#total_harga').text(totalHarga.toLocaleString('id-ID'));
            hitungDiskon();
        }

        function hitungDiskon() {
            let totalHarga = parseFloat($('#total_harga').text().replace(/\./g, '')) || 0;
            let kodeKupon = $('#kode_kupon').val();
            let kodeMember = $('#kode_member').val();

            $.post("<?= base_url('home/cek_diskon') ?>", {
                kode_kupon: kodeKupon,
                kode_member: kodeMember
            }, function(response) {
                let diskon = response.diskon;
                let totalBayar = totalHarga - diskon;
                $('#diskon').text(diskon.toLocaleString('id-ID'));
                $('#total_bayar').text(totalBayar.toLocaleString('id-ID'));
            }, "json");
        }

        $('#filter_kategori').on('change', function() {
            let kategori = $(this).val();
            $('.menu-card').show();
            if (kategori) $('.menu-card').not(`[data-kategori="${kategori}"]`).hide();
        });

        $('#kode_kupon, #kode_member').on('input', function() {
            hitungDiskon();
        });

        $('#checkout').on('click', function() {
            alert('Pembayaran berhasil!');
        });

        document.getElementById('kategori').addEventListener('change', function() {
            const kategoriInput = document.getElementById('kategori-input');
            if (this.value === 'new') {
                kategoriInput.style.display = 'inline-block'; // Tampilkan input untuk kategori baru
            } else {
                kategoriInput.style.display = 'none'; // Sembunyikan input jika kategori lain dipilih
            }
        });

        // Pastikan untuk memanggil fungsi setelah halaman dimuat agar input kategori baru terlihat saat 'Kategori Baru' dipilih
        document.getElementById('kategori').dispatchEvent(new Event('change'));

        $('#addMenuForm').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: "<?= base_url('home/tambahMenu') ?>", // Pastikan URL diawali dengan home/
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert('Menu berhasil ditambahkan');
                    $('#addMenuModal').modal('hide');
                    location.reload(); // Reload halaman setelah berhasil menambahkan menu
                },
                error: function() {
                    alert('Terjadi kesalahan');
                }
            });
        });
    </script>

</body>

</html>