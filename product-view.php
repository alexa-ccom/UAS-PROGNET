<?php
session_start(); 
include("includes/header.php");
include("config/class-user.php");

$user = new User();

if (isset($_GET['product'])) {
    
    $product_slug = $_GET['product'];
    $product = $user->getSlugActive("tb_produk", $product_slug);

    if ($product) {
?>
        <div class="mt-24 max-w-[1400px] mx-auto px-4 pb-12">
            <div class="grid md:grid-cols-2 gap-8 product-data">

                <!-- Left Side -->
                <div class="space-y-4">
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

                    <div class="flex gap-3">
                        <div class="w-20 h-20 bg-gray-50 rounded-lg border-2 border-gray-300 p-2">
                            <img 
                                src="uploads/<?= $product['gambar'] ?>" 
                                class="w-full h-full object-contain"
                            >
                        </div>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="space-y-4">

                    <h1 class="text-4xl font-bold text-gray-900 mb-3">
                        <?= $product['nama_produk'] ?>
                    </h1>

                    <p class="text-gray-600 text-base leading-relaxed">
                        <?= $product['headline'] ?>
                    </p>

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

                    <div class="flex items-center gap-2">
                        <button class="decrement_btn bg-gray-200 px-3 py-1 rounded">-</button>
                        <input type="text" class="qty-input w-12 text-center border border-gray-300 rounded" value="1">
                        <button class="increment_btn bg-gray-200 px-3 py-1 rounded">+</button>
                    </div>

                    <div class="space-y-3">
                        <button class="w-full bg-gray-900 hover:bg-gray-800 text-white font-semibold py-4 px-6 rounded-lg transition add-to-cart" value="<?= $product['id_produk'] ?>">
                            Add to Cart
                        </button>
                        <button class="w-full bg-white hover:bg-gray-50 text-gray-900 font-semibold py-4 px-6 rounded-lg border-2 border-gray-900 transition">
                            Add to Wishlist
                        </button>
                    </div>

                    <div class="space-y-3 pt-4 border-t">
                        <div class="flex items-start gap-3 text-gray-700">
                            <span class="text-xl">📦</span> Free shipping worldwide
                        </div>
                        <div class="flex items-start gap-3 text-gray-700">
                            <span class="text-xl">🔒</span> 100% Secured Payment
                        </div>
                        <div class="flex items-start gap-3 text-gray-700">
                            <span class="text-xl">👤</span> Trusted by top brands
                        </div>
                    </div>

                </div>
            </div>

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
        echo "<div class='mt-20 max-w-[1400px] mx-auto px-4'>Product not found</div>";
    }

} else {
    echo "<div class='mt-20 max-w-[1400px] mx-auto px-4'>Invalid request</div>";
}

include("includes/footer.php");
?>
