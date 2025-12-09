<style>
    @media (max-width: 768px) {
        .author-detail .d-flex {
            flex-direction: column; /* Susun vertikal untuk mobile */
            align-items: flex-start; /* Selaraskan ke kiri */
        }
        .author-detail .author-photo {
            margin-right: 0; /* Hapus jarak untuk tampilan mobile */
            margin-bottom: 10px; /* Tambahkan jarak bawah */
        }
        .author-detail .author-info {
            text-align: center; /* Teks tengah untuk tampilan mobile */
            width: 100%; /* Pastikan lebar penuh */
        }
    }
</style>
<link rel="stylesheet" type="text/css" href="assets/js/jquery.floating-social-share.min.css" />
<?php $row = $dt_artikel->row(); ?>
  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Blog Details</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="home">Home</a></li>
            <li class="current">Blog Details</li>
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
                if(!isset($row->gambar1) AND $row->gambar1 == ""){
                    $foto = "user.png";
                } else {
                    $foto = $row->gambar1;
                }
                ?>
                <div class="post-img">
                    <img width="100%" src="assets/uploads/artikel/<?=$foto?>" alt="<?=$row->judul?>" class="img-fluid">
                </div>

                <h2 class="title"><?=$row->judul?></h2>

                <div class="meta-top">
                    <ul>
                        <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="penulis/<?=$row->created_by?>"> <?=$row->nama_lengkap?> </a></li>
                        <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <?=tgl_indo($row->tgl_buat)?> </li>
                        <li class="d-flex align-items-center"><i class="bi bi-files"></i> <a href="kategori/<?=$row->permalink_ka?>"><?=$row->kategori?></a></li>
                        <li class="d-flex align-items-center"><i class="bi bi-eye"></i><?=$row->baca?> kali</li>
                    </ul>
                </div><!-- End meta top -->

                <div class="content">
                    <p><?=$row->isi?></p>
                </div><!-- End post content -->    

                <!-- Detail Penulis -->
                <div class="author-detail" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;">
                    <?php 
                    if (!isset($row->fotos) || $row->fotos == "") {
                        $foto_penulis = "user.png"; // Default photo for authors
                    } else {
                        $foto_penulis = $row->fotos;
                    }
                    ?>
                    <div class="d-flex align-items-center flex-wrap">
                        <div class="author-photo" style="margin-right: 15px;">
                            <a href="penulis/<?=$row->created_by?>">
                              <img src="assets/uploads/images/<?=$foto_penulis?>" alt="<?=$row->nama_lengkap?>" 
                                 class="img-fluid rounded-circle" 
                                 style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">
                            </a>
                        </div>
                        <div class="author-info" style="flex: 1; min-width: 200px;">
                            <a href="penulis/<?=$row->created_by?>">
                              <b><?=$row->nama_lengkap?></b> 
                            </a>
                            <br>
                            <i><?=$row->desc?></i>
                        </div>
                    </div>
                </div>
            </article>

              <br>
              <article class="article">
                <div id="disqus_thread"></div>
                <script>
                    /**
                    *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                    *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
                    /*
                    var disqus_config = function () {
                    this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
                    this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                    };
                    */
                    (function() { // DON'T EDIT BELOW THIS LINE
                    var d = document, s = d.createElement('script');
                    s.src = 'https://si-disqus-com.disqus.com/embed.js';
                    s.setAttribute('data-timestamp', +new Date());
                    (d.head || d.body).appendChild(s);
                    })();
                </script>
                <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
              </article>
            </div>
          </section><!-- /Blog Details Section -->
          
        </div>

        <?php include "asideblog.php"; ?>

      </div>
    </div>

  </main>
<script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.floating-social-share.min.js"></script>
<script>
  $("body").floatingSocialShare({
    buttons: [
      "facebook", "linkedin", "telegram","whatsapp","twitter"
    ],
    text: "share with: ",
    url: "<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>"
  });
</script>