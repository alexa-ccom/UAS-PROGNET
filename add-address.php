<?php
session_start();
include("includes/header.php");
require_once "config/class-address.php";
include("middleware/clientMiddleware.php");


$user_id = $_SESSION['auth_user']['id_user'];
$address = new Address();
$addresses = $address->getAddressByUser($user_id);
?>

<div class="max-w-[700px] mx-auto mt-24 px-4">

    <h2 class="text-2xl font-bold mb-4">Alamat Saya</h2>

    <?php if ($addresses->num_rows > 0): ?>
        <div class="space-y-3 mb-8">
            <?php while ($row = $addresses->fetch_assoc()): ?>
                <div class="flex justify-between items-center bg-white p-4 rounded-lg border">

                    <div>
                        <p class="font-medium"><?= $row['alamat'] ?></p>
                        <p class="text-sm text-gray-500">
                            <?= $row['kota'] ?>, <?= $row['provinsi'] ?>
                        </p>
                    </div>

                    <form action="proses/proses-address.php" method="POST">
                        <input type="hidden" name="alamat_id" value="<?= $row['id_alamat'] ?>">
                        <button 
                            name="delete_address"
                            class="text-red-500 text-sm hover:underline">
                            Delete
                        </button>
                    </form>

                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="text-gray-500 mb-6">Belum ada alamat.</p>
    <?php endif; ?>

        <h2 class="text-2xl font-bold mb-4">Tambah Alamat</h2>

    <form action="proses/proses-address.php" method="POST" class="space-y-4">

        <input type="text" name="alamat" placeholder="Alamat lengkap"
            required class="w-full border rounded-lg px-3 py-2">

        <input type="text" name="kota" placeholder="Kota"
            required class="w-full border rounded-lg px-3 py-2">

        <input type="text" name="provinsi" placeholder="Provinsi"
            required class="w-full border rounded-lg px-3 py-2">

        <button 
            name="add_address"
            class="bg-black text-white px-4 py-2 rounded-lg">
            Simpan Alamat
        </button>
    </form>

</div>

<?php include("includes/footer.php") ?>
