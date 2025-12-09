<div class="col-lg-4 sidebar">

  <div class="widgets-container">    

    <!-- Recent Posts Widget -->
    <div class="recent-posts-widget widget-item">

      <h3 class="widget-title">Informasi Terbaru</h3>

      <?php 
      $data['dt_artikel'] = $dt = $this->db->query("SELECT md_informasi.*, md_kategori.kategori, md_kategori.slug AS slug_k FROM md_informasi
        JOIN md_kategori ON md_informasi.id_kategori = md_kategori.id_kategori
        WHERE md_informasi.status = 1 ORDER BY id_informasi DESC LIMIT 0,10");                
      foreach ($dt->result() as $key => $value) {                          
        if(!isset($value->foto) OR $value->foto==""){
          $foto = "files.png";
        }else{
          $foto = $value->foto;
        }
      ?>

      <div class="post-item">
        <a href="info/<?=$value->slug?>">
          <img src="assets/uploads/images/<?=$foto?>" alt="<?=$value->judul?>" class="flex-shrink-0">
        </a>
        <div>
          <h4><a href="info/<?=$value->slug?>"><?=$value->judul?></a></h4>
          <time datetime="2020-01-01"><?=tgl_indo(substr($value->created_at, 0,10))?></time>
        </div>
      </div><!-- End recent post item-->

      <?php } ?>

     

    </div><!--/Recent Posts Widget -->    

  </div>

</div>