  <?php $setting = $this->m_admin->getByID("md_setting","id_setting",1)->row();?>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-danger elevation-4">
    <!-- Brand Logo -->
    <a href="w3b" class="brand-link">      
      <span class="brand-text font-weight-light"><?php echo $setting->perusahaan ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <?php     
        $foto = $this->session->userdata('foto');        
        if($foto==""){
          $foto = "user.png";
        }else{
          $foto = $foto;
        }              
        ?>
        <div class="image">
          <img src="assets/uploads/images/<?php echo $foto ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $this->session->userdata('nama') ?></a>
        </div>
      </div>

      
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>
      <!-- Sidebar Menu -->

      
      <nav class="mt-2">        
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">          
            <?php 
            $act="";$show="";
            if(setMenu('dashboard')!=''){           
              $show = 'd-none';                        
            }else{            
              if($isi=='dashboard'){
                $act = "active"; 
                $show = "menu-open"; 
              }
            }              
            ?>
            <li class="nav-item <?php echo $show ?>">
              <a href="a4dm11n/dashboard" class="nav-link <?php echo ($isi=='dashboard')?'active':'';?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard<span class="right badge badge-danger"></span></p>
              </a>
            </li>
            <?php 
            $act="";$show="";
            if(setMenu('infografis')!=''){           
              $show = 'd-none';                        
            }else{            
              if($isi=='infografis'){
                $act = "active"; 
                $show = "menu-open"; 
              }
            }              
            ?>
            <li class="nav-item <?php echo $show ?>">
              <a href="a4dm11n/infografis" class="nav-link <?php echo ($isi=='infografis')?'active':'';?>">
                <i class="nav-icon fas fa-check"></i>
                <p>Infografis<span class="right badge badge-danger"></span></p>
              </a>
            </li>                       
            <?php 
            $act="";$show="";
            if(setMenu('testimoni')!='' AND setMenu('dosen')!='' AND setMenu('kategori')!='' AND setMenu('informasi')!='' AND setMenu('artikel')!='' AND setMenu('slide')!=''  AND setMenu('profils')!='' AND setMenu('kerjasama')!=''){           
              $show = 'd-none';                        
            }else{              
              if($isi=='testimoni' OR $isi=='dosen' OR $isi=='kategori' OR $isi=='informasi' OR $isi=='artikel' OR $isi=='slide'  OR $isi=='profils' OR $isi=='kerjasama'){
                $act = "active"; 
                $show = "menu-open"; 
              }
            }              
            ?>            
            <li class="nav-item <?php echo $show ?>">
              <a href="#" class="nav-link <?php echo $act ?>">
                <i class="nav-icon fas fa-folder"></i>
                <p>Master Umum<i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview ml-3">                
                <li class="nav-item">
                  <a <?= setMenu('dosen') ?> href="master/dosen" class="nav-link <?php echo ($isi=='dosen')?'active':'';?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Dosen</p>
                  </a>
                </li>                
                <li class="nav-item">
                  <a <?= setMenu('kategori') ?> href="master/kategori" class="nav-link <?php echo ($isi=='kategori')?'active':'';?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kategori</p>
                  </a>
                </li>                
                <li class="nav-item">
                  <a <?= setMenu('informasi') ?> href="master/informasi" class="nav-link <?php echo ($isi=='informasi')?'active':'';?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Informasi</p>
                  </a>
                </li>                                
                <li class="nav-item">
                  <a <?= setMenu('profils') ?> href="front/profil" class="nav-link <?php echo ($isi=='profils')?'active':'';?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Profil</p>
                  </a>
                </li>        
                <li class="nav-item">
                  <a <?= setMenu('artikel') ?> href="front/artikel" class="nav-link <?php echo ($isi=='artikel')?'active':'';?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Artikel</p>
                  </a>
                </li>                      
                <li class="nav-item">
                  <a <?= setMenu('slide') ?> href="front/slide" class="nav-link <?php echo ($isi=='slide')?'active':'';?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Slide</p>
                  </a>
                </li>                      
                <li class="nav-item">
                  <a <?= setMenu('kerjasama') ?> href="front/kerjasama" class="nav-link <?php echo ($isi=='kerjasama')?'active':'';?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kerjasama</p>
                  </a>
                </li>                      
                <li class="nav-item">
                  <a <?= setMenu('testimoni') ?> href="front/testimoni" class="nav-link <?php echo ($isi=='testimoni')?'active':'';?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Testimoni</p>
                  </a>
                </li>                      
              </ul>
            </li>            
            <?php 
            $act="";$show="";
            if(setMenu('user_type')!='' AND setMenu('user')!=''){           
              $show = 'd-none';                        
            }else{              
              if($isi=='user_type' OR $isi=='user'){
                $act = "active"; 
                $show = "menu-open"; 
              }
            }              
            ?>            
            <li class="nav-item <?php echo $show ?>">
              <a href="#" class="nav-link <?php echo $act ?>">
                <i class="nav-icon fas fa-folder"></i>
                <p>Master User<i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview ml-3">                
                <li class="nav-item">
                  <a <?= setMenu('user') ?> href="master/user" class="nav-link <?php echo ($isi=='user')?'active':'';?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>User</p>
                  </a>
                </li>                          
                <li class="nav-item">
                  <a <?= setMenu('user') ?> href="master/user_type" class="nav-link <?php echo ($isi=='user_type')?'active':'';?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>User Type</p>
                  </a>
                </li>                          
              </ul>
            </li>

            <?php 
            $act="";$show="";
            if(setMenu('mahasiswa')!='' AND setMenu('judul')!='' AND setMenu('kp')!='' AND setMenu('skripsi')!=''){
              $show = 'd-none';                        
            }else{              
              if($isi=='mahasiswa' OR $isi=='judul' OR $isi=='kp' OR $isi=='skripsi'){
                $act = "active"; 
                $show = "menu-open"; 
              }
            }              
            ?>            
            <li class="nav-item <?php echo $show ?>">
              <a href="#" class="nav-link <?php echo $act ?>">
                <i class="nav-icon fas fa-book"></i>
                <p>Kemahasiswaan<i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview ml-3">                
                <li class="nav-item">
                  <a <?= setMenu('mahasiswa') ?> href="master/mahasiswa" class="nav-link <?php echo ($isi=='mahasiswa')?'active':'';?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Mahasiswa</p>
                  </a>
                </li>                                        
                <li class="nav-item">
                  <a <?= setMenu('judul') ?> href="transaksi/judul" class="nav-link <?php echo ($isi=='judul')?'active':'';?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pengajuan Judul</p>
                  </a>
                </li>                                          
                <li class="nav-item">
                  <a <?= setMenu('kp') ?> href="transaksi/kp" class="nav-link <?php echo ($isi=='kp')?'active':'';?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>File KP</p>
                  </a>
                </li>          
                <li class="nav-item">
                  <a <?= setMenu('skripsi') ?> href="transaksi/skripsi" class="nav-link <?php echo ($isi=='skripsi')?'active':'';?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>File Skripsi</p>
                  </a>
                </li>                                                                          
              </ul>
            </li>

                                                        
            <?php 
            $act="";$show="";
            if(setMenu('setting')!=''){           
              $show = 'd-none';                        
            }else{            
              if($isi=='setting'){
                $act = "active"; 
                $show = "menu-open"; 
              }
            }              
            ?>                  
            <li class="nav-item <?php echo $show ?>">
              <a <?= setMenu('setting') ?> href="master/setting" class="nav-link <?php echo ($isi=='setting')?'active':'';?>">
                <i class="nav-icon fas fa-cog"></i>
                <p>Setting<span class="right badge badge-danger"></span></p>
              </a>
            </li>                       
          </ul>
        
      </nav>
      
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo $title ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <?php echo $bread ?>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content">
      <div class="container-fluid">