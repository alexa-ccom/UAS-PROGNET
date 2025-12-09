<?php include('../middleware/adminMiddleware.php') ?>
<?php include('template/header.php');?>
<?php include('functions/adminFunctions.php') ?>




    <!-- SIDEBAR -->
    <?php include('template/sidebar.php')?>

    <!-- CONTENT -->
    <main class="flex-1 p-8 md:pt-8 pt-24">

    <h4 class="text-2xl font-bold text-[#3C3F58] mb-6">Categories</h4>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        
        <!-- WRAPPER AGAR RESPONSIVE -->
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 font-semibold text-gray-700">ID</th>
                        <th class="px-6 py-3 font-semibold text-gray-700">Name</th>
                        <th class="px-6 py-3 font-semibold text-gray-700">Image</th>
                        <th class="px-6 py-3 font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-3 font-semibold text-gray-700">Edit</th>
                        <th class="px-6 py-3 font-semibold text-gray-700">Delete</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $category = getAll("tb_kategori");

                        if(mysqli_num_rows($category) > 0){
                            foreach ($category as $item) {
                    ?>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-4"><?= $item['id_kategori']; ?></td>
                            <td class="px-6 py-4 font-medium"><?= $item['nama_kategori']; ?></td>
                            
                            <td class="px-6 py-4">
                                <img 
                                    src="../uploads/<?= $item['gambar']; ?>" 
                                    alt="<?= $item['nama_kategori']; ?>" 
                                    class="h-12 w-12 object-cover rounded-md shadow-sm"
                                >
                            </td>

                            <td class="px-6 py-4">
                                <?php if($item['status'] == '0'): ?>
                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-xs rounded-full">
                                        Visible
                                    </span>
                                <?php else: ?>
                                    <span class="px-3 py-1 bg-red-100 text-red-700 text-xs rounded-full">
                                        Hidden
                                    </span>
                                <?php endif; ?>
                            </td>

                            <td class="px-6 py-4">
                                <a 
                                  href="edit-category.php?id=<?= $item['id_kategori']; ?>" 
                                  class="text-blue-600 hover:underline font-medium"
                                >
                                    Edit
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <form action="code.php" method="POST">
                                    <input type="hidden" name="category_id" value="<?= $item['id_kategori']; ?>">
                                    <button type="submit" class="text-red-600 hover:underline font-medium" name="delete_category_btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center py-6 text-gray-500'>No records found</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</main>




  <?php include('template/footer.php')?>
