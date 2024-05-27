<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
// Konfigurasi AWS
$awsConfig = [
    'version' => 'latest',
    'region'  => 'ap-northeast-3',
    'credentials' => [
        'key'    => 'AKIA5FTZEUCNVLLQKMEP',

    ],
];

// Buat instance S3Client
$s3Client = new S3Client($awsConfig);
