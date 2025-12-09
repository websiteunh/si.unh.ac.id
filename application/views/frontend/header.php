<!DOCTYPE html>
<html lang="en">
<base href="<?php echo base_url(); ?>" />
<?php $setting = $this->m_admin->getByID("md_setting","id_setting",1)->row();?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?=$title?></title>
  <?php   
  if(isset($description)) $desc = $description;
    else $desc = "";
  if(isset($keywords)) $keywords_ = $keywords;
    else $keywords_ = "";  
  ?>
  <meta name="description" content="<?php echo $desc; ?>"/>
  <meta name="keywords" content="<?php echo $keywords_; ?>"/>
  <meta name="author" content="sisteminformasiunh"/>    

  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-SL8H7ZN05Y"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-SL8H7ZN05Y');
  </script>
  <!-- Favicons -->
  <link rel="shortcut icon" href="assets/uploads/images/<?php echo $setting->fav ?>" />

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/frontend/assets/css/main.css" rel="stylesheet">
  
</head>

<body class="index-page">
  <?php $this->hitung->cari(); ?>

  <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content rounded-0">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Mahasiswa</h5>          
        </div>
        <div class="modal-body align-items-center">
          <form action="home/loginPost" method="POST">
            <div class="form-group">
              <label for="exampleInputEmail1">Username</label>
              <input type="number" autocomplete="off" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">               
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" autocomplete="off" name="password" class="form-control" id="exampleInputPassword1">
            </div>              
            <button type="submit" class="btn btn-primary mt-3">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <header id="header" class="header sticky-top">

    <div class="topbar d-flex align-items-center light-background d-none">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:<?=$setting->email?>"><?=$setting->email?></a></i>          
        </div>
        <div class="social-links d-none d-md-flex align-items-center">          
          <a href="<?=$setting->instagram?>" class="instagram"><i class="bi bi-instagram"></i></a>          
        </div>
      </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-cente">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="home" class="logo d-flex align-items-center">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <img src="assets/uploads/images/<?php echo $setting->logo ?>" alt="">
          <h1 class="sitename"><?=$setting->perusahaan?></h1>

        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="home" class="<?=($set=="home")?'active':'';?>">Home<br></a></li>            
            <?php 
            $dt = $this->db->query("SELECT md_informasi.*  FROM md_informasi JOIN md_kategori ON md_informasi.id_kategori = md_kategori.id_kategori 
              WHERE md_informasi.status = 1 AND md_kategori.slug = 'profil'");
            if($dt->num_rows()>0){
            ?>
            <li class="dropdown"><a class="<?=($set=="profil")?'active':'';?>" href="#"><span>Profil</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <?php                 
                foreach ($dt->result() as $key => $value) {                  
                ?>
                <li><a href="p/<?=$value->slug?>"><?=$value->judul?></a></li>                
                <?php } ?>
              </ul>
            </li>           
            <?php } ?>
            <li><a href="dosen" class="<?=($set=="dosen")?'active':'';?>">Dosen</a></li>                        
            <li class="dropdown"><a href="#" class="<?=($set=="informasi")?'active':'';?>"><span>Informasi</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <?php 
                $dt = $this->db->query("SELECT * FROM md_kategori WHERE slug <> 'profil' AND slug <> 'akreditasi'");
                foreach ($dt->result() as $key => $value) {                  
                ?>
                <li><a href="informasi/<?=$value->slug?>"><?=$value->kategori?></a></li>                
                <?php } ?>
              </ul>
            </li>                        
            <?php 
            $dt = $this->db->query("SELECT md_informasi.*  FROM md_informasi JOIN md_kategori ON md_informasi.id_kategori = md_kategori.id_kategori 
              WHERE md_informasi.status = 1 AND md_kategori.slug = 'akreditasi'");
            if($dt->num_rows()>0){
            ?>
            <li class="dropdown"><a href="#" class="<?=($set=="akreditasi")?'active':'';?>"><span>Akreditasi</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <?php                 
                foreach ($dt->result() as $key => $value) {                  
                ?>
                <li><a href="a/<?=$value->slug?>"><?=$value->judul?></a></li>                
                <?php } ?>
              </ul>
            </li>           
            <?php } ?>                        
            <?php 
            if(isset($this->session->id_user_type)){
              if($this->session->id_user_type==3){
                $nama = $this->session->nama;
                echo "<li><a href=\"a4dm11n/dashboard\">Hi, $nama </a></li>";
              }else{
                echo "<li><a style=\"cursor: pointer;\" data-toggle=\"modal\" data-target=\"#staticBackdrop\">Mahasiswa</a></li>";
              } 
            }else{
            ?>
              <li><a data-toggle="modal" style="cursor: pointer;" data-target="#staticBackdrop">Mahasiswa</a></li>
            <?php } ?>
            <li><a href="blog" class="<?=($set=="blog")?'active':'';?>">Blog</a></li>            
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>        

      </div>

    </div>

  </header>

  