<?php
using_layout("frontend/layout.php");
?>

<?php start_section("title"); ?>
Homepage
<?php end_section(); ?>

<?php start_section("content"); ?>
<h1>Home</h1>
<?php end_section(); ?>

<?php start_section('styles') ?>

<style>
    h1 {
        color: blue;
    }
</style>

<?php end_section() ?>

<?php start_section('scripts') ?>
<script>
    console.log("HELLO, WORLD")
</script>
<?php end_section() ?>