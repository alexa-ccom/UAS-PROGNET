
<?php include('../middleware/adminMiddleware.php') ?>
<?php include('functions/adminFunctions.php') ?>
<?php include('template/header.php');?>



    <!-- SIDEBAR -->
    <?php include('template/sidebar.php')?>

    <!-- CONTENT -->
    <main class="flex-1 p-8 md:pt-8 pt-24">

      <h3 class="text-xl font-semibold mb-4">Riwayat Order</h3>

        <?php
            $orders = getOrders();

            if (mysqli_num_rows($orders) > 0) {
        ?>

        <div class="space-y-4">

            <?php foreach ($orders as $item) { ?>
                <div class="border rounded-lg p-4 flex justify-between items-center">
                    <div>
                        <p><span class="font-semibold">Order ID:</span> <?= $item['id_order'] ?></p>
                        <p><span class="font-semibold">Nama</span> <?= $item['nama_user'] ?></p>
                        <p><span class="font-semibold">Tracking:</span> <?= $item['no_tracking'] ?></p>
                        <p><span class="font-semibold">Total:</span> Rp <?= number_format($item['total_harga'],0,',','.') ?></p>
                        <p class="text-sm text-gray-500">Tanggal: <?= $item['created_at'] ?></p>
                    </div>

                    <a href="order-details.php?t=<?= $item['no_tracking'] ?>"
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                       View Detail
                    </a>
                </div>
            <?php } ?>

        </div>

        <?php
            } else {
                echo "<p class='text-gray-500'>Belum ada order.</p>";
            }
        ?>
    </main>



  <?php include('template/footer.php')?>

