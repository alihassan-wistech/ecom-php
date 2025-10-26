<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo $this->yieldSection('head')  ?>
    <?php include template_dir("frontend/includes/header-scripts.php"); ?>
    <?php echo $this->yieldSection('styles')  ?>
</head>

<body>
    <?php include template_dir("frontend/includes/body-begin.php") ?>
    <main id="wrapper">
        <?php include template_dir("frontend/includes/header.php") ?>
        <?php // echo $this->yieldSection('content') ?>
        <?php include template_dir("frontend/includes/footer.php") ?>
    </main>
    <?php include template_dir("frontend/includes/body-end.php") ?>
    <?php include template_dir("frontend/includes/footer-scripts.php") ?>
    <?php echo $this->yieldSection('scripts')  ?>
</body>

</html>