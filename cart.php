<?php
session_start(); 
include("includes/header.php");
include("functions/userFunction.php");
include("middleware/cartMiddleware.php");
?>

<div class="mt-24 max-w-[1400px] mx-auto px-4 ">
    <h2 class="text-3xl font-bold mb-6">Berbagai Produk.</h2>

    <div class="space-y-6">
        <div id="mycart">
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
                        <p class="text-sm text-gray-500">Rp <?= number_format($cart['harga_jual'], 0,  ',', '.') ?></p>
                    </div>

                    <!-- Quantity -->
                    <div class="flex items-center gap-2">
                        <input type="hidden" class="prodid" value="<?= $cart['id_produk'] ?>">
                        <button class="decrement_btn px-2 py-1 bg-gray-200 rounded updateQty">-</button>
                        <input 
                            type="text" 
                            class="qty-input w-10 text-center border rounded" 
                            value="<?= $cart['prod_qty'] ?>">
                        <button class="increment_btn px-2 py-1 bg-gray-200 rounded updateQty">+</button>
                    </div>

                    <!-- Remove -->
                    <div class="ml-4">
                        <button class="text-red-500 hover:underline deleteItem" value="<?= $cart['cid'] ?>">Remove</button>
                    </div>

                </div>
                
                
                <?php 
                } 
                ?>
        </div>
        <div class="flex items-center justify-end">
            <div>
                <a href="checkout.php" class="bg-blue-300 p-3 rounded-xl  mt-10">Checkout</a>
            </div>
        </div>
    </div>
</div>




<?php include("includes/footer.php") ?>
