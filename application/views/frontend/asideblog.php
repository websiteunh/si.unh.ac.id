<div class="col-lg-4 sidebar">

  <div class="widgets-container">

    <!-- Search Widget -->
    <div class="search-widget widget-item">

      <h3 class="widget-title">Search</h3>
      <form action="home/cari" method="post">
        <input type="text" name="cari">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>

    </div><!--/Search Widget -->

    <!-- Categories Widget -->
    <div class="categories-widget widget-item">

      <h3 class="widget-title">Kategori</h3>
      <ul class="mt-3">
        <?php 
        $kt = $this->m_admin->getAll("md_artikel_kategori");
        foreach ($kt->result() as $key => $value) {          
          $jum = $this->m_admin->getByID("md_artikel","id_artikel_kategori",$value->id_artikel_kategori)->num_rows();
        ?>
        <li><a href="kategori/<?=$value->permalink?>"><?=$value->kategori?> <span>(<?=$jum?>)</span></a></li>        
        <?php } ?>
      </ul>

    </div><!--/Categories Widget -->

    <hr>

    <!-- Recent Posts Widget -->
    <div class="recent-posts-widget widget-item">

      <h3 class="widget-title">Blog Terbaru</h3>

      <?php 
      $dt = $this->db->query("SELECT md_artikel.*, md_artikel_kategori.permalink AS permalink_ka, md_artikel_kategori.kategori, md_user.nama_lengkap FROM md_artikel
          LEFT JOIN md_artikel_kategori ON md_artikel.id_artikel_kategori = md_artikel_kategori.id_artikel_kategori
          LEFT JOIN md_user ON md_artikel.created_by = md_user.id_user          
          WHERE md_artikel.status = 'publish' ORDER BY id_artikel DESC LIMIT 0,5");
      foreach ($dt->result() as $key => $value) {                          
        if(!isset($value->gambar1) OR $value->gambar1==""){
          $foto = "files.png";
        }else{
          $foto = $value->gambar1;
        }
      ?>

      <div class="post-item">
        <a href="detail/<?=$value->permalink?>">
          <img src="assets/uploads/artikel/<?=$foto?>" alt="<?=$value->judul?>" class="flex-shrink-0">
        </a>
        <div>
          <h4><a href="detail/<?=$value->permalink?>"><?=$value->judul?></a></h4>
          <time datetime="2020-01-01"><?=tgl_indo($value->tgl_buat)?></time>
        </div>
      </div><!-- End recent post item-->

      <?php } ?>

     

    </div><!--/Recent Posts Widget -->    

    <hr>
    
    <div class="recent-posts-widget widget-item">

      <h3 class="widget-title">Blog Terfavorit</h3>

      <?php 
      $dt = $this->db->query("SELECT md_artikel.*, md_artikel_kategori.permalink AS permalink_ka, md_artikel_kategori.kategori, md_user.nama_lengkap FROM md_artikel
          LEFT JOIN md_artikel_kategori ON md_artikel.id_artikel_kategori = md_artikel_kategori.id_artikel_kategori
          LEFT JOIN md_user ON md_artikel.created_by = md_user.id_user          
          WHERE md_artikel.status = 'publish' ORDER BY baca DESC LIMIT 0,5");
      foreach ($dt->result() as $key => $value) {                          
        if(!isset($value->gambar1) OR $value->gambar1==""){
          $foto = "files.png";
        }else{
          $foto = $value->gambar1;
        }
      ?>

      <div class="post-item">
        <a href="detail/<?=$value->permalink?>">
          <img src="assets/uploads/artikel/<?=$foto?>" alt="<?=$value->judul?>" class="flex-shrink-0">
        </a>
        <div>
          <h4><a href="detail/<?=$value->permalink?>"><?=$value->judul?></a></h4>
          <time datetime="2020-01-01"><?=tgl_indo($value->tgl_buat)?></time>
        </div>
      </div><!-- End recent post item-->

      <?php } ?>

     

    </div><!--/Recent Posts Widget -->    

  </div>

</div>