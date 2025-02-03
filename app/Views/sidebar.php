<!-- Sidebar -->
<div class="sidebar">
    <h4>Menu</h4>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="<?= base_url('home/dashboard') ?>" class="nav-link text-white <?= (uri_string() == 'dashboard') ? 'active' : '' ?>">
                Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('home/menu') ?>" class="nav-link text-white <?= (uri_string() == 'menu') ? 'active' : '' ?>">
                Daftar Menu
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('home/kupon') ?>" class="nav-link text-white <?= (uri_string() == 'kupon') ? 'active' : '' ?>">
                Kupon
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('home/transaksi') ?>" class="nav-link text-white <?= (uri_string() == 'transaksi') ? 'active' : '' ?>">
                Transaksi
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('home/pengaturan') ?>" class="nav-link text-white <?= (uri_string() == 'pengaturan') ? 'active' : '' ?>">
                Pengaturan
            </a>
        </li>
    </ul>
</div>
