<?php

/** @var array $data */
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    use App\utils\Functions;

    Functions::PageHead($data);
    ?>
    <!-- Custom fonts for this template-->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="<?= asset('vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= asset('css/sb-admin-2.min.css') ?>" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container">
        {{content}}
    </div>
    <script src="<?= asset('vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= asset('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= asset('vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
    <script src="<?= asset('js/sb-admin-2.min.js') ?>"></script>
</body>

</html>