<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>W Florist Pekanbaru - @yield('title')</title>

    @stack('prepend-style')
    <!-- Custom fonts for this template-->
    <link href="/admin_assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/admin_assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="/style/main.css" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @stack('addon-style')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center"
                href="{{ route('admin-dashboard') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fa fa-asterisk"></i>
                </div>
                <div class="sidebar-brand-text mx-3">W Florist</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item @yield('dashboard')">
                <a class="nav-link" href="{{ route('admin-dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                Menu
            </div>
            @if (Auth::user()->roles == 'ADMIN')
                <!-- Nav Item - Kategori -->
                <li class="nav-item @yield('kategori')">
                    <a class="nav-link" href="{{ route('category.index') }}">
                        <i class="fas fa-fw fa-bookmark"></i>
                        <span>Kategori</span>
                    </a>
                </li>
                <!-- Nav Item - Produk -->
                <li class="nav-item @yield('produk')">
                    <a class="nav-link" href="{{ route('product.index') }}">
                        <i class="fas fa-fw fa-gift"></i>
                        <span>Produk</span>
                    </a>
                </li>
                <!-- Nav Item - Galeri Produk -->
                <li class="nav-item @yield('galeri-produk')">
                    <a class="nav-link" href="{{ route('product-gallery.index') }}">
                        <i class="fas fa-fw fa-image"></i>
                        <span>Galeri Produk</span>
                    </a>
                </li>
                <!-- Nav Item - Transaksi -->
                <li class="nav-item @yield('transaksi')">
                    <a class="nav-link" href="{{ route('transaction.index') }}">
                        <i class="fa fa-fw fa-calculator"></i>
                        <span>Transaksi</span></a>
                </li>
                <!-- Nav Item - Review -->
                <li class="nav-item @yield('review')">
                    <a class="nav-link" href="{{ route('admin-review') }}">
                        <i class="fa fa-fw fa-comment"></i>
                        <span>Ulasan</span></a>
                </li>
                <!-- Nav Item - Ulasan Saya -->
                <li class="nav-item @yield('user')">
                    <a class="nav-link" href="{{ route('user.index') }}">
                        <i class="fa fa-fw fa-users"></i>
                        <span>User</span></a>
                </li>
                <!-- Nav Item - Akun Saya -->
                <li class="nav-item @yield('akun')">
                    <a class="nav-link" href="{{ route('admin-account') }}">
                        <i class="fa fa-fw fa-user"></i>
                        <span>Akun Saya</span></a>
                </li>
            @elseif(Auth::user()->roles == 'OWNER')
                <!-- Nav Item - Transaksi -->
                <li class="nav-item @yield('transaksi')">
                    <a class="nav-link" href="{{ route('transaction.index') }}">
                        <i class="fa fa-fw fa-calculator"></i>
                        <span>Transaksi</span></a>
                </li>
                <!-- Nav Item - Akun Saya -->
                <li class="nav-item @yield('akun')">
                    <a class="nav-link" href="{{ route('admin-account') }}">
                        <i class="fa fa-fw fa-user"></i>
                        <span>Akun Saya</span></a>
                </li>
            @endif
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <div class="sidebar-card d-none d-lg-flex">
                <a class="btn btn-primary btn-sm" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    {{-- Logo --}}
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-1 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <img src="/images/logo.svg" alt="Icon Cart Not NUll/ Tidak Kosong" style="width: 25%">
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Hi,
                                    {{ Auth::user()->name }}
                                </span>
                                {{-- <img class="img-profile rounded-circle" src="/admin_assets/img/undraw_profile.svg"> --}}
                                @if (Auth::user()->photo)
                                    <img src="{{ Storage::url(Auth::user()->photo) }}" alt="Icon User"
                                        class="img-profile rounded-circle">
                                @else
                                    <img alt="Icon User"
                                        src="https://ui-avatars.com/api/?name={{ Auth::user()->roles == 'ADMIN' ? 'Admin' : 'User' }}"
                                        class="img-profile rounded-circle">
                                @endif
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i
                                        class="fas fa-fw fa-tachometer-alt fa-sm
                                    mr-2 text-gray-400"></i>
                                    Dashboard
                                </a>
                                <a class="dropdown-item" href="{{ route('dashboard-account') }}">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - Alerts -->
                        {{-- <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link" href="{{ route('cart') }}">
                                @php
                                    $carts = \App\Models\Cart::where('users_id', Auth::user()->id)->count();
                                @endphp
                                @if ($carts > 0)
                                    <img src="/images/icon-cart-filled.svg" alt="Icon Cart Not NUll/ Tidak Kosong">
                                    <!-- Counter - Alerts -->
                                    <span class="badge badge-danger badge-counter">{{ $carts }}</span>
                                @else
                                    <img src="/images/icon-cart-null.svg" alt="Icon Cart Null/Kosong">
                                @endif
                            </a>
                        </li> --}}

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; WFlorist 2023</span>
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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah kamu yakin?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" untuk mengakhiri sesi.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    @stack('prepend-script')
    <!-- Bootstrap core JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/admin_assets/vendor/jquery/jquery.min.js"></script>
    <script src="/admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="/admin_assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="/admin_assets/js/sb-admin-2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script>
        $('#menu-toggle').click(function(e) {
            e.preventDefault();
            $('#wrapper').toggleClass('toggled');
        });
    </script>
    <script src="/script/navbar-scroll.js"></script>
    @stack('addon-script')
</body>

</html>
