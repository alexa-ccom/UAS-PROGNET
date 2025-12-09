<?php
session_start(); 
include("includes/header.php");
include("config/class-user.php");

$user = new User();
?>

<div class="mt-24 max-w-[1400px] mx-auto px-4">
    <h2 class="text-3xl font-bold text-start mb-6">Berbagai Produk.</h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-8 text-center">
        <?php

            $categories = $user->getAllActive('tb_kategori');

            if (!empty($categories)) {
                foreach ($categories as $item) {
        ?>
            <a href="products.php?category=<?= $item['slug'] ?>">
                <div class="flex flex-col items-center justify-center">
                    <img 
                        src="uploads/<?= $item['gambar'] ?>" 
                        alt="<?= $item['nama_kategori'] ?>" 
                        class="w-24 h-24 object-contain mb-3"
                    >
    
                    <h4 class="font-semibold text-gray-900 text-sm">
                        <?= $item['nama_kategori'] ?>
                    </h4>
    
                    <p class="text-gray-500 text-sm">
                        <?= $item['deskripsi'] ?>
                    </p>
                </div>
            </a>
        <?php
                }
            } else {
                echo "<p class='text-gray-600 col-span-6 text-center'>No data available</p>";
            }
        ?>
    </div>

    <h2 class="text-3xl font-bold text-start mb-6">Trending</h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-8 text-center">
        <?php

            $trending = $user->getTrending();

            if (!empty($trending)) {
                foreach ($trending as $item) {
        ?>
            <a href="product-view.php?product=<?= $item['slug'] ?>">
                <div class="flex flex-col items-center justify-center">
                    <img 
                        src="uploads/<?= $item['gambar'] ?>" 
                        alt="<?= $item['nama_produk'] ?>" 
                        class="w-24 h-24 object-contain mb-3"
                    >
    
                    <h4 class="font-semibold text-gray-900 text-sm">
                        <?= $item['nama_produk'] ?>
                    </h4>
    
                    <p class="text-gray-500 text-sm">
                        <?= $item['headline'] ?>
                    </p>
                </div>
            </a>
        <?php
                }
            } else {
                echo "<p class='text-gray-600 col-span-6 text-center'>No data available</p>";
            }
        ?>
    </div>
</div>



<?php include("includes/footer.php") ?>