<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Pionir Backoffice</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport"/>
  <link rel="icon" href="<?php echo base_url(); ?>assets/logo.png" type="image/x-icon"/>

  <script src="<?php echo base_url(); ?>dist/js/plugin/webfont/webfont.min.js"></script>
  <script>
    WebFont.load({
      google: { families: ["Public Sans:300,400,500,600,700"] },
      custom: {
        families: [
          "Font Awesome 5 Solid",
          "Font Awesome 5 Regular",
          "Font Awesome 5 Brands",
          "simple-line-icons",
        ],
        urls: ["<?php echo base_url(); ?>dist/css/fonts.min.css"],
      },
      active: function () {
        sessionStorage.fonts = true;
      },
    });
  </script>

  <!-- CSS Files -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/plugins.min.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/kaiadmin.min.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/style.css" />


</head>
<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar sidebar-style-2" data-background-color="dark">
      <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
          <a href="index.html" class="logo">
            <img
            src="<?php echo base_url(); ?>assets/logo.png"
            alt="navbar brand"
            class="navbar-brand"
            height="50"
            /><h1 style="color:#ffffff; margin-top:10px;">Pionir</h1>
          </a>
          <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
              <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
              <i class="gg-menu-left"></i>
            </button>
          </div>
          <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
          </button>
        </div>
        <!-- End Logo Header -->
      </div>
      <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
          <ul class="nav nav-secondary">
            <li class="nav-item">
              <a
              data-bs-toggle="collapse"
              href="#dashboard"
              class="collapsed"
              aria-expanded="false"
              >
              <i class="fas fa-home"></i>
              <p>Dashboard</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="dashboard">
              <ul class="nav nav-collapse">
                <li>
                  <a href="../demo1/index.html">
                    <span class="sub-item">Dashboard 1</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#base">
              <i class="fas fa-layer-group"></i>
              <p>Base</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="base">
              <ul class="nav nav-collapse">
                <li>
                  <a href="components/avatars.html">
                    <span class="sub-item">Avatars</span>
                  </a>
                </li>
                <li>
                  <a href="components/buttons.html">
                    <span class="sub-item">Buttons</span>
                  </a>
                </li>
                <li>
                  <a href="components/gridsystem.html">
                    <span class="sub-item">Grid System</span>
                  </a>
                </li>
                <li>
                  <a href="components/panels.html">
                    <span class="sub-item">Panels</span>
                  </a>
                </li>
                <li>
                  <a href="components/notifications.html">
                    <span class="sub-item">Notifications</span>
                  </a>
                </li>
                <li>
                  <a href="components/sweetalert.html">
                    <span class="sub-item">Sweet Alert</span>
                  </a>
                </li>
                <li>
                  <a href="components/font-awesome-icons.html">
                    <span class="sub-item">Font Awesome Icons</span>
                  </a>
                </li>
                <li>
                  <a href="components/simple-line-icons.html">
                    <span class="sub-item">Simple Line Icons</span>
                  </a>
                </li>
                <li>
                  <a href="components/typography.html">
                    <span class="sub-item">Typography</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#forms">
              <i class="fas fa-pen-square"></i>
              <p>Forms</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="forms">
              <ul class="nav nav-collapse">
                <li>
                  <a href="forms/forms.html">
                    <span class="sub-item">Basic Form</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#tables">
              <i class="fas fa-table"></i>
              <p>Tables</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="tables">
              <ul class="nav nav-collapse">
                <li>
                  <a href="tables/tables.html">
                    <span class="sub-item">Basic Table</span>
                  </a>
                </li>
                <li>
                  <a href="tables/datatables.html">
                    <span class="sub-item">Datatables</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#maps">
              <i class="fas fa-map-marker-alt"></i>
              <p>Maps</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="maps">
              <ul class="nav nav-collapse">
                <li>
                  <a href="maps/googlemaps.html">
                    <span class="sub-item">Google Maps</span>
                  </a>
                </li>
                <li>
                  <a href="maps/jsvectormap.html">
                    <span class="sub-item">Jsvectormap</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#charts">
              <i class="far fa-chart-bar"></i>
              <p>Charts</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="charts">
              <ul class="nav nav-collapse">
                <li>
                  <a href="charts/charts.html">
                    <span class="sub-item">Chart Js</span>
                  </a>
                </li>
                <li>
                  <a href="charts/sparkline.html">
                    <span class="sub-item">Sparkline</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a href="widgets.html">
              <i class="fas fa-desktop"></i>
              <p>Widgets</p>
              <span class="badge badge-success">4</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="../../documentation/index.html">
              <i class="fas fa-file"></i>
              <p>Documentation</p>
              <span class="badge badge-secondary">1</span>
            </a>
          </li>
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#submenu">
              <i class="fas fa-bars"></i>
              <p>Menu Levels</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="submenu">
              <ul class="nav nav-collapse">
                <li>
                  <a data-bs-toggle="collapse" href="#subnav1">
                    <span class="sub-item">Level 1</span>
                    <span class="caret"></span>
                  </a>
                  <div class="collapse" id="subnav1">
                    <ul class="nav nav-collapse subnav">
                      <li>
                        <a href="#">
                          <span class="sub-item">Level 2</span>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <span class="sub-item">Level 2</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li>
                  <a data-bs-toggle="collapse" href="#subnav2">
                    <span class="sub-item">Level 1</span>
                    <span class="caret"></span>
                  </a>
                  <div class="collapse" id="subnav2">
                    <ul class="nav nav-collapse subnav">
                      <li>
                        <a href="#">
                          <span class="sub-item">Level 2</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li>
                  <a href="#">
                    <span class="sub-item">Level 1</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!-- End Sidebar -->

  <div class="main-panel">
    <div class="main-header">
      <div class="main-header-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
          <a href="index.html" class="logo">
            <img
            src="<?php echo base_url(); ?>dist//img/kaiadmin/logo_light.svg"
            alt="navbar brand"
            class="navbar-brand"
            height="20"
            />
          </a>
          <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
              <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
              <i class="gg-menu-left"></i>
            </button>
          </div>
          <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
          </button>
        </div>
        <!-- End Logo Header -->
      </div>
      <!-- Navbar Header -->
      <nav
      class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
      >
      <div class="container-fluid">
        <nav
        class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"
        >
        <div class="input-group">
          <div class="input-group-prepend">
            <button type="submit" class="btn btn-search pe-1">
              <i class="fa fa-search search-icon"></i>
            </button>
          </div>
          <input
          type="text"
          placeholder="Search ..."
          class="form-control"
          />
        </div>
      </nav>

      <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
        <li
        class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"
        >
        <a
        class="nav-link dropdown-toggle"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-expanded="false"
        aria-haspopup="true"
        >
        <i class="fa fa-search"></i>
      </a>
      <ul class="dropdown-menu dropdown-search animated fadeIn">
        <form class="navbar-left navbar-form nav-search">
          <div class="input-group">
            <input
            type="text"
            placeholder="Search ..."
            class="form-control"
            />
          </div>
        </form>
      </ul>
    </li>
    <li class="nav-item topbar-icon dropdown hidden-caret">
      <a
      class="nav-link dropdown-toggle"
      href="#"
      id="messageDropdown"
      role="button"
      data-bs-toggle="dropdown"
      aria-haspopup="true"
      aria-expanded="false"
      >
      <i class="fa fa-envelope"></i>
    </a>
    <ul
    class="dropdown-menu messages-notif-box animated fadeIn"
    aria-labelledby="messageDropdown"
    >
    <li>
      <div
      class="dropdown-title d-flex justify-content-between align-items-center"
      >
      Messages
      <a href="#" class="small">Mark all as read</a>
    </div>
  </li>
  <li>
    <div class="message-notif-scroll scrollbar-outer">
      <div class="notif-center">
        <a href="#">
          <div class="notif-img">
            <img
            src="<?php echo base_url(); ?>dist//img/jm_denis.jpg"
            alt="Img Profile"
            />
          </div>
          <div class="notif-content">
            <span class="subject">Jimmy Denis</span>
            <span class="block"> How are you ? </span>
            <span class="time">5 minutes ago</span>
          </div>
        </a>
        <a href="#">
          <div class="notif-img">
            <img
            src="<?php echo base_url(); ?>dist//img/chadengle.jpg"
            alt="Img Profile"
            />
          </div>
          <div class="notif-content">
            <span class="subject">Chad</span>
            <span class="block"> Ok, Thanks ! </span>
            <span class="time">12 minutes ago</span>
          </div>
        </a>
        <a href="#">
          <div class="notif-img">
            <img
            src="<?php echo base_url(); ?>dist//img/mlane.jpg"
            alt="Img Profile"
            />
          </div>
          <div class="notif-content">
            <span class="subject">Jhon Doe</span>
            <span class="block">
              Ready for the meeting today...
            </span>
            <span class="time">12 minutes ago</span>
          </div>
        </a>
        <a href="#">
          <div class="notif-img">
            <img
            src="<?php echo base_url(); ?>dist//img/talha.jpg"
            alt="Img Profile"
            />
          </div>
          <div class="notif-content">
            <span class="subject">Talha</span>
            <span class="block"> Hi, Apa Kabar ? </span>
            <span class="time">17 minutes ago</span>
          </div>
        </a>
      </div>
    </div>
  </li>
  <li>
    <a class="see-all" href="javascript:void(0);"
    >See all messages<i class="fa fa-angle-right"></i>
  </a>
</li>
</ul>
</li>
<li class="nav-item topbar-icon dropdown hidden-caret">
  <a
  class="nav-link dropdown-toggle"
  href="#"
  id="notifDropdown"
  role="button"
  data-bs-toggle="dropdown"
  aria-haspopup="true"
  aria-expanded="false"
  >
  <i class="fa fa-bell"></i>
  <span class="notification">4</span>
</a>
<ul
class="dropdown-menu notif-box animated fadeIn"
aria-labelledby="notifDropdown"
>
<li>
  <div class="dropdown-title">
    You have 4 new notification
  </div>
</li>
<li>
  <div class="notif-scroll scrollbar-outer">
    <div class="notif-center">
      <a href="#">
        <div class="notif-icon notif-primary">
          <i class="fa fa-user-plus"></i>
        </div>
        <div class="notif-content">
          <span class="block"> New user registered </span>
          <span class="time">5 minutes ago</span>
        </div>
      </a>
      <a href="#">
        <div class="notif-icon notif-success">
          <i class="fa fa-comment"></i>
        </div>
        <div class="notif-content">
          <span class="block">
            Rahmad commented on Admin
          </span>
          <span class="time">12 minutes ago</span>
        </div>
      </a>
      <a href="#">
        <div class="notif-img">
          <img
          src="<?php echo base_url(); ?>dist//img/profile2.jpg"
          alt="Img Profile"
          />
        </div>
        <div class="notif-content">
          <span class="block">
            Reza send messages to you
          </span>
          <span class="time">12 minutes ago</span>
        </div>
      </a>
      <a href="#">
        <div class="notif-icon notif-danger">
          <i class="fa fa-heart"></i>
        </div>
        <div class="notif-content">
          <span class="block"> Farrah liked Admin </span>
          <span class="time">17 minutes ago</span>
        </div>
      </a>
    </div>
  </div>
</li>
<li>
  <a class="see-all" href="javascript:void(0);"
  >See all notifications<i class="fa fa-angle-right"></i>
</a>
</li>
</ul>
</li>
<li class="nav-item topbar-icon dropdown hidden-caret">
  <a
  class="nav-link"
  data-bs-toggle="dropdown"
  href="#"
  aria-expanded="false"
  >
  <i class="fas fa-layer-group"></i>
</a>
<div class="dropdown-menu quick-actions animated fadeIn">
  <div class="quick-actions-header">
    <span class="title mb-1">Quick Actions</span>
    <span class="subtitle op-7">Shortcuts</span>
  </div>
  <div class="quick-actions-scroll scrollbar-outer">
    <div class="quick-actions-items">
      <div class="row m-0">
        <a class="col-6 col-md-4 p-0" href="#">
          <div class="quick-actions-item">
            <div class="avatar-item bg-danger rounded-circle">
              <i class="far fa-calendar-alt"></i>
            </div>
            <span class="text">Calendar</span>
          </div>
        </a>
        <a class="col-6 col-md-4 p-0" href="#">
          <div class="quick-actions-item">
            <div
            class="avatar-item bg-warning rounded-circle"
            >
            <i class="fas fa-map"></i>
          </div>
          <span class="text">Maps</span>
        </div>
      </a>
      <a class="col-6 col-md-4 p-0" href="#">
        <div class="quick-actions-item">
          <div class="avatar-item bg-info rounded-circle">
            <i class="fas fa-file-excel"></i>
          </div>
          <span class="text">Reports</span>
        </div>
      </a>
      <a class="col-6 col-md-4 p-0" href="#">
        <div class="quick-actions-item">
          <div
          class="avatar-item bg-success rounded-circle"
          >
          <i class="fas fa-envelope"></i>
        </div>
        <span class="text">Emails</span>
      </div>
    </a>
    <a class="col-6 col-md-4 p-0" href="#">
      <div class="quick-actions-item">
        <div
        class="avatar-item bg-primary rounded-circle"
        >
        <i class="fas fa-file-invoice-dollar"></i>
      </div>
      <span class="text">Invoice</span>
    </div>
  </a>
  <a class="col-6 col-md-4 p-0" href="#">
    <div class="quick-actions-item">
      <div
      class="avatar-item bg-secondary rounded-circle"
      >
      <i class="fas fa-credit-card"></i>
    </div>
    <span class="text">Payments</span>
  </div>
</a>
</div>
</div>
</div>
</div>
</li>

<li class="nav-item topbar-user dropdown hidden-caret">
  <a
  class="dropdown-toggle profile-pic"
  data-bs-toggle="dropdown"
  href="#"
  aria-expanded="false"
  >
  <div class="avatar-sm">
    <img
    src="<?php echo base_url(); ?>dist//img/profile.jpg"
    alt="..."
    class="avatar-img rounded-circle"
    />
  </div>
  <span class="profile-username">
    <span class="op-7">Hi,</span>
    <span class="fw-bold">Hizrian</span>
  </span>
</a>
<ul class="dropdown-menu dropdown-user animated fadeIn">
  <div class="dropdown-user-scroll scrollbar-outer">
    <li>
      <div class="user-box">
        <div class="avatar-lg">
          <img
          src="<?php echo base_url(); ?>dist//img/profile.jpg"
          alt="image profile"
          class="avatar-img rounded"
          />
        </div>
        <div class="u-text">
          <h4>Hizrian</h4>
          <p class="text-muted">hello@example.com</p>
          <a
          href="profile.html"
          class="btn btn-xs btn-secondary btn-sm"
          >View Profile</a
          >
        </div>
      </div>
    </li>
    <li>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="#">My Profile</a>
      <a class="dropdown-item" href="#">My Balance</a>
      <a class="dropdown-item" href="#">Inbox</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="#">Account Setting</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="#">Logout</a>
    </li>
  </div>
</ul>
</li>
</ul>
</div>
</nav>
<!-- End Navbar -->
</div>

<div class="container">
  <div class="page-inner">
    <div
    class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
    >
    <div>
      <h3 class="fw-bold mb-3">Dashboard</h3>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
      <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
      <a href="#" class="btn btn-primary btn-round">Add Customer</a>
    </div>
  </div>
  <div class="row row-card-no-pd">
    <div class="col-12 col-sm-6 col-md-6 col-xl-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div>
              <h6><b>Penjualan Hari Ini</b></h6>
            </div>
            <h4 class="text-info fw-bold" style="margin-top:-5px;">Rp. 4.500.000</h4>
          </div>
          <div class="d-flex justify-content-between mt-2">
            <p class="text-muted mb-0">Jumlah Transaksi</p>
            <p class="text-muted mb-0">50 kali</p>
          </div>
          <div class="d-flex justify-content-between mt-2">
            <p class="text-muted mb-0">Jumlah Barang</p>
            <p class="text-muted mb-0">150 Item</p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-6 col-xl-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div>
              <h6><b>Penjualan Bulan Ini</b></h6>
            </div>
            <h4 class="text-success fw-bold" style="margin-top:-5px;">Rp. 65.500.000</h4>
          </div>
          <div class="d-flex justify-content-between mt-2">
            <p class="text-muted mb-0">Jumlah Transaksi</p>
            <p class="text-muted mb-0">250 kali</p>
          </div>
          <div class="d-flex justify-content-between mt-2">
            <p class="text-muted mb-0">Jumlah Barang</p>
            <p class="text-muted mb-0">350 Item</p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-6 col-xl-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div>
              <h6><b>Total Aset</b></h6>
            </div>
            <h4 class="text-danger fw-bold" style="margin-top:-5px;">Rp. 165.500.000</h4>
          </div>
          <div class="d-flex justify-content-between mt-2">
            <p class="text-muted mb-0">Jumlah Item</p>
            <p class="text-muted mb-0">150 Item</p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-6 col-xl-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div>
              <h6><b>Faktur Terlewat</b></h6>
            </div>
            <h4 class="text-secondary fw-bold">12 Faktur</h4>
          </div>
          <div class="d-flex justify-content-between mt-2">
            <p class="text-muted mb-0"></p>
            <p class="text-muted mb-0"><a href="#" class="btn btn-label-info btn-round me-2">Cek Faktur</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <div class="card-head-row card-tools-still-right">
            <div class="card-title">Aktifitas Terakhir</div>
            <div class="card-tools"><h4 class="text-info fw-bold">Sep 25</h4> </div>
          </div>
        </div>
        <div class="card-body activity">
          <ol class="activity-feed">
            <li class="feed-item feed-item-danger">
              <time class="date">Sep 25, 15:20</time>
              <span class="text"
              >Buat Faktur Penjualan
              <a href="#">"SI 20221233320"</a></span
              >
            </li>
            <li class="feed-item feed-item-danger">
              <time class="date">Sep 25, 12:20</time>
              <span class="text"
              >Buat Faktur Penjualan
              <a href="#">"SI 20221232323"</a></span
              >
            </li>
            <li class="feed-item feed-item-danger">
              <time class="date">Sep 25, 11:20</time>
              <span class="text"
              >Pindah Stok Dari Pusat Ke Serdam
              <a href="#">"SI 20221232323"</a></span
              >
            </li>
            <li class="feed-item feed-item-danger">
              <time class="date">Sep 25, 09:20</time>
              <span class="text"
              >Pindah Stok Dari Pusat Ke Serdam
              <a href="#">"SI 20221232323"</a></span
              >
            </li>
            <li class="feed-item feed-item-danger">
              <time class="date">Sep 25, 08:20</time>
              <span class="text"
              >Pindah Stok Dari Pusat Ke Serdam
              <a href="#">"SI 20221232323"</a></span
              >
            </li>
            <li class="feed-item feed-item-danger">
              <time class="date">Sep 25, 04:20</time>
              <span class="text"
              >Pindah Stok Dari Pusat Ke Serdam
              <a href="#">"SI 20221232323"</a></span
              >
            </li>
          </ol>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <div class="card-head-row card-tools-still-right">
            <div class="card-title">Aktifitas Mendatang</div>
            <div class="card-tools"><h4 class="text-info fw-bold">Sep 26</h4> </div>
          </div>
        </div>
        <div class="card-body activity">
          <ol class="activity-feed">
            <li class="feed-item feed-item-primary">
              <time class="date">Sep 25, 15:20</time>
              <span class="text"
              >Jatuh Tempo
              <a href="#">"SI 20221233320"</a></span
              >
            </li>
            <li class="feed-item feed-item-primary">
              <time class="date">Sep 25, 12:20</time>
              <span class="text"
              >Jatuh Tempo
              <a href="#">"SI 20221232323"</a></span
              >
            </li>
          </ol>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <div class="card-head-row">
            <div class="card-title">History Transfer Stok</div>
            <div class="card-tools">
              <ul
              class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm"
              id="pills-tab"
              role="tablist"
              >
              <li class="nav-item">
                <a
                class="nav-link active"
                id="pills-week"
                data-bs-toggle="pill"
                href="#pills-week"
                role="tab"
                aria-selected="false"
                >See More..</a
                >
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="card-body activity">
        <div class="d-flex">
          <div class="flex-1 ms-3 pt-1">
            <h6 class="text-uppercase fw-bold mb-1">Pusat - Serdam</h6>
            <span class="text-muted">Transfer Dari Pusat Ke Cabang Serdam</span>
          </div>
          <div class="float-end pt-1">
            <small class="text-muted">Feb 25, 8:40 PM <br /> <a href="#">Cek: TRF 00011</a></small>
          </div>
        </div>
        <div class="separator-dashed"></div>


        <div class="d-flex">
          <div class="flex-1 ms-3 pt-1">
            <h6 class="text-uppercase fw-bold mb-1">Serdam - Gama</h6>
            <span class="text-muted">Transfer Dari Serdam Ke Gama</span>
          </div>
          <div class="float-end pt-1">
            <small class="text-muted">Feb 25, 8:40 PM <br /> <a href="#">Cek: TRF 00012</a></small>
          </div>
        </div>
        <div class="separator-dashed"></div>


        <div class="d-flex">
          <div class="flex-1 ms-3 pt-1">
            <h6 class="text-uppercase fw-bold mb-1">Gama - Serdam</h6>
            <span class="text-muted">Transfer Dari Pusat Ke Cabang Serdam</span>
          </div>
          <div class="float-end pt-1">
            <small class="text-muted">Feb 25, 8:40 PM <br /> <a href="#">Cek: TRF 00013</a></small>
          </div>
        </div>
        <div class="separator-dashed"></div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <div class="card-title">Laba/Rugi Tahun ini</div>
      </div>
      <div class="card-body">
        <div class="chart-container">
          <canvas
          id="pieChart"
          style="width: 50%; height: 50%"
          ></canvas>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card" style="height: 400px;"> 
      <div class="card-header">
        <div class="card-title">Penjualan Top Products</div>
      </div>
      <div class="card-body pb-0">
        <div class="d-flex">
          <div class="avatar">
            <img
            src="<?php echo base_url(); ?>dist//img/logoproduct.svg"
            alt="..."
            class="avatar-img rounded-circle"
            />
          </div>
          <div class="flex-1 pt-1 ms-2">
            <h6 class="fw-bold mb-1">CSS</h6>
            <small class="text-muted">Cascading Style Sheets</small>
          </div>
          <div class="d-flex ms-auto align-items-center">
            <h4 class="text-info fw-bold">+$17</h4>
          </div>
        </div>
        <div class="separator-dashed"></div>
        <div class="d-flex">
          <div class="avatar">
            <img
            src="<?php echo base_url(); ?>dist//img/logoproduct.svg"
            alt="..."
            class="avatar-img rounded-circle"
            />
          </div>
          <div class="flex-1 pt-1 ms-2">
            <h6 class="fw-bold mb-1">J.CO Donuts</h6>
            <small class="text-muted">The Best Donuts</small>
          </div>
          <div class="d-flex ms-auto align-items-center">
            <h4 class="text-info fw-bold">+$300</h4>
          </div>
        </div>
        <div class="separator-dashed"></div>
        <div class="d-flex">
          <div class="avatar">
            <img
            src="<?php echo base_url(); ?>dist//img/logoproduct3.svg"
            alt="..."
            class="avatar-img rounded-circle"
            />
          </div>
          <div class="flex-1 pt-1 ms-2">
            <h6 class="fw-bold mb-1">Ready Pro</h6>
            <small class="text-muted"
            >Bootstrap 5 Admin Dashboard</small
            >
          </div>
          <div class="d-flex ms-auto align-items-center">
            <h4 class="text-info fw-bold">+$350</h4>
          </div>
        </div>
        <div class="separator-dashed"></div>
        <div class="pull-in">
          <canvas id="topProductsChart"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>


</div>
</div>

<footer class="footer">
  <div class="container-fluid d-flex justify-content-between">
    <nav class="pull-left">
      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link" href="http://www.themekita.com">
            ThemeKita
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"> Help </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"> Licenses </a>
        </li>
      </ul>
    </nav>
    <div class="copyright">
      2024, made with <i class="fa fa-heart heart text-danger"></i> by
      <a href="http://www.themekita.com">ThemeKita</a>
    </div>
    <div>
      Distributed by
      <a target="_blank" href="https://themewagon.com/">ThemeWagon</a>.
    </div>
  </div>
</footer>
</div>


<script src="<?php echo base_url(); ?>dist/js/core/jquery-3.7.1.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/core/popper.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/core/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/chart.js/chart.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/chart-circle/circles.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/datatables/datatables.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/jsvectormap/jsvectormap.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/jsvectormap/world.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/sweetalert/sweetalert.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/kaiadmin.min.js"></script>
<script>
  var pieChart = document.getElementById("pieChart").getContext("2d");

   var myPieChart = new Chart(pieChart, {
        type: "pie",
        data: {
          datasets: [
            {
              data: [50, 35, 15],
              backgroundColor: ["#1d7af3", "#f3545d", "#fdaf4b"],
              borderWidth: 0,
            },
          ],
          labels: ["Pendapatan", "Pengeluaran", "Hpp"],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          legend: {
            position: "bottom",
            labels: {
              fontColor: "rgb(154, 154, 154)",
              fontSize: 11,
              usePointStyle: true,
              padding: 20,
            },
          },
          pieceLabel: {
            render: "percentage",
            fontColor: "white",
            fontSize: 14,
          },
          tooltips: false,
          layout: {
            padding: {
              left: 20,
              right: 20,
              top: 20,
              bottom: 20,
            },
          },
        },
      });
</script>
</body>
</html>
