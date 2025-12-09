<?php

session_start(); 
include("includes/header.php");
include("config/class-user.php"); 

$user = new User();

if (isset($_GET['category'])) {
    $category_slug = $_GET['category'];

    // Ambil data kategori pakai class
    $category = $user->getSlugActive("tb_kategori", $category_slug);

    if ($category) {
        $cid = $category['id_kategori'];
        ?>

        <div class="mt-24 max-w-[1400px] mx-auto px-4">
            <h2 class="text-3xl font-bold text-start mb-6"><?= $category['nama_kategori'] ?></h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-8 text-center">
                <?php
                
                    // Ambil product by category
                    $products = $user->getProductByCategory($cid);

                    if (!empty($products)) {
                        foreach ($products as $item) {
                ?>
                    <a href="product-view.php?product=<?= $item['slug'] ?>">
                        <div class="group bg-white p-4 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 
                                    flex flex-col items-center justify-center border border-gray-100 hover:border-gray-200">

                            <div class="w-24 h-24 mb-3 flex items-center justify-center">
                                <img 
                                    src="uploads/<?= $item['gambar'] ?>" 
                                    alt="<?= $item['nama_produk'] ?>" 
                                    class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-105"
                                >
                            </div>

                            <h4 class="font-semibold text-gray-900 text-sm group-hover:text-black">
                                <?= $item['nama_produk'] ?>
                            </h4>

                            <p class="text-gray-500 text-xs mt-1">
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
