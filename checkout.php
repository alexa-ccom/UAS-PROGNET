<?php
session_start();
include("includes/header.php");
include("validator/user-validator.php");        
include("middleware/clientMiddleware.php");
require_once "config/class-address.php";

$user_id = $_SESSION['auth_user']['id_user'];

$addressObj = new Address();
$addresses  = $addressObj->getAddressByUser($user_id);

$items = getCart();
$totalPrice = 0;

foreach ($items as $citem) {
    $totalPrice += $citem['harga_jual'] * $citem['prod_qty'];
}
?>

<div class="mt-24 max-w-[1400px] mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold mb-8 text-center">Checkout</h2>

    <?php if(empty($items)): ?>
        <div class="text-center py-20 text-xl text-gray-600">
            Keranjang kosong. <a href="index.php" class="text-blue-600 underline">Belanja dulu</a>
        </div>
    <?php else: ?>

    <form action="proses/proses-order.php" method="POST" class="grid grid-cols-1 lg:grid-cols-2 gap-10 max-w-6xl mx-auto">

        <!-- KIRI: FORM -->
        <div class="bg-white p-8 rounded-xl shadow">
            <h3 class="text-2xl font-bold mb-6">Data Pengiriman</h3>
            <div class="space-y-4">

                <input type="text" name="nama_user" placeholder="Nama Lengkap"
                    class="w-full p-3 border rounded-lg" required>

                <input type="email" name="email" placeholder="Email"
                    class="w-full p-3 border rounded-lg" required>

                <input type="text" name="no_telp" placeholder="No Telepon"
                    class="w-full p-3 border rounded-lg" required>

                <input type="text" name="pincode" placeholder="Kode Pos"
                    class="w-full p-3 border rounded-lg" required>

                <!-- ALAMAT -->

                <div class="flex flex-col gap-1">
                    <label class="font-medium text-gray-700">Pilih Alamat</label>

                    <select name="alamat" required
                        class="border border-gray-300 rounded-lg px-3 py-2 bg-white">

                        <option value="">-- Pilih Alamat --</option>

                        <?php if (!empty($addresses)): ?>
                            <?php foreach ($addresses as $addr): ?>
                                <option value="<?= $addr['id_alamat'] ?>">
                                    <?= $addr['alamat'] ?>, <?= $addr['kota'] ?>, <?= $addr['provinsi'] ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option disabled>Belum ada alamat</option>
                        <?php endif; ?>

                    </select>

                    <a href="add-address.php" class="text-sm text-blue-600 mt-2">
                        + Tambah alamat baru
                    </a>
                </div>


            </div>

        </div>

        <!-- KANAN: RINGKASAN -->
        <div class="bg-white p-8 rounded-xl shadow">
            <h3 class="text-2xl font-bold mb-6">Pesanan Anda</h3>
            
            <div class="space-y-4 max-h-96 overflow-y-auto">
                <?php foreach($items as $citem): ?>
                <div class="flex justify-between items-center border-b pb-3">
                    <div class="flex items-center gap-4">
                        <img src="uploads/<?= $citem['gambar'] ?>" class="w-16 h-16 object-contain rounded">
                        <div>
                            <p class="font-medium"><?= $citem['nama_produk'] ?></p>
                            <p class="text-sm text-gray-500"><?= $citem['prod_qty'] ?> × Rp <?= number_format($citem['harga_jual'],0,',','.') ?></p>
                        </div>
                    </div>
                    <p class="font-bold">Rp <?= number_format($citem['harga_jual'] * $citem['prod_qty'],0,',','.') ?></p>
                </div>
                <?php endforeach; ?>
            </div>

           

            <div class="border-t-4 border-blue-600 mt-6 pt-6">
                <div class="flex justify-between text-2xl font-bold">
                    <span>Total</span>
                    <span>Rp <?= number_format($totalPrice,0,',','.') ?></span>
                </div>
            </div>

            <input type="hidden" name="total_price" value="<?= $totalPrice ?>">
            <input type="hidden" name="payment_mode" value="COD">

            <button type="submit" name="placeOrderBtn" 
                class="w-full mt-8 bg-blue-600 text-white py-4 rounded-xl text-xl font-bold hover:bg-blue-700 transition">
                Konfirmasi Pesanan
            </button>
        </div>
    </form>

    <?php endif; ?>
</div>

<?php include("includes/footer.php"); ?>