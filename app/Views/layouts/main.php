<!doctype html>
<html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
	data-sidebar-image="none" data-preloader="disable">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<base href="/">
	<meta charset="utf-8" />
	<title><?= ($title) ? $title : '' ?> | Velzon - Admin & Dashboard Template</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="Sistema de Gestión de Postgrado de la Universidad Técnica de Oruro - UTO" name="description" />
	<meta content="DTIC-UTO" name="author" />
	<!-- App favicon -->
	<link rel="shortcut icon" href="<?= base_url('/assets/images/favicon.ico') ?>">

	<!-- jsvectormap css -->
	<link href="/assets/libs/jsvectormap/jsvectormap.min.css" rel="stylesheet" type="text/css" />

	<!--Swiper slider css-->
	<link href="/assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

	<?= $this->include('partials/head-css') ?>
	<?= $this->renderSection('styles') ?>
</head>

<body class="d-flex flex-column min-vh-100">
	<!-- Begin page -->
	<div id="layout-wrapper">

		<?= $this->include('partials/menu') ?>
		<!-- ============================================================== -->
		<!-- Start right Content here -->
		<!-- ============================================================== -->
		<div class="main-content">

			<div class="page-content">
				<div class="container-fluid">
					<?= $this->renderSection('content') ?>
				</div>
				<!-- container-fluid -->
			</div>
			<!-- End Page-content -->

			<!-- Footer -->
			<?= $this->include('partials/footer') ?>

		</div>
		<!-- end main content-->

	</div>
	<!-- END layout-wrapper -->

	<?= $this->include('partials/customizer') ?>

	<?= $this->include('partials/vendor-scripts') ?>

	<!-- apexcharts -->
	<script src="/assets/libs/apexcharts/apexcharts.min.js"></script>

	<!-- Vector map-->
	<script src="/assets/libs/jsvectormap/jsvectormap.min.js"></script>
	<script src="/assets/libs/jsvectormap/maps/world-merc.js"></script>

	<!--Swiper slider js-->
	<script src="/assets/libs/swiper/swiper-bundle.min.js"></script>

	<!-- Dashboard init -->
	<script src="/assets/js/pages/dashboard-ecommerce.init.js"></script>

	<!-- App js -->
	<script src="/assets/js/app.js"></script>
	<!-- Scripts específicos de página -->
	<?= $this->renderSection('scripts') ?>
</body>

</html>