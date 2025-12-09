<?php
session_start(); 
include("includes/header.php");
include("validator/user-validator.php");        
include("middleware/clientMiddleware.php");
?>

<div class="mt-24 max-w-[1400px] mx-auto px-4">
    <h2 class="text-3xl font-bold mb-6">Keranjang Belanja</h2>

    <div class="space-y-6" id="mycart">
        <?php
            $items = getCart();                    

            if (count($items) > 0) {                
                foreach ($items as $cart) {
        ?>

        <!-- CART ITEM (100% SAMA DENGAN YANG KAMU PAKAI) -->
        <div class="border-b pb-4 product-data flex items-center justify-between">

            <input type="hidden" class="cartid" value="<?= $cart['cid'] ?>">
            <input type="hidden" class="prodid" value="<?= $cart['id_produk'] ?>">

            <div class="w-16 h-16 flex items-center justify-center">
                <img src="uploads/<?= $cart['gambar'] ?>" 
                     alt="<?= $cart['nama_produk'] ?>" 
                     class="w-full h-full object-contain">
            </div>

            <div class="flex-1 ml-4">
                <h4 class="font-semibold text-gray-800"><?= $cart['nama_produk'] ?></h4>
                <p class="text-sm text-gray-500">Rp <?= number_format($cart['harga_jual'], 0, ',', '.') ?></p>
            </div>

            <div class="flex items-center gap-2">
                <input type="hidden" class="prodid" value="<?= $cart['id_produk'] ?>">
                <button class="decrement_btn px-2 py-1 bg-gray-200 rounded updateQty">-</button>
                <input type="text" class="qty-input w-10 text-center border rounded" value="<?= $cart['prod_qty'] ?>">
                <button class="increment_btn px-2 py-1 bg-gray-200 rounded updateQty">+</button>
            </div>

            <button class="text-red-500 hover:underline deleteItem ml-4" value="<?= $cart['cid'] ?>">
                Remove
            </button>
        </div>

        <!-- END CART ITEM -->

        <?php 
                } 
        ?>

        <div class="flex justify-end pt-6">
            <a href="checkout.php" class="bg-blue-500 text-white px-6 py-3 rounded-xl hover:bg-blue-600 transition">
                Checkout
            </a>
        </div>

        <?php
            } else {
        ?>
        <div class="py-10 text-center text-gray-500 text-xl">
            Keranjang kamu kosong.
        </div>
        <?php } ?>
    </div>
</div>

<?php include("includes/footer.php") ?>