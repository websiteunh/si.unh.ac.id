
  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Informasi</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="home">Home</a></li>
            <li class="current"><?=$info?></li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <div class="container">
      <div class="row">

        <div class="col-lg-8">

          <!-- Blog Posts Section -->
          <section id="blog-posts" class="blog-posts section">

            <div class="container">


              <div class="row gy-4">                

                <?php                 
                if($dt_artikel->num_rows()>0){
                  foreach ($dt_artikel->result() as $key) {            
                    if(!isset($key->foto) AND $key->foto==""){
                      $foto = "user.png";
                    }else{
                      $foto = $key->foto;
                    }
                  ?>
                  <div class="border p-2 d-flex align-items-start">
                    <!-- Tambahkan Gambar -->
                    <img width="100%" src="assets/uploads/images/<?=$foto?>" alt="<?=$key->judul?>" class="img-thumbnail me-3" style="width: 100px; height: auto; object-fit: cover;">
                    
                    <!-- Konten -->
                    <div>
                      <a href="info/<?=$key->slug?>">
                        <h3><?=$key->judul?></h3>                        
                        <p>
                          <b>Kategori: </b><?=$key->kategori?> 
                          <i class="bi bi-clock"></i> <?=tgl_indo(substr($key->created_at, 0,10))?> 
                        </p>
                      </a>
                    </div>
                  </div>
                <?php 
                  } 
                }else{
                  echo "Data tidak ditemukan";
                }
                ?>

                
              </div>              

            </div>

          </section><!-- /Blog Posts Section -->          

        </div>

        <?php include "asideinfo.php"; ?>

      </div>
    </div>

  </main>
