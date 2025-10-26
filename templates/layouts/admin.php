<!DOCTYPE html>
<html lang="en">

<head>

  <?php

  use App\utils\Functions;

  Functions::PageHead($data);

  ?>

  <!-- Custom fonts for this template-->
  <link href="<?php echo asset("vendor/fontawesome-free/css/all.min.css") ?>" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?php echo asset("css/sb-admin-2.min.css") ?>" rel="stylesheet">

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo asset("vendor/jquery/jquery.min.js") ?>"></script>
  <script defer src="<?php echo asset("vendor/bootstrap/js/bootstrap.bundle.min.js") ?>"></script>

  <!-- Core plugin JavaScript-->
  <script defer src="<?php echo asset("vendor/jquery-easing/jquery.easing.min.js") ?>"></script>

  <!-- Custom scripts for all pages-->
  <script defer src="<?php echo asset("js/sb-admin-2.min.js") ?>"></script>

  <link href="<?php echo asset("client/lib/owlcarousel/assets/owl.carousel.min.css") ?>" rel="stylesheet">
  <link rel="shortcut icon" href="<?php echo asset("assets/images/fav-icon.png") ?>" type="image/x-icon">
  <link href="<?php echo asset("vendor/datatables/dataTables.bootstrap4.min.css") ?>" rel="stylesheet">
</head>

<body class="overflow-hidden" id="page-top">


  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php include template_dir("layouts/partials/admin-sidebar.php") ?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
        <?php include template_dir("layouts/partials/admin-topbar.php") ?>
        <!-- Begin Page Content -->
        <div style="overflow-y: scroll; height: calc(100vh - 70px)" class="container-fluid pt-4">
          <?php
          if ($_SERVER["REQUEST_URI"] != "/admin") {
            Functions::Breadcrumbs();
          }
          ?>
          {{content}}
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Developed by <a style="text-decoration: underline; text-underline-offset: 4px;" target="_blank" href="https://github.com/alihassan-1177">Ali Hassan</a></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <button id="logout-btn" class="btn btn-danger">Logout</button>
        </div>
      </div>
    </div>
  </div>

  <script src="<?php echo asset("vendor/datatables/jquery.dataTables.min.js") ?>"></script>
  <script src="<?php echo asset("vendor/datatables/dataTables.bootstrap4.min.js") ?>"></script>
  <script src="<?php echo asset("js/demo/datatables-demo.js") ?>"></script>
  <script src="<?php echo asset('js/admin.js') ?>"></script>
</body>

</html>