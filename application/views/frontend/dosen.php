<style type="text/css">
/* Styling for consistent image size */
.fixed-size-img {
    width: 100%; /* Ensures the image spans the container */
    height: 300px; /* Fixed height for uniformity */
    object-fit: cover; /* Ensures image is cropped proportionally without distortion */
    border-radius: 10px; /* Optional: Adds rounded corners to the image */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Optional: Adds a subtle shadow effect */
}

.card {
  border: 1px solid #ddd;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.card-img {
  object-fit: cover;
  height: 100%;
}

.card-body {
  padding: 20px;
}

</style>
  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Dosen</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Dosen</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <div class="container">
      <div class="row">

        <div class="col-lg-12">

          <!-- Blog Posts Section -->
          <section id="team" class="team section">          

            <div class="container">

              <div class="row gy-4">

                <?php           
                $dt_dosen = $this->m_admin->getByID("md_dosen","status",1);
                foreach($dt_dosen->result() AS $data){            

                  if(!isset($data->foto) AND $data->foto==""){
                    $foto = "user.png";
                  }else{
                    $foto = $data->foto;
                  }
                ?>

                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="assets/uploads/images/<?=$foto?>" class="img-fluid fixed-size-img" alt="<?=$data->nama_lengkap?>">
                        </div>
                        <div class="member-info text-center">
                            <h4><?=$data->nama_lengkap?></h4>
                            <span><b>NIDN:</b> <?=$data->nidn?></span>
                            <button type="button" data-toggle="modal" data-target="#modal<?=$data->nidn?>" class="btn btn-outline-info btn-sm mt-3">Detail</button>
                        </div>
                    </div>
                </div><!-- End Team Member -->


                <div class="modal fade" id="modal<?=$data->nidn?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header text-center">
                        <h5 class="modal-title" id="exampleModalLabel">
                          Details
                        </h5>                        
                      </div>
                      <div class="modal-body">
                        <div class="container">
                          <div class="card">
                            <div class="row no-gutters">
                              <!-- Foto -->
                              <div class="col-md-5">
                                <img src="assets/uploads/images/<?=$foto?>" class="card-img img-fluid" alt="<?=$data->nama_lengkap?>">
                              </div>
                              <!-- Informasi Profil -->
                              <div class="col-md-7">
                                <div class="card-body">
                                  <h3 class="card-title"><span id="namaLengkap"><?=$data->nama_lengkap?></span></h3>
                                  <hr>                                  
                                  <ul class="list-unstyled">
                                    <li><strong>Email:</strong> <?=$data->email?></li>
                                    <li><strong>NIDN:</strong> <?=$data->nidn?></li>
                                    <li><strong>NIK:</strong> <?=$data->nik?></li>
                                    <li><strong>NUPTK:</strong> <?=$data->nuptk?></li>
                                    <li><strong>Jabatan/Gol:</strong> <?=$data->jabfung?> / <?=$data->gol?></li>
                                    <li><strong>Bidang Riset:</strong> <?=$data->bidangRiset?></li>                                    
                                  </ul>
                                  <a href="<?=$data->sinta?>" class="btn btn-primary btn-sm mt-3">Profil SINTA</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>                    
                    </div>
                  </div>
                </div>

                <?php } ?>

              </div><!-- End blog posts list -->

            </div>

          </section><!-- /Blog Posts Section -->
          

        </div>
        

      </div>
    </div>

  </main>



