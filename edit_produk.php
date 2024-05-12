<?php
session_start();
include 'asset/php/connection.php';

$uploadDir = './asset/file';
if (isset($_GET['id'])) {
    $produk_id = $_GET['id'];

    // Query to retrieve product data based on ID
    $sql = "SELECT * FROM produk WHERE produk_id = $produk_id";
    $result = pg_query($conn, $sql);
    $row = pg_fetch_object($result);

    // Check if the product is found
    if (!$row) {
        echo "Produk tidak ditemukan.";
        exit;
    }
} else {
    echo "ID produk tidak valid.";
    exit;
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the form
    $nama_produk = $_POST['nama_produk'];
    $harga_produk = $_POST['harga_produk'];
    $stok_produk = $_POST['stok_produk'];
    $deskripsi_produk = $_POST['deskripsi_produk'];

    // Query to update product data
    $sql = "UPDATE produk SET stok_produk = '$stok_produk', deskripsi_produk = '$deskripsi_produk',nama_produk = '$nama_produk', harga_produk = '$harga_produk' WHERE produk_id = $produk_id";
    $result = pg_query($conn, $sql);

    if ($result) {
        // Redirect to the product list page after successfully editing
        header("Location: list_product.php");
        exit;
    } else {
        echo "Gagal mengedit produk.";
    }
    $fileName = $_FILES['gambar_produk']['name'];
    $tmpName = $_FILES['gambar_produk']['tmp_name'];
    $fileSize = $_FILES['gambar_produk']['size'];
    $fileType = $_FILES['gambar_produk']['type'];
    $filePath = $uploadDir . $fileName;

    $result = move_uploaded_file($tmpName, $filePath);

    if (!$result) {
        echo "Error uploading file";
        exit;
    }

    $query = "UPDATE produk SET gambar_produk = '$filePath' WHERE produk_id = $produk_id";
    $result = pg_query($conn, $query);

    if ($result === false) {
        echo "Error updating database";
        exit;
    }

}

$uploadDir = './asset/file/';

$username = $_SESSION['user'];


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.7/tailwind.min.css">
</head>

<body>
    <?php
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
    } else {
        echo 'Fail control';
        exit;
    }

    $sql = "SELECT * FROM users WHERE username = '$user'";
    $result = pg_query($conn, $sql);
    while ($row = pg_fetch_object($result)) {
        $_SESSION['user_id'] = $row->user_id;
    ?>

    <!-- wrapper -->
    <div class="container grid grid-cols-12 items-start gap-6 pt-4 pb-16 mx-auto"
        style="padding-left: 100px;padding-right: 100px">
        <!-- sidebar -->
        <div class="col-span-3">
            <div class="px-4 py-3 shadow flex items-center gap-4">
                <div class="flex-shrink-0">
                    <img src="<?php echo $row->user_img; ?>" alt="profile"
                        class="rounded-full w-14 h-14 border border-gray-200 p-1 object-cover">
                </div>
                <div class="flex-grow">
                    <p class="text-gray-600">Hello,</p>
                    <h4 class="text-gray-800 font-medium"><?php echo $row->username; ?></h4>
                </div>
            </div>

            <div class="mt-6 bg-white shadow rounded p-4 divide-y divide-gray-200 space-y-4 text-gray-600">
                <div class="space-y-1 pl-8">
                    <a href="profile.php" class="block font-medium capitalize transition">
                        <span class="absolute -left-8 top-0 text-base">
                            <i class="fa-regular fa-address-card"></i>
                        </span>
                        Manage account
                    </a>
                    <a href="profile.php" class="relative   hover:text-green-500 block capitalize transition">
                        Profile information
                    </a>
                    <a href="address.php?id=<?php echo $user_id;?> "
                        class="relative  hover:text-green-500 block capitalize transition">
                        Manage addresses
                    </a>
                    <a href="#" class="relative hover:text-green-500 block capitalize transition">
                        Change password
                    </a>
                </div>

                <div class="space-y-1 pl-8 pt-4">
                    <a href="wishlist.php" class="relative  block font-medium capitalize transition">
                        <span class="absolute -left-8 top-0 text-base">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </span>
                        My Cart
                    </a>
                </div>
                <div class="space-y-1 pl-8 pt-4">
                    <a href="toko.php" class="relative block font-medium capitalize transition">
                        <span class="absolute -left-8 top-0 text-base">
                            <i class="fa-solid fa-shop"></i>
                        </span>
                        TOKO kuu
                    </a>
                    </a>
                    <a href="tambah_produk.php" class="relative  hover:text-green-500 block capitalize transition">
                        add Product
                    </a>
                    <a href="list_product.php" class="relative text-green-500 block capitalize transition">
                        Product Listed
                    </a>
                    <a href="Order.php" class="relative block capitalize transition">
                        Order
                    </a>
                </div>

                <div class="space-y-1 pl-8 pt-4">
                    <a href="asset/php/logout.php"
                        class="relative hover:text-green-500 block font-medium capitalize transition">
                        <span class="absolute -left-8 top-0 text-base">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </span>
                        Logout
                    </a>
                </div>

            </div>
        </div>
        <?php }?>
        <!-- ./sidebar -->
        <div class="col-span-9">
            <h1 class=" text-2xl">EDIT PRODUCT</h1>
            <?php
            $user_id = $_SESSION['user_id'];
            $product_id = $_GET['id'];
            
            $sql = "SELECT * FROM produk WHERE  produk_id= '$product_id'  ";
            $result = pg_query($conn, $sql);
            while ($row = pg_fetch_object($result)) {
                ?>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="mb-4">
                    <label class="block font-semibold" for="nama_produk">Nama Produk:</label>
                    <input class="w-full border border-gray-300 rounded-md p-2" type="text" id="nama_produk"
                        name="nama_produk" value="<?php echo $row->nama_produk; ?>">
                </div>

                <div class="mb-4">
                    <label class="block font-semibold" for="harga_produk">Harga Produk:</label>
                    <input class="w-full border border-gray-300 rounded-md p-2" type="text" id="harga_produk"
                        name="harga_produk" value="<?php echo $row->harga_produk; ?>">
                </div>
                <div class="mb-4">
                    <label class="block font-semibold" for="stok_produk">Stok Produk:</label>
                    <input class="w-full border border-gray-300 rounded-md p-2" type="text" id="stok_produk"
                        name="stok_produk" value="<?php echo $row->stok_produk; ?>">
                </div>
                <div class="mb-4">
                    <label class="block font-semibold" for="deskripsi_produk">Deskripsi Produk:</label>
                    <input class="w-full border border-gray-300 rounded-md p-2" type="text" id="deskripsi_produk"
                        name="deskripsi_produk" value="<?php echo $row->deskripsi_produk; ?>">
                </div>
                <div class="mb-4">
                    <label class="block font-semibold" for="gambar_produk">Gambar Produk:</label>
                    <input type="file" id="gambar_produk" name="gambar_produk">
                    <div class="mt-6 flex justify-end">
                    <button name="simpan" class="px-4 py-2 place-items-end bg-green-500 text-white rounded-md hover:bg-green-700" type="submit">Simpan</button>
                    </div>

                    <br><br>
                    <img src="<?php echo $row->gambar_produk; ?>" alt="Produk" style="max-width: 200px;"><br><br>

                </div>

            </form>
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>