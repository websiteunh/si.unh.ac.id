
<?php $row = $dt_artikel->row(); ?>
  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Informasi Details</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="home">Home</a></li>
            <li class="current"><?=$row->kategori?></li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <div class="container">
      <div class="row">

        <div class="col-lg-8">

          <!-- Blog Details Section -->
          <section id="blog-details" class="blog-details section">
            <div class="container">

              <article class="article">
                <?php 
                if(!isset($row->foto) AND $row->foto==""){
                  $foto = "";
                }else{
                  $foto = $row->foto;
                }

                if($foto!=""){
                ?>
                <div class="post-img">
                  <img width="100%" src="assets/uploads/images/<?=$foto?>" alt="<?=$row->judul?>" class="img-fluid">
                </div>

                <?php } ?>

                <h2 class="title"><?=$row->judul?></h2>

                <div class="meta-top">
                  <ul>                    
                    <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <?=tgl_indo(substr($row->created_at, 0,10))?> </li>
                    <li class="d-flex align-items-center"><i class="bi bi-files"></i> <a href="informasi/<?=$row->slug_k?>"><?=$row->kategori?></a></li>
                  </ul>
                </div><!-- End meta top -->

                <div class="content">
                  
                  <p><?=$row->isi?></p>

                  <?php if(!is_null($row->embedfile) && $row->embedfile!=''){ ?>
                  
                  <div class="embed-responsive embed-responsive-16by9">
                    <?php 
                    $linkBaru = str_replace('view?usp=sharing','preview',$row->embedfile);
                    ?>                    
                    <iframe src="<?=$linkBaru?>" width="100%" height="600" allow="autoplay"></iframe>

                  </div>

                  <?php } ?>

                </div><!-- End post content -->                

              </article>

            </div>
          </section><!-- /Blog Details Section -->
          
        </div>

        <?php include "asideinfo.php"; ?>

      </div>
    </div>

  </main>
