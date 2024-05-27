<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

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
    $awsConfig = [
        'version' => 'latest',
        'region'  => 'ap-northeast-3',
        'credentials' => [
            'key'    => 'AKIA5FTZEUCNVLLQKMEP',
            'secret' => '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',
        ],
    ];


    $s3Client = new S3Client($awsConfig);


    $bucketName = 'njajan2';
    $s3Key = 'produk/' . $username . '/' . $fileName;

    // Fungsi untuk mengunggah file ke S3
    function uploadFileToS3($s3Client, $bucketName, $filePath, $s3Key)
    {
        try {
            $result = $s3Client->putObject([
                'Bucket' => $bucketName,
                'Key'    => $s3Key,
                'SourceFile' => $filePath,
            ]);
            echo "File berhasil diunggah ke S3. URL: " . $result['ObjectURL'] . "\n";
            return $result['ObjectURL'];
        } catch (AwsException $e) {
            echo "Gagal mengunggah file ke S3: " . $e->getMessage() . "\n";
            return false;
        }
    }


    $s3Url = uploadFileToS3($s3Client, $bucketName, $filePath, $s3Key);
    $user_id = $_SESSION['user_id'];
    $toko_id = $_SESSION['toko_id'];

    if ($s3Url) {

        $sql = "INSERT INTO produk (nama_produk, kategori_id, harga_produk, stok_produk, deskripsi_produk, produk_img, toko_id) VALUES ('$nama_produk', '$kategori_produk', '$harga_produk', '$stok_produk', '$deskripsi_produk', '$s3Url', '$toko_id')";
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
</head>

<body>
    <?php
    include 'asset/php/navbar.php';
    include 'asset/php/connection.php';
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
    } else
        echo 'Fail contol';
    $sql = "SELECT * from users where username = '$user'";
    $result = pg_query($conn, $sql);
    while ($row = pg_fetch_object($result)) {
        $_SESSION['user_id'] = $row->user_id;
    ?>


        <div class="container grid grid-cols-12 items-start gap-6 pt-4 pb-16 mx-auto" style="padding-left: 100px;padding-right: 100px">


            <div class="col-span-3">
                <div class="px-4 py-3 shadow flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <img src="<?php echo $row->user_img; ?>" alt="profile" class="rounded-full w-14 h-14 border border-gray-200 p-1 object-cover">
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
                        <a href="address.php?id=<?php echo $user_id; ?> " class="relative  hover:text-green-500 block capitalize transition">
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
                        <a href="tambah_produk.php" class="relative text-green-500 block capitalize transition">
                            add Product
                        </a>
                        <a href="list_product.php" class="relative hover:text-green-500 block capitalize transition">
                            Product Listed
                        </a>
                        <a href="Order.php" class="relative block capitalize transition">
                            Order
                        </a>
                    </div>

                    <div class="space-y-1 pl-8 pt-4">
                        <a href="asset/php/logout.php" class="relative hover:text-green-500 block font-medium capitalize transition">
                            <span class="absolute -left-8 top-0 text-base">
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </span>
                            Logout
                        </a>
                    </div>

                </div>
            </div>

            <!-- ./sidebar -->
        <?php } ?>
        <div class="col-span-9">
            <h1 class="text-2xl font-bold mb-4">Tambah Produk</h1>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="nama_produk" class="block font-semibold">Nama Produk:</label>
                    <input type="text" id="nama_produk" name="nama_produk" required class="w-full border border-gray-300 p-2 rounded">
                </div>
                <div class="mb-4">
                    <label for="kategori_produk" class="block font-semibold">Kategori Produk:</label>
                    <select id="kategori_produk" name="kategori_produk" required class="w-full border border-gray-300 p-2 rounded">
                        <?php
                        // Query untuk mengambil data kategori
                        $sql = "SELECT * FROM kategori";
                        $result = pg_query($conn, $sql);

                        // Loop untuk menampilkan opsi kategori
                        while ($row = pg_fetch_object($result)) {
                            echo "<option value='$row->kategori_id'>$row->nama_kategori</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="harga_produk" class="block font-semibold">Harga Produk:</label>
                    <input type="text" id="harga_produk" name="harga_produk" required class="w-full border border-gray-300 p-2 rounded">
                </div>
                <div class="mb-4">
                    <label for="stok_produk" class="block font-semibold">Stok Produk:</label>
                    <input type="text" id="stok_produk" name="stok_produk" required class="w-full border border-gray-300 p-2 rounded">
                </div>
                <div class="mb-4">
                    <label for="deskripsi_produk" class="block font-semibold">Deskripsi Produk:</label>
                    <input type="text" id="deskripsi_produk" name="deskripsi_produk" required class="w-full border border-gray-300 p-2 rounded">
                </div>
                <div class="mb-4">
                    <label for="gambar_produk" class="block font-semibold">Gambar Produk:</label>
                    <input type="file" id="gambar_produk" name="gambar_produk" class="w-full border border-gray-300 p-2 rounded">
                </div>
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700">Tambah</button>
            </form>
        </div>
        </div>
</body>

</html>