<?php

session_start(); 
include("includes/header.php");
include("functions/userFunction.php");

if (isset($_GET['product'])) {
    
    $product_slug = $_GET['product'];
    $product_data = getSlugActive("tb_produk", $product_slug);
    $product = mysqli_fetch_array($product_data);

    if ($product) {
        ?>
        <div class="mt-24 max-w-[1400px] mx-auto px-4 pb-12">
            <div class="grid md:grid-cols-2 gap-8">
                
                <!-- Left Side - Product Image -->
                <div class="space-y-4">
                    <!-- Main Image -->
                    <div class="bg-gray-50 rounded-lg p-8 relative">
                        <img 
                            src="uploads/<?= $product['gambar'] ?>" 
                            alt="<?= $product['nama_produk'] ?>"
                            class="w-full h-auto object-contain"
                        >
                        <?php if($product['popularitas']){ ?>
                            <span class="absolute top-4 right-4 bg-red-400 text-white px-3 py-1.5 rounded-md text-sm font-semibold">
                                Trending
                            </span>
                        <?php } ?>
                    </div>
                    
                    <!-- Thumbnail (optional - bisa ditambahkan nanti) -->
                    <div class="flex gap-3">
                        <div class="w-20 h-20 bg-gray-50 rounded-lg border-2 border-gray-300 p-2">
                            <img 
                                src="uploads/<?= $product['gambar'] ?>" 
                                alt="Thumbnail"
                                class="w-full h-full object-contain"
                            >
                        </div>
                    </div>
                </div>

                <!-- Right Side - Product Details -->
                <div class="space-y-4">
                    
                    <!-- Product Name -->
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900 mb-3">
                            <?= $product['nama_produk'] ?>
                        </h1>

                        <!-- Headline -->
                        <p class="text-gray-600 text-base leading-relaxed">
                            <?= $product['headline'] ?>
                        </p>

                    </div>

                    <!-- Price Section -->
                    <div class="flex items-center gap-4">
                        <span class="text-4xl font-bold text-gray-900">
                            Rp. <?= number_format($product['harga_jual'], 0,  ',', '.') ?>
                        </span>
                        <?php if($product['harga_asli'] > $product['harga_jual']){ ?>
                            <span class="text-2xl text-gray-400 line-through">
                                Rp. <?= number_format($product['harga_asli'], 0, ',', '.') ?>
                            </span>
                        <?php } ?>
                    </div>

                    <div class="flex items-center gap-2 text-sm text-gray-600">
                            <span class="inline-block w-5 h-5">🏷️</span>
                            <span>Save 6% right now</span>
                    </div>

                    <div>
                        <span>-</span>
                        <input type="text">
                        <span>+</span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button class="w-full bg-gray-900 hover:bg-gray-800 text-white font-semibold py-4 px-6 rounded-lg transition">
                            Add to Cart
                        </button>
                        <button class="w-full bg-white hover:bg-gray-50 text-gray-900 font-semibold py-4 px-6 rounded-lg border-2 border-gray-900 transition">
                            Add to Wishlist
                        </button>
                    </div>

                    <!-- Features/Benefits -->
                    <div class="space-y-3 pt-4 border-t">
                        <div class="flex items-start gap-3 text-gray-700">
                            <span class="text-xl">📦</span>
                            <span>Free shipping worldwide</span>
                        </div>
                        <div class="flex items-start gap-3 text-gray-700">
                            <span class="text-xl">🔒</span>
                            <span>100% Secured Payment</span>
                        </div>
                        <div class="flex items-start gap-3 text-gray-700">
                            <span class="text-xl">👤</span>
                            <span>Trusted by top brands</span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Description & Reviews Tabs -->
            <div class="mt-12 border-t">
                <div class="flex gap-8 border-b">
                    <button class="px-4 py-4 font-semibold text-gray-900 border-b-2 border-gray-900">
                        Description
                    </button>
                </div>
                
                <div class="py-8">
                    <p class="text-gray-700 leading-relaxed">
                        <?= nl2br($product['deskripsi']) ?>
                    </p>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo "<div class='mt-20 max-w-[1400px] mx-auto px-4'>";
        echo "Something went wrong";

    }

} else {
    echo "<div class='mt-20 max-w-[1400px] mx-auto px-4'>";
    echo "Something went wrong";

}

include("includes/footer.php");
?>