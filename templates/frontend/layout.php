<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php yield_section('title') ?></title>
    <?php yield_section('styles') ?>
</head>

<body>
    <?php yield_section('content') ?>
    <?php yield_section('scripts') ?>
</body>

</html>