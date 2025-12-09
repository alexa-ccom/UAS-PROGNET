<?php
session_start();
include("includes/header.php");
include("validator/user-validator.php");          
include("middleware/clientMiddleware.php");


if (!isset($_SESSION['auth'])) {
    header('Location: ../login.php');
    exit;
}

$userId = $_SESSION['auth_user']['id_user'];

$profile = getProfile();        
$orders  = getOrders();         
?>

<div class="mt-24 max-w-[1400px] mx-auto px-4 space-y-10 py-8">

    <!-- Title -->
    <h2 class="text-4xl font-bold text-gray-800">Profile Saya</h2>

    <!-- PROFILE CARD -->
    <div class="bg-white rounded-2xl shadow-lg p-8">
        <h3 class="text-2xl font-bold text-blue-600 mb-6">Informasi Akun</h3>

        <?php if ($profile): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-lg">
                <p><span class="font-semibold text-gray-600">Nama:</span> <?= $profile['nama_user'] ?></p>
                <p><span class="font-semibold text-gray-600">Email:</span> <?= $profile['email'] ?></p>
                <p><span class="font-semibold text-gray-600">No Telp:</span> <?= $profile['no_telp'] ?></p>
                <p><span class="font-semibold text-gray-600">Bergabung:</span> <?= date("d M Y", strtotime($profile['created_at'] ?? 'now')) ?></p>
            </div>
        <?php else: ?>
            <p class="text-gray-500">Data profil tidak ditemukan.</p>
        <?php endif; ?>
    </div>

    <!-- ORDER HISTORY -->
    <div class="bg-white rounded-2xl shadow-lg p-8">
        <h3 class="text-2xl font-bold text-blue-600 mb-6">Riwayat Pesanan</h3>

        <?php if (!empty($orders)): ?>
            <div class="space-y-4">
                <?php foreach ($orders as $order): ?>
                    <div class="border border-gray-200 rounded-xl p-6 hover:shadow-md transition">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                            <div class="space-y-2">
                                <p class="text-lg font-semibold">#<?= $order['no_tracking'] ?></p>
                                <p class="text-gray-600">Tanggal: <?= date("d M Y, H:i", strtotime($order['created_at'])) ?></p>
                                <p class="text-xl font-bold text-blue-600">
                                    Rp <?= number_format($order['total_harga'], 0,',','.') ?>
                                </p>
                                <span class="inline-block px-3 py-1 text-sm font-medium rounded-full 
                                    <?= $order['status'] == 0 ? 'bg-yellow-100 text-yellow-800' : 
                                       ($order['status'] == 1 ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') ?>">
                                    <?= $order['status'] == 0 ? 'Menunggu Pembayaran' : 
                                       ($order['status'] == 1 ? 'Diproses' : 'Selesai') ?>
                                </span>
                            </div>

                            <a href="order-details.php?t=<?= urlencode($order['no_tracking']) ?>"
                               class="inline-block px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-xl hover:from-blue-700 hover:to-blue-800 transition transform hover:scale-105">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <p class="text-xl text-gray-500">Belum ada pesanan.</p>
                <a href="index.php" class="mt-4 inline-block text-blue-600 hover:underline">Mulai Belanja</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include("includes/footer.php"); ?>