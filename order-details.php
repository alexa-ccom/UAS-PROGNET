<?php
session_start();
include("includes/header.php");
include("validator/user-validator.php");        
include("middleware/clientMiddleware.php");

if (!isset($_SESSION['auth']) || !isset($_GET['t'])) {
    redirect("index.php", "Akses ditolak.");
}

$tracking_no = $_GET['t'];
$userId      = $_SESSION['auth_user']['id_user'];

$user    = new User();
$order   = $user->getOrderByTracking($tracking_no, $userId);  
$items   = $user->getOrderItemsByTracking($tracking_no, $userId);

if (!$order) {
    ?>
    <div class="mt-24 text-center py-20">
        <h2 class="text-3xl font-bold text-red-600">Order Tidak Ditemukan</h2>
        <p class="mt-4 text-gray-600">Nomor tracking tidak valid atau bukan milik Anda.</p>
        <a href="profile.php" class="mt-6 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg">Kembali ke Profile</a>
    </div>
    <?php
    include("includes/footer.php");
    exit;
}
?>

<div class="mt-24 max-w-[1400px] mx-auto px-4 py-10">

    <div class="flex items-center justify-between mb-8">
        <h2 class="text-4xl font-bold text-gray-800">Detail Pesanan</h2>
        <span class="text-2xl font-bold text-blue-600">#<?= htmlspecialchars($order['no_tracking']) ?></span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- KIRI: INFO CUSTOMER -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-lg p-8 border">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Informasi Pengiriman</h3>
                <div class="space-y-4 text-lg">
                    <p><span class="font-semibold text-gray-600">Nama:</span> <?= htmlspecialchars($order['nama_user']) ?></p>
                    <p><span class="font-semibold text-gray-600">Email:</span> <?= htmlspecialchars($order['email']) ?></p>
                    <p><span class="font-semibold text-gray-600">Telepon:</span> <?= htmlspecialchars($order['no_telp']) ?></p>
                    <p><span class="font-semibold text-gray-600">Alamat:</span><br>
                        <span class="text-gray-700"><?= nl2br(htmlspecialchars($order['alamat'])) ?><br>
                        Kode Pos: <?= $order['pincode'] ?></span>
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-8 border">
                <h3 class="text-xl font-bold mb-4">Status Pembayaran</h3>
                <div class="space-y-3">
                    <p class="text-lg"><span class="font-semibold">Metode:</span> <?= $order['payment_mode'] ?></p>
                    <p class="text-lg">
                        <span class="font-semibold">Status:</span>
                        <?php if ($order['status'] == 0): ?>
                            <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full font-bold">Menunggu Konfirmasi</span>
                        <?php elseif ($order['status'] == 1): ?>
                            <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full font-bold">Selesai</span>
                        <?php elseif ($order['status'] == 2): ?>
                            <span class="px-4 py-2 bg-red-100 text-red-800 rounded-full font-bold">Dibatalkan</span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- KANAN: DAFTAR BARANG + TOTAL -->
        <div class="lg:col-span-2 space-y-8">

            <!-- LIST ITEMS -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border">
                <h3 class="text-2xl font-bold mb-6">Daftar Yang Dibeli</h3>
                <div class="space-y-6">
                    <?php foreach ($items as $item): ?>
                    <div class="flex items-center gap-6 bg-gray-50 p-6 rounded-xl border">
                        <img src="uploads/<?= htmlspecialchars($item['gambar']) ?>" 
                             class="w-24 h-24 object-cover rounded-lg border-2 border-gray-200" 
                             alt="<?= htmlspecialchars($item['nama_produk']) ?>">

                        <div class="flex-1">
                            <h4 class="text-xl font-bold text-gray-800"><?= htmlspecialchars($item['nama_produk']) ?></h4>
                            <p class="text-gray-600 mt-1">Harga: Rp <?= number_format($item['harga'], 0, ',', '.') ?></p>
                            <p class="text-gray-600">Jumlah: <strong><?= $item['qty'] ?></strong></p>
                        </div>

                        <div class="text-right">
                            <p class="text-2xl font-bold text-blue-600">
                                Rp <?= number_format($item['harga'] * $item['qty'], 0, ',', '.') ?>
                            </p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- TOTAL HARGA -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-2xl shadow-lg p-8 text-center">
                <p class="text-2xl font-light">Total Belanja</p>
                <p class="text-5xl font-bold mt-3">
                    Rp <?= number_format($order['total_harga'], 0, ',', '.') ?>
                </p>
                <p class="mt-4 text-lg opacity-90">
                    <?= date("d M Y, H:i", strtotime($order['created_at'])) ?>
                </p>
            </div>

        </div>
    </div>

    <div class="text-center mt-10">
        <a href="profile.php" class="inline-block px-8 py-4 bg-gray-700 text-white font-bold rounded-xl hover:bg-gray-800 transition">
            Kembali ke Profile
        </a>
    </div>
</div>

<?php include("includes/footer.php"); ?>