<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style type="text/css">
.label-kategori{
  background-color: blue;
  padding: 4px;
  color: white;
  border-radius: 4px;
  font-style: italic;
  font-size: 12px; 
}
.carousel-image {
    height: 600px; /* Sesuaikan tinggi sesuai kebutuhan */
    object-fit: cover; /* Memastikan gambar memenuhi area dengan proporsi yang tepat */
}

.text-overlay {
    background-color: rgba(255, 255, 255, 0.7); /* Transparan putih */
    padding: 10px;
    border-radius: 8px; /* Opsional: membuat sudut melengkung */
    text-align: center; /* Pusatkan teks */
}

.article-section {
    padding: 40px 0;
/*    background-color: #f9f9f9;*/
}

.article-box {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 30px;
    transition: transform 0.3s ease;
}

.article-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.article-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.article-content {
    padding: 20px;
}

.article-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
}

.article-meta {
    font-size: 14px;
    color: #666;
    margin-bottom: 15px;
}

.article-preview {
    font-size: 16px;
    color: #333;
    margin-bottom: 20px;
}

.btn {
    text-decoration: none;
    font-weight: bold;
    padding: 8px 15px;
    border-radius: 5px;
}

.btn-primary {
    background-color: #007bff;
    color: #fff;
}

.btn-primary:hover {
    background-color: #0056b3;
    color: #fff;
}

.carousel-image {
    width: 100%;
    height: auto;
    object-fit: cover;
}

/* Mobile-Specific Styling */
@media (max-width: 768px) {
    .carousel-image {
        max-height: 300px; /* Adjust the height for better view on small screens */
    }
    .testimonials .swiper-slide {
      max-width: 100%; /* Pastikan hanya satu kotak */
      flex-basis: 100%;
   }
}

.stars i {
  color: #fbc02d;
}

.swiper-button-next, .swiper-button-prev {
  color: #333;
}


</style>
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>


  <main class="main">

    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
          <?php 
          $no=1;
          $sql = $this->m_admin->getByID("md_slide","status","publish");
          foreach($sql->result() AS $data){
            if($no==1) $aktif = "active";
              else $aktif = "";
          ?>
          <div class="carousel-item <?=$aktif?>">
              <img src="assets/uploads/artikel/<?=$data->gambar?>" alt="<?=$data->gambar?>" class="d-block w-100 carousel-image">
              <div class="carousel-caption d-none d-md-block text-overlay">
                  <h5><b><?=$data->judul?></b></h5>
                  <p class="text-black"><?=$data->isi?></p>
              </div>
          </div>
          <?php 
          $no++;
          } ?>
      </div>
      <!-- Navigation Controls -->
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
      </button>
  </div>


    <!-- Call To Action Section -->
    <section id="call-to-action" class="call-to-action section light-background">

      <div class="container">

        <div class="row">
          <div class="col-xl-9 text-center text-xl-start">
            <h3><?=getProfil(1)['profil']?></h3>
            <p><?=getProfil(1)['deskripsi']?></p>
          </div>
          <div class="col-xl-3 cta-btn-container text-center">
            <a class="cta-btn align-middle" href="https://pmb.unh.ac.id">Daftar Sekarang</a>
          </div>
        </div>

      </div>

    </section><!-- /Call To Action Section -->

    <section id="about" class="about section">

      <div class="container">

        <div class="row gy-4">
          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <h3><?=getProfil(2)['profil']?></h3>
            <img src="assets/uploads/artikel/<?=getProfil(2)['gambar']?>" class="img-fluid rounded-4 mb-4" alt="<?=getProfil(2)['profil']?>">                        
          </div>
          <div class="col-lg-8" data-aos="fade-up" data-aos-delay="250">
            <div class="content ps-0 ps-lg-5">
              

              <p><?=getProfil(2)['deskripsi']?></p>            
              
            </div>
          </div>
        </div>

      </div>

    </section><!-- /About Section -->

    <section class="main-section">
      <div class="container">
          <div class="row">
              <!-- Bagian Artikel (8 kolom) -->
              <div class="col-md-8">
                  <h3>Blog Terbaru</h3>
                  <section class="article-section">                      
                      <div class="row">
                          <?php 
                          $articles = $this->db->query("SELECT md_artikel.*, md_artikel_kategori.kategori FROM md_artikel 
                              JOIN md_artikel_kategori ON md_artikel.id_artikel_kategori = md_artikel_kategori.id_artikel_kategori
                              WHERE md_artikel.status = 'publish' ORDER BY md_artikel.tgl_buat DESC LIMIT 0,4");
                          foreach ($articles->result() as $article) { 
                            if(!isset($article->gambar1) OR $article->gambar1==""){
                              $foto = "files.png";
                            }else{
                              $foto = $article->gambar1;
                            }                            
                            ?>
                          <div class="col-md-6">
                              <div class="article-box">
                                  <a href="detail/<?=$article->permalink?>">
                                    <img src="assets/uploads/artikel/<?=$foto?>" alt="<?=$article->judul?>" class="article-image">
                                  </a>
                                  <div class="article-content">
                                      <a href="detail/<?=$article->permalink?>">
                                        <h3 class="article-title"><?=$article->judul?></h3>
                                      </a>
                                      <p class="article-meta">
                                          <span class="article-date"><?=date('d M Y', strtotime($article->tgl_buat))?></span> // 
                                          <span class="article-category"><?=$article->kategori?></span>
                                      </p>
                                      <p class="article-preview"><?=$article->preview?>...</p>
                                      <a href="detail/<?=$article->permalink?>" class="btn btn-primary btn-sm">Selengkapnya</a>
                                  </div>
                              </div>
                          </div>
                          <?php } ?>
                      </div>
                  </section>
              </div>
              <!-- Bagian Pengumuman (4 kolom) -->
              <div class="col-md-4">
                <h3>Pengumuman</h3>                      
                <div class="recent-posts-widget widget-item">
                  <section class="announcement-section">                      
                        <?php 
                        $announcements = $this->db->query("SELECT md_informasi.*, md_kategori.kategori, md_kategori.slug AS slugk FROM md_informasi 
                          JOIN md_kategori ON md_informasi.id_kategori = md_kategori.id_kategori
                          WHERE md_informasi.status = '1' ORDER BY md_informasi.id_informasi DESC LIMIT 0,10");
                        foreach ($announcements->result() as $announcement) { 
                          if(!isset($announcement->foto) OR $announcement->foto==""){
                            $foto = "files.png";
                          }else{
                            $foto = $announcement->foto;
                          }
                          ?>
                        
                          <div class="post-item">
                            <a href="info/<?=$announcement->slug?>">
                              <img width="100%" src="assets/uploads/images/<?=$foto?>" alt="<?=$announcement->judul?>" class="flex-shrink-0">
                            </a>
                            <div>
                              <a href="info/<?=$announcement->slug?>">
                                <h4><a href="info/<?=$announcement->slug?>"><?=$announcement->judul?></a></h4>
                                <time datetime="<?=$announcement->created_at?>"><?=tgl_indo(substr($announcement->created_at, 0,10))?></time>
                              </a>
                              <a href="informasi/<?=$announcement->slugk?>">
                                <span class="label-kategori"><?=$announcement->kategori?></span>
                              </a>
                            </div>
                          </div>

                        <?php } ?>
                      
                  </section>
                </div>
              </div>
          </div>
      </div>
  </section>

  <section id="testimonials" class="testimonials section">
   <?php 
   $amb = $this->m_admin->getByID("md_testimoni", "status", "publish");
   if ($amb->num_rows() > 0) { 
   ?>
   <div class="container">
      <h3>Kata Alumni</h3>

      <!-- Swiper -->
      <div class="swiper testimonials-slider">
         <div class="swiper-wrapper">
            <?php           
            foreach ($amb->result() as $key => $value) { 
               $foto = isset($value->gambar) && $value->gambar != "" ? $value->gambar : "user.png";
            ?>
            <div class="swiper-slide">
               <div class="testimonial-item">
                  <img src="assets/uploads/artikel/<?= $foto ?>" class="testimonial-img" alt="<?= $value->nama ?>">
                  <h3><?= $value->nama ?></h3>
                  <h4><?= $value->keterangan ?></h4>
                  <div class="stars">
                     <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                  </div>
                  <p>
                     <i class="bi bi-quote quote-icon-left"></i>
                     <small><span><?= $value->isi ?></span></small>  
                     <i class="bi bi-quote quote-icon-right"></i>
                  </p>
               </div>
            </div>
            <?php } ?>          
         </div>

         <!-- Optional navigation buttons -->
         <div class="swiper-button-next"></div>
         <div class="swiper-button-prev"></div>
         <div class="swiper-pagination"></div>
      </div>
   </div>
   <?php } ?>
</section>


    

    <section id="clients" class="clients section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-0 clients-wrap">

          <?php 
          $amb = $this->db->query("SELECT * FROM md_kerjasama WHERE status = 'publish'");          
          foreach ($amb->result() as $key => $value) {            
          ?>

          <div class="col-xl-3 col-md-4 client-logo">
            <img src="assets/uploads/artikel/<?=$value->gambar?>" class="img-fluid" alt="<?=$value->judul?>">
          </div><!-- End Client Item -->

          <?php } ?>

        </div>

      </div>

    </section><!-- /Clients Section -->

  </main>

<script>

  

   document.addEventListener('DOMContentLoaded', function () {
      const swiper = new Swiper('.testimonials-slider', {
         loop: true, // Aktifkan looping
         autoplay: {
            delay: 5000, // Autoscroll setiap 5 detik
            disableOnInteraction: false,
         },
         slidesPerView: 3, // Default: 3 kotak per slide
         spaceBetween: 20, // Jarak antar kotak
         pagination: {
            el: '.swiper-pagination',
            clickable: true,
         },
         navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
         },
         breakpoints: {
            // Tampilan untuk layar >= 1024px
            1024: {
               slidesPerView: 3,
               spaceBetween: 20,
            },
            // Tampilan untuk layar >= 768px
            768: {
               slidesPerView: 2,
               spaceBetween: 15,
            },
            // Tampilan untuk layar < 768px
            576: {
               slidesPerView: 1, // 1 kotak per slide
               spaceBetween: 10,
            },
         },

      });
   });
</script>
