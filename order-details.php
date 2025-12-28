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

require_once "config/class-payment.php";

$paymentObj = new Payment();
$payment = $paymentObj->getPaymentByOrder($order['id_order']);


if (!$order) {
    ?>
    <div class="min-h-screen flex items-center justify-center px-4 pt-24">
        <div class="text-center max-w-md">
            <svg class="w-20 h-20 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h2 class="text-3xl font-semibold text-gray-900 mb-3 tracking-tight">Order tidak ditemukan</h2>
            <p class="text-lg text-gray-500 mb-8">Nomor tracking tidak valid atau bukan milik Anda.</p>
            <a href="profile.php" class="inline-block px-8 py-3 bg-black text-white text-base font-medium rounded-2xl ">Kembali ke Profile</a>
        </div>
    </div>
    <?php
    include("includes/footer.php");
    exit;
}
?>

<div class="min-h-screen pt-28 pb-20">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="text-center mb-16">
            <p class="text-sm text-gray-400 mb-3 tracking-widest uppercase font-medium">Order Details</p>
            <h1 class="text-4xl sm:text-6xl font-bold text-gray-900 mb-4 tracking-tight">#<?= htmlspecialchars($order['no_tracking']) ?></h1>
            <p class="text-lg text-gray-500"><?= date("d F Y, H:i", strtotime($order['created_at'])) ?></p>
            
            <div class="mt-6">
                <?php if ($order['status'] == 0): ?>
                    <span class="inline-flex items-center px-6 py-2.5 rounded-full text-sm font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                        <i class="ri ri-time-line text-base mr-2"></i>
                        Menunggu Pembayaran
                    </span>

                <?php elseif ($order['status'] == 1): ?>
                    <span class="inline-flex items-center px-6 py-2.5 rounded-full text-sm font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <i class="ri ri-check-double-line text-base mr-2"></i>
                        Pembayaran Terverifikasi
                    </span>

                <?php elseif ($order['status'] == 2): ?>
                    <span class="inline-flex items-center px-6 py-2.5 rounded-full text-sm font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                        <i class="ri ri-truck-line text-base mr-2"></i>
                        Produk Dikirim Menuju Anda
                    </span>

                <?php elseif ($order['status'] == 3): ?>
                    <span class="inline-flex items-center px-6 py-2.5 rounded-full text-sm font-semibold bg-green-50 text-green-700 border border-green-200">
                        <i class="ri ri-checkbox-circle-line text-base mr-2"></i>
                        Terkirim
                    </span>

                <?php elseif ($order['status'] == 4): ?>
                    <span class="inline-flex items-center px-6 py-2.5 rounded-full text-sm font-semibold bg-red-50 text-red-700 border border-red-200">
                        <i class="ri ri-close-circle-line text-base mr-2"></i>
                        Dibatalkan
                    </span>

                <?php endif; ?>
            </div>
        </div>

        <!-- Grid: Informasi Pengiriman & Payment -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            
            <!-- Informasi Pengiriman -->
            <div class="bg-gray-50 rounded-3xl p-10 border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-8 tracking-tight">Informasi Pengiriman</h2>
                
                <div class="space-y-6">
                    <div>
                        <p class="text-sm text-gray-500 font-medium mb-1.5">Nama Penerima</p>
                        <p class="text-base text-gray-900 font-medium"><?= htmlspecialchars($order['nama_user']) ?></p>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-6">
                        <p class="text-sm text-gray-500 font-medium mb-1.5">Email</p>
                        <p class="text-base text-gray-900"><?= htmlspecialchars($order['email']) ?></p>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-6">
                        <p class="text-sm text-gray-500 font-medium mb-1.5">Nomor Telepon</p>
                        <p class="text-base text-gray-900 font-medium"><?= htmlspecialchars($order['no_telp']) ?></p>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-6">
                        <p class="text-sm text-gray-500 font-medium mb-2">Alamat Lengkap</p>
                        <p class="text-base text-gray-900 leading-relaxed">
                            <?= htmlspecialchars($order['alamat_lengkap']) ?><br>
                            <?= htmlspecialchars($order['kota']) ?>, <?= htmlspecialchars($order['provinsi']) ?><br>
                            <?= htmlspecialchars($order['pincode']) ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Bukti Pembayaran / Form Upload -->
            <div class="bg-gray-50 rounded-3xl p-10 border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-8 tracking-tight">Pembayaran</h2>
                

                <?php if (!$payment): ?>
                    <!-- Form Upload Bukti -->
                    <form action="proses/proses-payment.php" method="POST" enctype="multipart/form-data" class="space-y-6 mt-8">
                        <input type="hidden" name="id_order" value="<?= $order['id_order'] ?>">
                        <input type="hidden" name="no_tracking" value="<?= $order['no_tracking'] ?>">

                        <div>
                            <label class="block text-sm text-gray-700 font-medium mb-2">Rekening Pengirim</label>
                            <input type="text" name="rekening" required 
                                   class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-2xl text-base text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>

                        <div>
                            <label class="block text-sm text-gray-700 font-medium mb-2">Bukti Pembayaran</label>
                            <input type="file" name="bukti_pembayaran" required accept="image/*"
                                   class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-2xl text-base text-gray-900 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-gray-900 file:text-white hover:file:bg-gray-700 file:cursor-pointer transition-all">
                        </div>

                        <button type="submit" name="add_payment" 
                                class="w-full bg-gray-900 text-white py-4 rounded-xl font-semibold text-base hover:bg-gray-700 transition-all shadow-sm">
                            Upload Bukti Pembayaran
                        </button>
                    </form>
                <?php else: ?>
                    <!-- Bukti Pembayaran Yang Sudah Ada -->
                    <div class="">
                        <p class="text-sm text-gray-500 font-medium mb-2">Rekening Pengirim</p>
                        <p class="text-lg text-gray-900 font-bold mb-1"><?= htmlspecialchars($payment['rekening']) ?></p>
                        <p class="text-xs text-gray-400 mb-6">
                            Diupload: <?= date('d F Y, H:i', strtotime($payment['created_at'] ?? $order['updated_at'] ?? 'now')) ?>
                        </p>
                        
                        <p class="text-sm text-gray-500 font-medium mb-3">Bukti Transfer</p>
                        <?php 
                        $imagePath = "uploads/payments/" . htmlspecialchars($payment['bukti_pembayaran']);
                        if (!empty($payment['bukti_pembayaran']) && file_exists($imagePath)): 
                        ?>
                            <a href="<?= $imagePath ?>" target="_blank" class="block mb-6">
                                <img src="<?= $imagePath ?>" 
                                     alt="Bukti Pembayaran" 
                                     class="w-full max-w-xs rounded-2xl border-2 border-gray-200 hover:border-gray-300 transition-all shadow-sm"
                                     loading="lazy">
                            </a>
                        <?php else: ?>
                            <div class="bg-red-50 border border-red-200 rounded-2xl p-5 text-center mb-6">
                                <p class="text-red-600 text-sm font-medium">File tidak ditemukan</p>
                            </div>
                        <?php endif; ?>
                        
                        <a href="update-payment.php?id_order=<?= $order['id_order'] ?>" 
                           class="inline-block w-full text-center border-2 border-gray-900 py-3.5 rounded-xl font-semibold text-base bg-gray-900 text-white transition-all">
                            Update Bukti Pembayaran
                        </a>
                    </div>
                <?php endif; ?>
            </div>

        </div>

        <!-- Daftar Produk -->
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 tracking-tight">Produk yang Dibeli</h2>
            
            <div class="space-y-4">
                <?php foreach ($items as $item): ?>
                <div class="bg-white border border-gray-200 rounded-3xl p-6 hover:border-gray-300 transition-all">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                        <img src="uploads/<?= htmlspecialchars($item['gambar']) ?>" 
                             class="w-28 h-28 object-cover rounded-2xl border border-gray-200" 
                             alt="<?= htmlspecialchars($item['nama_produk']) ?>">

                        <div class="flex-1 min-w-0">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 tracking-tight"><?= htmlspecialchars($item['nama_produk']) ?></h3>
                            <p class="text-base text-gray-500">Rp <?= number_format($item['harga'], 0, ',', '.') ?></p>
                            <p class="text-base text-gray-600 mt-1">Qty: <span class="font-semibold"><?= $item['qty'] ?></span></p>
                        </div>

                        <div class="text-right sm:ml-auto">
                            <p class="text-2xl font-bold text-gray-900 tracking-tight">
                                Rp <?= number_format($item['harga'] * $item['qty'], 0, ',', '.') ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Total Harga -->
        <div class="mt-12 text-center mb-12">
            <p class="text-sm text-gray-500 font-medium tracking-wider uppercase mb-2">
                Total Pembayaran
            </p>
            <p class="text-3xl md:text-4xl font-semibold text-gray-900 tracking-tight">
                Rp <?= number_format($order['total_harga'], 0, ',', '.') ?>
            </p>
        </div>

        <!-- Back Button -->
        <div class="text-center">
            <a href="profile.php" 
               class="inline-flex items-center px-10 py-4 bg-gray-900 text-white font-semibold text-base rounded-xl hover:bg-gray-800 transition-all shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Profile
            </a>
        </div>

    </div>
</div>

<?php include("includes/footer.php"); ?>