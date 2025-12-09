<?php 
$row = $dt_profil->row();
?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Profil</h1>
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

               
               <h4><?= $row->profil ?></h4>               

               <p>
                 <?= $row->deskripsi ?>
               </p>

              <?php 
              if(!is_null($row->gambar)){
              ?>

                <img src="assets/uploads/artikel/<?=$row->gambar?>" class="img-fluid" width="100%">

              <?php } ?>
                
              </div>              

            </div>

          </section><!-- /Blog Posts Section -->          

        </div>

        <?php include "asideinfo.php"; ?>

      </div>
    </div>

  </main>
