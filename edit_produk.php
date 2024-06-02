<?php
session_start();
include 'asset/php/connection.php';

$uploadDir = './asset/file';
if (isset($_GET['id'])) {
    $produk_id = $_GET['id'];


    $sql = "SELECT * FROM produk WHERE produk_id = $produk_id";
    $result = pg_query($conn, $sql);
    $row = pg_fetch_object($result);


    if (!$row) {
        echo "Produk tidak ditemukan.";
        exit;
    }
} else {
    echo "ID produk tidak valid.";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama_produk = $_POST['nama_produk'];
    $harga_produk = $_POST['harga_produk'];
    $stok_produk = $_POST['stok_produk'];
    $deskripsi_produk = $_POST['deskripsi_produk'];


    if ($_FILES['gambar_produk']['size'] > 0) {
        $fileName = $_FILES['gambar_produk']['name'];
        $tmpName = $_FILES['gambar_produk']['tmp_name'];
        $fileSize = $_FILES['gambar_produk']['size'];
        $fileType = $_FILES['gambar_produk']['type'];
        $filePath = $uploadDir . '/' . $fileName;


        $result = move_uploaded_file($tmpName, $filePath);

        if (!$result) {
            echo "Error uploading file";
            exit;
        }


        $query = "UPDATE produk SET produk_img = '$filePath' WHERE produk_id = $produk_id";
        $result = pg_query($conn, $query);

        if ($result === false) {
            echo "Error updating database";
            exit;
        }
    }


    $sql = "UPDATE produk SET stok_produk = '$stok_produk', deskripsi_produk = '$deskripsi_produk',nama_produk = '$nama_produk', harga_produk = '$harga_produk' WHERE produk_id = $produk_id";
    $result = pg_query($conn, $sql);

    if ($result) {
        header("Location: list_product.php");
        exit;
    } else {
        echo "Gagal mengedit produk.";
    }
}

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

    <style>
        .text-brown-500 {
            color: #8B4513;
        }

        .text-brown-600 {
            color: #A0522D;
        }

        .text-brown-800 {
            color: #5C4033;
        }

        .bg-brown-500 {
            background-color: #8B4513;
        }

        .border-brown-500 {
            border-color: #8B4513;
        }

        .hover\:text-brown-500:hover {
            color: #8B4513;
        }

        .hover\:bg-brown-500:hover {
            background-color: #8B4513;
            color: #FFF;
        }

        .hover\:bg-transparent:hover {
            background-color: transparent;
            color: #8B4513;
        }

        .sidebar {
            background-color: #8B4513;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: #FFF;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #FFF;
        }

        .sidebar-header img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            object-fit: cover;
            border: 2px solid #FFF;
        }

        .sidebar-content {
            margin-top: 20px;
        }

        .sidebar-link {
            display: block;
            padding: 10px;
            border-radius: 5px;
            color: #FFF;
            transition: background-color 0.3s, color 0.3s;
        }

        .sidebar-link:hover {
            background-color: #A0522D;
        }

        .sidebar-link i {
            margin-right: 10px;
        }
    </style>
</head>

<body>

    <?php
    include 'asset/php/navbar.php';
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


        <div class="container grid grid-cols-12 items-start gap-6 pt-4 pb-16 mx-auto" style="padding-left: 100px;padding-right: 100px">

            <div class="col-span-3">
                <div class="sidebar">
                    <div class="sidebar-header">
                        <img src="<?php echo $row->user_img; ?>" alt="profile">
                        <div>
                            <p>Hello,</p>
                            <h4><?php echo $row->username; ?></h4>
                        </div>
                    </div>

                    <div class="sidebar-content">
                        <a href="profile.php" class="sidebar-link">
                            <i class="fa-regular fa-address-card"></i> Manage account
                        </a>
                        <a href="profile.php" class="sidebar-link ">
                            Profile information
                        </a>
                        <a href="address.php?id=<?php echo $row->user_id; ?>" class="sidebar-link ">
                            Manage addresses
                        </a>
                        <a href="wishlist.php" class="sidebar-link">
                            <i class="fa-solid fa-bag-shopping"></i>
                            My Cart
                        </a>
                        <a href="toko.php" class="sidebar-link">
                            <i class="fa-solid fa-shop"></i>
                            My Store
                        </a>
                        <a href="tambah_produk.php" class="sidebar-link text-brown-500">
                            Add Product
                        </a>
                        <a href="list_product.php" class="sidebar-link ">
                            Product Listed
                        </a>
                        <a href="order.php" class="sidebar-link ">
                            Order
                        </a>
                        <a href="asset/php/logout.php" class="sidebar-link ">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="col-span-9">
            <h1 class="text-2xl text-brown-800 mb-4">EDIT PRODUCT</h1>
            <?php
            $user_id = $_SESSION['user_id'];
            $product_id = $_GET['id'];

            $sql = "SELECT * FROM produk WHERE produk_id= '$product_id'";
            $result = pg_query($conn, $sql);
            while ($row = pg_fetch_object($result)) {
            ?>
                <form method="POST" action="" enctype="multipart/form-data" class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-1/2">
                            <label class="block font-semibold text-brown-800" for="nama_produk">Nama Produk:</label>
                            <input class="w-full border border-brown-500 rounded-md p-2" type="text" id="nama_produk" name="nama_produk" value="<?php echo $row->nama_produk; ?>">
                        </div>
                        <div class="w-1/2">
                            <label class="block font-semibold text-brown-800" for="harga_produk">Harga Produk:</label>
                            <input class="w-full border border-brown-500 rounded-md p-2" type="text" id="harga_produk" name="harga_produk" value="<?php echo $row->harga_produk; ?>">
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="w-1/2">
                            <label class="block font-semibold text-brown-800" for="stok_produk">Stok Produk:</label>
                            <input class="w-full border border-brown-500 rounded-md p-2" type="text" id="stok_produk" name="stok_produk" value="<?php echo $row->stok_produk; ?>">
                        </div>
                        <div class="w-1/2">
                            <label class="block font-semibold text-brown-800" for="deskripsi_produk">Deskripsi Produk:</label>
                            <input class="w-full border border-brown-500 rounded-md p-2" type="text" id="deskripsi_produk" name="deskripsi_produk" value="<?php echo $row->deskripsi_produk; ?>">
                        </div>
                    </div>
                    <div>
                        <label class="block font-semibold text-brown-800" for="gambar_produk">Gambar Produk:</label>
                        <input type="file" id="gambar_produk" name="gambar_produk">
                        <img src="<?php echo $row->produk_img; ?>" alt="Produk" style="max-width: 200px;" class="mt-4">
                    </div>
                    <div class="flex justify-end">
                        <button name="simpan" class="px-4 py-2 bg-brown-500 text-white rounded-md hover:bg-brown-700" type="submit">Simpan</button>
                    </div>
                </form>
            <?php
            }
            ?>
        </div>

        </div>

</body>

</html>