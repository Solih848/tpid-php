    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="admin_super.php">TPID SUMENEP</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="proses_logout_super.php"><i class="fa-solid fa-right-to-bracket" style="margin-right: 5px;"></i>Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="admin_super.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Barang</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsBarang" aria-expanded="false" aria-controls="collapseLayoutsBarang">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Data Barang
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsBarang" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="pasar.php">Tambah Pasar</a>
                                <a class="nav-link" href="produk.php">Tambah Produk</a>
                                <a class="nav-link" href="satuan.php">Tambah Satuan</a>
                                <a class="nav-link" href="read_sub_judul_admin.php">Edit Data Barang</a>
                            </nav>
                        </div>

                        <!-- Operator -->
                        <div class="sb-sidenav-menu-heading">Operator</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsOperator" aria-expanded="false" aria-controls="collapseLayoutsOperator">
                            <div class="sb-nav-link-icon"><i class="fa-regular fa-user"></i></div>
                            Operator
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsOperator" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="halaman_operator_pasar.php">Operator Pasar</a>
                                <a class="nav-link" href="halaman_inflasi.php">Operator Inflasi</a>
                            </nav>
                        </div>
                        <!-- end operator-->

                        <!-- Admin -->
                        <div class="sb-sidenav-menu-heading">Admin</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsAdmin" aria-expanded="false" aria-controls="collapseLayoutsOperator">
                            <div class="sb-nav-link-icon"><i class="fa-sharp fa-light fa-user"></i></div>
                            Admin
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsAdmin" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="halaman_admin.php">Tabel Admin</a>
                                <a class="nav-link" href="ubah_username_super.php">Ubah Email Admin</a>
                                <a class="nav-link" href="ubah_password_super.php">Ubah Password Admin</a>
                            </nav>
                        </div>
                        <!-- Gambar -->
                        <div class="sb-sidenav-menu-heading">Lain-lain</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsGambar" aria-expanded="false" aria-controls="collapseLayoutsGambar">
                            <div class="sb-nav-link-icon"><i class="fa-regular fa-image"></i></div>
                            Gambar
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsGambar" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="edit_logo.php">Ubah Logo</a>
                                <a class="nav-link" href="edit_slider.php">Ubah Slide</a>
                            </nav>
                        </div>
                        <!-- End gambar -->

                        <!-- Ekonomi -->
                        <div class="sb-sidenav-menu-heading">Makro Ekonomi</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsEkonomi" aria-expanded="false" aria-controls="collapseLayoutsEkonomi">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-business-time"></i></div>
                            Ekonomi
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsEkonomi" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="a_ekonomi.php">Edit Halaman Makro Ekonomi</a>
                            </nav>
                        </div>
                        <!-- End ekonomi -->

                        <div class="sb-sidenav-footer" style="margin-top:164px">
                            <div class="small">Login sebagai :</div>
                            <?php echo $username; ?>
                        </div>
            </nav>
        </div>