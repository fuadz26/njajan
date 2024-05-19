<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="asset/css/output.css">
    <title>Login</title>
    <style>
        /* Tambahkan CSS untuk mengubah warna menjadi coklat */
        .text-green-500 {
            color: #8B4513;
        }

        .border-green-500 {
            border-color: #8B4513;
        }

        .bg-green-500 {
            background-color: #8B4513;
        }

        .hover\:bg-green-500:hover {
            background-color: transparent;
            color: #8B4513;
        }

        .hover\:text-green-500:hover {
            color: #8B4513;
        }

        .focus\:ring-green-500:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.5);
        }
    </style>
</head>

<body>
    <?php
    session_start();
    include 'asset/php/navbar.php';
    if (isset($_SESSION['errorMessages'])) {
    ?>
        <p align="center"><strong>
                <font color="#8B4513"><?php echo $_SESSION['errorMessages']; ?></font>
            </strong></p>
    <?php
        unset($_SESSION['errorMessages']);
    }
    ?>


    <div class="contain py-16">
        <div class="max-w-lg mx-auto shadow px-6 py-7 rounded overflow-hidden">
            <h2 class="text-2xl uppercase font-medium mb-1">Login</h2>
            <p class="text-gray-600 mb-6 text-sm">
                welcome back LURRRR
            </p>
            <form action="asset/php/login_aksi.php" method="post" autocomplete="off">
                <div class="space-y-2">
                    <div>
                        <label for="Username" class="text-gray-600 mb-2 block">Username</label>
                        <input type="username" name="username" id="username" class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-green-500 placeholder-gray-400" placeholder="Username">
                    </div>
                    <div>
                        <label for="password" class="text-gray-600 mb-2 block">Password</label>
                        <input type="password" name="password" id="password" class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-green-500 placeholder-gray-400" placeholder="*******">
                    </div>
                </div>
                <div class="flex items-center justify-between mt-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="text-green-500 focus:ring-green-500 rounded-sm cursor-pointer">
                        <label for="remember" class="text-gray-600 ml-3 cursor-pointer">Remember me</label>
                    </div>
                    <a href="#" class="text-green-500">Forgot password</a>
                </div>
                <div class="mt-4">
                    <button type="submit" class="block w-full py-2 text-center text-white bg-green-500 border border-green-500 rounded hover:bg-transparent hover:text-green-500 transition uppercase font-roboto font-medium">Login</button>
                </div>
            </form>

            <p class="mt-4 text-center text-gray-600">Don't have account? <a href="regis.php" class="text-green-500">Register
                    now</a></p>
        </div>
    </div>
    <!-- ./login -->

</body>

</html>