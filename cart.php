<?php
session_start(); 
include("includes/header.php");
include("functions/userFunction.php");
?>

<div class="mt-24 max-w-[1400px] mx-auto px-4 ">
    <h2 class="text-3xl font-bold mb-6">Berbagai Produk.</h2>

    <div class="space-y-4">
        <?php
            $items = getCart();

            foreach ($items as $cart) {
        ?>

        <div class="flex items-center justify-between border-b pb-4 product-data">
            
            <!-- Image -->
            <div class="w-16 h-16 flex items-center justify-center">
                <img src="uploads/<?= $cart['gambar'] ?>" 
                     alt="" 
                     class="w-full h-full object-contain">
            </div>

            <!-- Name -->
            <div class="flex-1 ml-4">
                <h4 class="font-semibold text-gray-800"><?= $cart['nama_produk'] ?></h4>
                <p class="text-sm text-gray-500">Rp <?= number_format($cart['harga_jual']) ?></p>
            </div>

            <!-- Quantity -->
            <div class="flex items-center gap-2">
                <button class="decrement_btn px-2 py-1 bg-gray-200 rounded updateQty">-</button>
                <input 
                    type="text" 
                    class="qty-input w-10 text-center border rounded" 
                    value="<?= $cart['prod_qty'] ?>">
                <button class="increment_btn px-2 py-1 bg-gray-200 rounded updateQty">+</button>
            </div>

            <!-- Remove -->
            <div class="ml-4">
                <button class="text-red-500 hover:underline">Remove</button>
            </div>

        </div>

        <?php } ?>
    </div>
</div>




<?php include("includes/footer.php") ?>
