

  <footer id="footer" class="footer dark-background">

    <div class="footer-top">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-4 col-md-6 footer-about">
            <a href="index.html" class="logo d-flex align-items-center">
              <span class="sitename"><?=$setting->perusahaan?></span>
            </a>
            <div class="footer-contact pt-3">
              <p><?=$setting->alamat?></p>              
              <p class="mt-3"><strong>Phone:</strong> <span><?=$setting->no_telp?></span></p>
              <p><strong>Email:</strong> <span><?=$setting->email?></span></p>
            </div>
          </div>

          <div class="col-lg-2 col-md-3 footer-links">
            <h4>Other Links</h4>
            <ul>
              <li><a href="https://unh.ac.id">Official Site</a></li>
              <li><a href="https://siakad.unh.ac.id">Siakad</a></li>
              <li><a href="https://ojs.unh.ac.id">Jurnal</a></li>
              <li><a href="https://pmb.unh.ac.id">PMB</a></li>
              <li><a href="https://kerma.unh.ac.id">Kerjasama</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Kategori Blog</h4>
            <ul>
              <?php 
              $kt = $this->m_admin->getAll("md_artikel_kategori");
              foreach ($kt->result() as $key => $value) {          
                $jum = $this->m_admin->getByID("md_artikel","id_artikel_kategori",$value->id_artikel_kategori)->num_rows();
              ?>
                <li><a href="kategori/<?=$value->permalink?>"><?=$value->kategori?> <span>(<?=$jum?>)</span></a></li>                        
              <?php } ?>
            </ul>
          </div>          

          <div class="col-lg-3 col-md-3 footer-links">           
            <a href="<?=$setting->banner?>" download>
              <img width="80%" src="assets/uploads/images/akre.jpeg" title="Sertifikat Akreditasi">
            </a>
            <h5>Download Sertifikasi Akreditasi</h5>
          </div>

        </div>
      </div>
    </div>

    <div class="copyright text-center">
      <div class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">

        <div class="d-flex flex-column align-items-center align-items-lg-start">
          <div>
            © Copyright <strong><span>Prodi Sistem Informasi</span></strong>. All Rights Reserved
          </div>          
        </div>

        <div class="social-links order-first order-lg-last mb-3 mb-lg-0">          
          <a href="<?=$setting->instagram?>"><i class="bi bi-instagram"></i></a>          
        </div>

      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader">
    <div></div>
    <div></div>
    <div></div>
    <div></div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/frontend/assets/js/main.js"></script>

  <script id="dsq-count-scr" src="//si-disqus-com.disqus.com/count.js" async></script>

</body>

</html>