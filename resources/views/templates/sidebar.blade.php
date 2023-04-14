 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <!-- Brand Logo -->
     <a href="index3.html" class="brand-link">
         <img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3" style="opacity: .8">
         <span class="brand-text font-weight-light">AdminLTE 3</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <!-- Sidebar user panel (optional) -->
         <div class="user-panel mt-3 pb-3 mb-3 d-flex">
             <div class="image">
                 <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                     alt="User Image">
             </div>
             <div class="info">
                 <a href="#" class="d-block">{{ auth()->user()->name }}</a>
             </div>
         </div>
         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                 data-accordion="false">
                 <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                 <li class="nav-item @if ($menu == 'Dashboard') menu-open @endif">
                     <a href="#" class="nav-link  @if ($menu == 'Dashboard') active @endif">
                         <i class="nav-icon fas fa-tachometer-alt"></i>
                         <p>
                             Dashboard
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         {{-- <li class="nav-item">
                <a href="./index.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v1</p>
                </a>
              </li> --}}
                         <li class="nav-item">
                             <a href="{{ route('dashboard') }}"
                                 class="nav-link @if ($menu == 'Dashboard') active @endif">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Dashboard v2</p>
                             </a>
                         </li>
                         {{-- <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v3</p>
                </a>
              </li> --}}
                     </ul>
                 </li>
                 <li class="nav-item">
                 </li>
                 @if(auth()->user()->hak_akses == 1 || auth()->user()->hak_akses == 3)
                 <li class="nav-header">PENDAFTARAN</li>
                 <li class="nav-item">
                     <a href="{{ route('pendaftaran_pasien') }}"
                         class="nav-link @if ($menu == 'Cari Pasien') active @endif">
                         <i class="nav-icon fas fa-calendar-alt"></i>
                         <p>
                             Cari Pasien
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('antrianpasien') }}"
                         class="nav-link @if ($menu == 'Data Antrian') active @endif">
                         <i class="nav-icon fas fa-calendar-alt"></i>
                         <p>
                             Data Antrian
                         </p>
                     </a>
                 </li>
                 <li class="nav-header">KASIR</li>
                 <li class="nav-item">
                     <a href="{{ route('pembayaran') }}"
                         class="nav-link @if ($menu == 'Pembayaran') active @endif">
                         <i class="nav-icon fas fa-calendar-alt"></i>
                         <p>
                             Pembayaran
                         </p>
                     </a>
                 </li>
                 @endif

                 @if (auth()->user()->hak_akses == 1 || auth()->user()->hak_akses == 2)
                 <li class="nav-header">ERM</li>
                 <li class="nav-item">
                     <a href="{{ route('indexerm') }}" class="nav-link @if ($menu == 'index_erm') active @endif">
                         <i class="nav-icon fas fa-calendar-alt"></i>
                         <p>
                             Data Pasien
                         </p>
                     </a>
                 </li>
                 @endif
                 <li class="nav-header">Akun</li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="nav-icon far fa-circle text-danger"></i>
                         <p class="text">Info</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a onclick="logout()"class="nav-link">
                         <i class="nav-icon far fa-circle text-warning"></i>
                         <p>Logout</p>
                     </a>
                 </li>
             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>
 <script>
     function logout() {
         Swal.fire({
             icon: 'info',
             title: 'Anda yakin ingin logout ?',
             showDenyButton: true,
             confirmButtonText: 'Batal',
             denyButtonText:'Logout',
         }).then((result) => {
             /* Read more about isConfirmed, isDenied below */
             if (result.isConfirmed) {

             } else if (result.isDenied) {
                location.href = "<?= route('logout') ?>";
             }
         })
     }
 </script>
