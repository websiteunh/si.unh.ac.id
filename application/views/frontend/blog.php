
  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Blog</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
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

                <?php           
                foreach($dt_artikel->result() AS $data){            
                ?>

                <div class="col-12">
                  <article>

                    <div class="post-img">
                      <img width="100%" src="assets/uploads/artikel/<?=$data->gambar1?>" alt="<?$data->judul?>" class="img-fluid">
                    </div>

                    <h2 class="title">
                      <a href="detail/<?=$data->permalink?>"><?=$data->judul?></a>
                    </h2>

                    <div class="meta-top">
                      <ul>
                        <li class="d-flex align-items-center"><i class="bi bi-person"></i> <?=$data->nama_lengkap?></li>
                        <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <?=tgl_indo($data->tgl_buat)?> </li>
                        <li class="d-flex align-items-center"><i class="bi bi-files"></i> <a href="kategori/<?=$data->permalink_ka?>"><?=$data->kategori?></a></li>
                        <li class="d-flex align-items-center"><i class="bi bi-eye"></i><?=$data->baca?> kali</li>
                      </ul>
                    </div>

                    <div class="content">
                      <p>
                        <?=$data->preview?>
                      </p>

                      <div class="read-more">
                        <a href="detail/<?=$data->permalink?>">Selengkapnya</a>
                      </div>
                    </div>

                  </article>
                </div><!-- End post list item -->

                <?php } ?>

              </div><!-- End blog posts list -->

            </div>

          </section><!-- /Blog Posts Section -->

          <!-- Blog Pagination Section -->
          <section id="blog-pagination" class="blog-pagination section">

            <div class="container">
              <div class="col-12">      
                <?php echo $pagination; ?>
              </div>
            </div>

          </section><!-- /Blog Pagination Section -->

        </div>

        <?php include "asideblog.php"; ?>

      </div>
    </div>

  </main>
