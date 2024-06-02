<?php
session_start();
if (isset($_SESSION['alert_message'])) {
    echo "<script>alert('" . $_SESSION['alert_message'] . "');</script>";
    unset($_SESSION['alert_message']);
}
?>
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
    <title>Document</title>
    <style>
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
    include 'asset/php/navbar.php';
    ?>
    <div class="contain py-16">
        <div class="max-w-lg mx-auto shadow px-6 py-7 rounded overflow-hidden">
            <h2 class="text-2xl uppercase font-medium mb-1">Create an account</h2>
            <p class="text-gray-600 mb-6 text-sm">
                Register for new customer
            </p>
            <form action="asset/php/regis_aksi.php" method="post" autocomplete="off">
                <div class="space-y-2">
                    <div>
                        <label for="name" class="text-gray-600 mb-2 block">Full Name</label>
                        <input type="text" name="name" id="name" class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-green-500 placeholder-gray-400" placeholder="Full Name">
                    </div>
                    <div>
                        <label for="email" class="text-gray-600 mb-2 block">Email address</label>
                        <input type="email" name="email" id="email" class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-green-500 placeholder-gray-400" placeholder="youremail@example.com">
                    </div>
                    <div>
                        <label for="username" class="text-gray-600 mb-2 block">Username</label>
                        <input type="text" name="username" id="username" class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-green-500 placeholder-gray-400" placeholder="Username">
                    </div>
                    <div>
                        <label for="password" class="text-gray-600 mb-2 block">Password</label>
                        <input type="password" name="password" id="password" class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-green-500 placeholder-gray-400" placeholder="*******">
                    </div>

                </div>
                <div class="mt-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="aggrement" id="aggrement" class="text-green-500 focus:ring-green-500 rounded-sm cursor-pointer">
                        <label for="aggrement" class="text-gray-600 ml-3 cursor-pointer">Are you sure?
                        </label>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="block w-full py-2 text-center text-white bg-green-500 border border-green-500 rounded hover:bg-transparent hover:text-green-500 transition uppercase font-roboto font-medium">Create
                        account</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>