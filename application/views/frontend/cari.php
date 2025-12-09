
  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Blog</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="home">Home</a></li>
            <li class="current">Blog</li>
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

                <h3>Hasil Pencarian : <font color="red"> <?=$cari?> </font></h3>

                <?php 
                $cek = $this->db->query("SELECT md_artikel.*, md_artikel_kategori.kategori FROM md_artikel
                  JOIN md_artikel_kategori ON md_artikel.id_artikel_kategori = md_artikel_kategori.id_artikel_kategori
                  WHERE (md_artikel.judul LIKE '%$cari%'
                  OR md_artikel.preview LIKE '%$cari%'                  
                  OR md_artikel_kategori.kategori = '$cari')
                  AND md_artikel.status = 'publish'
                  ORDER BY md_artikel.id_artikel DESC");
                foreach ($cek->result() as $key) {            
                ?>
                <div class="border p-2">
                  <a href="detail/<?=$key->permalink?>">
                    <h3><?=$key->judul?></h3>
                  </a>
                  <p><?=$key->preview?></p>
                  <p><b>Kategori: </b><?=$key->kategori?></p>                                      
                </div>
              <?php } ?>
                
              </div>              

            </div>

          </section><!-- /Blog Posts Section -->          

        </div>

        <?php include "asideblog.php"; ?>

      </div>
    </div>

  </main>
