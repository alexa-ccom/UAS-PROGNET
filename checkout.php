<?php
session_start(); 
include("includes/header.php");
include("functions/userFunction.php");
include("middleware/cartMiddleware.php");
?>

<div class="mt-24 max-w-[1400px] mx-auto px-4 ">
    <h2 class="text-3xl font-bold mb-6">Checkout</h2>

    <form action="functions/placeorder.php" method="POST">
        <div class="space-y-5 mb-2">
            <div>
                <label for="">Name</label>
                <input type="text" name="nama_user" placeholder=" enter your name" required>
            </div>
    
            <div>
                <label for="">email</label>
                <input type="text" name="email" placeholder=" enter your email" required>
            </div>
    
            <div>
                <label for="">phone</label>
                <input type="text" name="no_telp" placeholder="please enter your number" required>
            </div>
    
            <div>
                <label for="">pincode</label>
                <input type="text" name="pincode" placeholder="please enter your pincode" required>
            </div>
    
            <div>
                <label for="">address</label>
                <input type="text" name="alamat" placeholder="please enter your address" required>
            </div>
        </div>
    
        <div class="space-y-6">
                <?php
                    $items = getCart();
                    $totalPrice = 0;
    
                    foreach ($items as $cart) {
                    ?>
    
                    <div class="flex items-center justify-between border-b pb-4 product-data">
    
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
                    </div>
                    
                    
                    <?php 
                    $totalPrice += $cart['harga_jual'] * $cart['prod_qty']; 
                    } 
                    ?>
    
            </div>
                <div class="flex items-center justify-end">
                    <div class="flex flex-col items-end">

                        <h4>Total price: <span>Rp. <?=  number_format($totalPrice, 0,  ',', '.') ?></span></h4>
                        <button type="submit" name="placeOrderBtn" class="bg-blue-200 p-3 ">confirm order</button>
                    </div>
                        
                </div>
    </form>
</div>




<?php include("includes/footer.php") ?>
