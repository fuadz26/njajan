<?php
require 'vendor/autoload.php';

// use Aws\S3\S3Client;
// use Aws\Exception\AwsException;

session_start();
include 'asset/php/connection.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama_produk = $_POST['nama_produk'];
    $kategori_produk = $_POST['kategori_produk'];
    $harga_produk = $_POST['harga_produk'];
    $stok_produk = $_POST['stok_produk'];
    $deskripsi_produk = $_POST['deskripsi_produk'];


    if (empty($nama_produk) || empty($kategori_produk) || empty($harga_produk) || empty($stok_produk) || empty($deskripsi_produk)) {
        echo "Silakan isi semua kolom yang wajib.";
        exit;
    }


    $uploadDir = './asset/file/';
    $fileName = $_FILES['gambar_produk']['name'];
    $tmpName = $_FILES['gambar_produk']['tmp_name'];
    $fileSize = $_FILES['gambar_produk']['size'];
    $fileType = $_FILES['gambar_produk']['type'];
    $filePath = $uploadDir . $fileName;

    if (!empty($fileName)) {
        $result = move_uploaded_file($tmpName, $filePath);

        if (!$result) {
            echo "Error mengunggah file";
            exit;
        }
    } else {

        $filePath = 'default.jpg';
    }



    // $s3Client = new S3Client($awsConfig);


    // $bucketName = 'njajan2';
    // $s3Key = 'produk/' . $username . '/' . $fileName;


    // function uploadFileToS3($s3Client, $bucketName, $filePath, $s3Key)
    // {
    //     try {
    //         $result = $s3Client->putObject([
    //             'Bucket' => $bucketName,
    //             'Key'    => $s3Key,
    //             'SourceFile' => $filePath,
    //         ]);
    //         echo "File berhasil diunggah ke S3. URL: " . $result['ObjectURL'] . "\n";
    //         return $result['ObjectURL'];
    //     } catch (AwsException $e) {
    //         echo "Gagal mengunggah file ke S3: " . $e->getMessage() . "\n";
    //         return false;
    //     }
    // }


    // $s3Url = uploadFileToS3($s3Client, $bucketName, $filePath, $s3Key);
    $user_id = $_SESSION['user_id'];
    $toko_id = $_SESSION['toko_id'];

    if ($filePath) {

        $sql = "INSERT INTO produk (nama_produk, kategori_id, harga_produk, stok_produk, deskripsi_produk, produk_img, toko_id) VALUES ('$nama_produk', '$kategori_produk', '$harga_produk', '$stok_produk', '$deskripsi_produk', '$filePath', '$toko_id')";
        $result = pg_query($conn, $sql);

        if ($result === false) {
            echo "Error updating database";
            exit;
        }
    }

    header("Location: list_product.php");
    echo "<br>File uploaded<br>";

    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
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
    include 'asset/php/connection.php';
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
    } else {
        echo 'Fail contol';
    }
    $sql = "SELECT * from users where username = '$user'";
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
            <h1 class="text-2xl font-bold mb-4 text-brown-600">Tambah Produk</h1>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="nama_produk" class="block font-semibold text-brown-800">Nama Produk:</label>
                    <input type="text" id="nama_produk" name="nama_produk" required class="w-full border border-gray-300 p-2 rounded">
                </div>
                <div class="mb-4">
                    <label for="kategori_produk" class="block font-semibold text-brown-800">Kategori Produk:</label>
                    <select id="kategori_produk" name="kategori_produk" required class="w-full border border-gray-300 p-2 rounded">
                        <?php
                        $sql = "SELECT * FROM kategori";
                        $result = pg_query($conn, $sql);
                        while ($row = pg_fetch_object($result)) {
                            echo "<option value='$row->kategori_id'>$row->nama_kategori</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="harga_produk" class="block font-semibold text-brown-800">Harga Produk:</label>
                    <input type="text" id="harga_produk" name="harga_produk" required class="w-full border border-gray-300 p-2 rounded">
                </div>
                <div class="mb-4">
                    <label for="stok_produk" class="block font-semibold text-brown-800">Stok Produk:</label>
                    <input type="text" id="stok_produk" name="stok_produk" required class="w-full border border-gray-300 p-2 rounded">
                </div>
                <div class="mb-4">
                    <label for="deskripsi_produk" class="block font-semibold text-brown-800">Deskripsi Produk:</label>
                    <input type="text" id="deskripsi_produk" name="deskripsi_produk" required class="w-full border border-gray-300 p-2 rounded">
                </div>
                <div class="mb-4">
                    <label for="gambar_produk" class="block font-semibold text-brown-800">Gambar Produk:</label>
                    <input type="file" id="gambar_produk" name="gambar_produk" class="w-full border border-gray-300 p-2 rounded">
                </div>
                <button type="submit" class="bg-brown-500 text-white py-2 px-4 rounded hover:bg-brown-600">Tambah</button>
            </form>
        </div>
        </div>
</body>

</html>