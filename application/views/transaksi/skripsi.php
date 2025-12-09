     

      <?php                       
    if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {                    
      ?>                  
      <div class="alert alert-<?php echo $_SESSION['tipe'] ?> alert-dismissable">
        <strong><?php echo $_SESSION['pesan'] ?></strong>                    
      </div>
      <?php
    }
    $_SESSION['pesan'] = '';                        

    ?>

    <?php 
    if($set=="insert"){
      if($mode == 'insert'){
        $read = "";
        $read2 = "";
        $form = "save";
        $vis  = "";
        $form_id = "";
        $row = "";
      }elseif($mode == 'detail'){
        $row  = $dt_skripsi->row();              
        $read = "readonly";
        $read2 = "disabled";
        $vis  = "style='display:none;'";
        $form = "save";              
        $form_id = "";
      }elseif($mode == 'edit'){
        $row  = $dt_skripsi->row();
        $read = "";
        $read2 = "";
        $form = "update";              
        $vis  = "";
        $form_id = "<input type='hidden' name='id' value='$row->id_skripsi'>";              
      }
      ?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="transaksi/skripsi" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <form action="transaksi/skripsi/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">         
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">NIM</label>
                      <div class="col-sm-2">                                                                  
                        <input type="text" readonly value="<?php echo $this->session->username; ?>" name="nim" placeholder="NIM" class="form-control form-control-sm " />
                      </div>                                    
                                                                                        
                      <label class="col-sm-2 col-form-label-sm">Nama Lengkap</label>
                      <div class="col-sm-6">                        
                        <input type="text" readonly value="<?php echo $this->session->nama; ?>" name="nama" placeholder="Nama Lengkap" class="form-control form-control-sm " />                        
                      </div>                  
                    </div>       
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Judul</label>
                      <div class="col-sm-10">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->judul : "" ; ?>" name="judul" placeholder="Judul" class="form-control form-control-sm " />
                      </div>                                          
                    </div>      
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Abstrak</label>
                      <div class="col-sm-10">                        
                        <textarea name="abstrak" id="exampleTextarea1" class="form-control form-control-sm " rows="3"><?php echo $tampil = ($row!='') ? $row->abstrak : "" ; ?></textarea>
                      </div>                                          
                    </div>        
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Tgl Ujian</label>
                      <div class="col-sm-4">                        
                        <input type="date" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->tgl_ujian : "" ; ?>" required name="tgl_ujian" placeholder="Tgl Ujian" class="form-control form-control-sm">
                      </div>
                    </div>      
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Dosen Pembimbing 1</label>
                      <div class="col-sm-4">
                        <?php echo $form_id ?>
                        <select class="form-control form-control-sm select2" <?php echo $read2 ?> name="id_dosbing1">
                          <?php $tampil = ($row!='') ? $row->id_dosbing1 : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <?php             
                          $dt_dosen = $this->m_admin->getByID("md_dosen","status",1);              
                          foreach ($dt_dosen->result() as $isi) {
                            $id_dosbing1 = ($row!='') ? $row->id_dosbing1 : "";
                            if($id_dosbing1!='' && $id_dosbing1==$isi->id_dosen){
                             $se = "selected";
                            }else{
                              $se="";
                            }
                            echo "<option $se value='$isi->id_dosen'>$isi->nama_lengkap</option>";
                          }
                          ?>
                        </select>
                      </div> 
                      <label class="col-sm-2 col-form-label-sm">Dosen Pembimbing 2</label>
                      <div class="col-sm-4">
                        <?php echo $form_id ?>
                        <select class="form-control form-control-sm select2" <?php echo $read2 ?> name="id_dosbing2">
                          <?php $tampil = ($row!='') ? $row->id_dosbing2 : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <?php             
                          $dt_dosen = $this->m_admin->getByID("md_dosen","status",1);              
                          foreach ($dt_dosen->result() as $isi) {
                            $id_dosbing2 = ($row!='') ? $row->id_dosbing2 : "";
                            if($id_dosbing2!='' && $id_dosbing2==$isi->id_dosen){
                             $se = "selected";
                            }else{
                              $se="";
                            }
                            echo "<option $se value='$isi->id_dosen'>$isi->nama_lengkap</option>";
                          }
                          ?>
                        </select>
                      </div> 
                    </div>   
                    <div class="form-group row">                   
                      <label class="col-sm-2 col-form-label-sm">Hasil Sempro</label>
                      <div class="col-sm-4">                          
                        <input class="form-control form-control-sm " type="file" name="proposal">
                      </div>
                      <?php 
                      $rt = "style=display:none";
                      $file="";
                      if($mode!="insert"){ 
                        $rt = "";
                        if(!isset($row->proposal) OR $row->proposal==""){
                          $file = "";
                        }else{
                          $file = $row->proposal;
                        }
                      }
                      ?>
                      <div <?php echo $rt ?> class="col-sm-1">                          
                        <a href="assets/skripsi/<?php echo $file ?>" class="btn btn-danger btn-sm"><i class="fa fa-eye"></i></a>                        
                      </div>
                    </div>
                    <div class="form-group row">                   
                      <label class="col-sm-2 col-form-label-sm">Draft Artikel</label>
                      <div class="col-sm-4">                          
                        <input class="form-control form-control-sm " type="file" name="artikel">
                      </div>
                      <?php 
                      $rt = "style=display:none";
                      $file="";
                      if($mode!="insert"){ 
                        $rt = "";
                        if(!isset($row->artikel) OR $row->artikel==""){
                          $file = "";
                        }else{
                          $file = $row->artikel;
                        }
                      }
                      ?>
                      <div <?php echo $rt ?> class="col-sm-1">                          
                        <a href="assets/skripsi/<?php echo $file ?>" class="btn btn-danger btn-sm"><i class="fa fa-eye"></i></a>                        
                      </div>
                    </div>
                    <div class="form-group row">                   
                      <label class="col-sm-2 col-form-label-sm">File Laporan</label>
                      <div class="col-sm-4">                          
                        <input class="form-control form-control-sm " type="file" name="laporan">
                      </div>
                      <?php 
                      $rt = "style=display:none";
                      $file="";
                      if($mode!="insert"){ 
                        $rt = "";
                        if(!isset($row->laporan) OR $row->laporan==""){
                          $file = "";
                        }else{
                          $file = $row->laporan;
                        }
                      }
                      ?>
                      <div <?php echo $rt ?> class="col-sm-1">                          
                        <a href="assets/skripsi/<?php echo $file ?>" class="btn btn-danger btn-sm"><i class="fa fa-eye"></i></a>                        
                      </div>
                    </div>                                                         
                  </div>   
                </div>
                <div class="row">
                  <div class="col-12">                
                    <hr>
                    <div class="row" <?php echo $vis ?> >
                      <div class="col-md-6">                    
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="reset" class="btn btn-light">Cancel</button>               
                      </div>
                    </div>
                  </div>
                </div>
              </form>                                
            </div>
          </div>
        </div>
      </div>
    </div>
        
  <?php }elseif($set=="viewMhs"){ $id_user_type = $this->session->id_user_type; ?>


    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <?php if($id_user_type==3){ ?>
          <div class="card-header">
            <h4 class="card-title"><a href="transaksi/skripsi/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambahkan Dokumen</a></h4>
          </div>
          <?php } ?>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="example" class="table table-responsive" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>                                                                  
                      <th>NIM</th>                                                    
                      <th>Nama Lengkap</th>                                                  
                      <th>Judul</th>                                                          
                      <th>Abstrak</th>                                                                                
                      <th>Tgl Ujian</th>                                                                                
                      <th>Dosbing 1</th>                                                          
                      <th>Dosbing 2</th>                                                          
                      <th>Artikel</th>                                                          
                      <th>Laporan</th>                                                          
                      <th width="10%"></th>
                    </tr>
                  </thead>
                  <tbody> 
                  <?php 
                  $no=1;                  
                  if($id_user_type==2){
                    $id_dosen = $this->session->id_dosen;
                    $list = $this->db->query("SELECT * FROM md_skripsi WHERE id_dosbing1 = '$id_dosen' OR id_dosbing2 = '$id_dosen'");
                  }else{
                    $nim = $this->session->username;
                    $list = $this->m_admin->getByID("md_skripsi","nim",$nim);
                  }                  
                  foreach ($list->result() as $isi) {     
                    $cekMhs = $this->m_admin->getByID("md_user","email",$isi->nim);
                    $nama = ($cekMhs->num_rows()>0)?$cekMhs->row()->nama_lengkap:'';

                    $cekDosen = $this->m_admin->getByID("md_dosen","id_dosen",$isi->id_dosbing1);
                    $dosen1 = ($cekDosen->num_rows()>0)?$cekDosen->row()->nama_lengkap:'';

                    $cekDosen2 = $this->m_admin->getByID("md_dosen","id_dosen",$isi->id_dosbing2);
                    $dosen2 = ($cekDosen2->num_rows()>0)?$cekDosen2->row()->nama_lengkap:'';

                    $artikel="";
                    if(!is_null($isi->artikel)){
                      $artikel = "<a href='assets/skripsi/$isi->artikel' class='btn btn-success btn-sm'>lihat file</a>";
                    }

                    $laporan="";
                    if(!is_null($isi->laporan)){
                      $laporan = "<a href='assets/skripsi/$isi->laporan' class='btn btn-success btn-sm'>lihat file</a>";
                    }

                    
                    echo "<tr>
                    <td>$no</td>
                    <td>$isi->nim</td>
                    <td>$nama</td>
                    <td><a href='transaksi/skripsi/detail?id=$isi->id_skripsi'>$isi->judul</a></td>
                    <td>$isi->abstrak</td>
                    <td>$isi->tgl_ujian</td>
                    <td>$dosen1</td>
                    <td>$dosen2</td>
                    <td>$artikel</td>
                    <td>$laporan</td>
                    <td>
                          <a href=\"transaksi/skripsi/delete?id=$isi->id_skripsi\" onclick=\"return confirm('Anda yakin?')\" class=\"btn btn-danger btn-sm\" title=\"Hapus\"><i class=\"fa fa-trash\"></i></a>                          
                          <a href=\"transaksi/skripsi/edit?id=$isi->id_skripsi\" class=\"btn btn-primary btn-sm\" title=\"Edit\"><i class=\"fa fa-edit\"></i></a>
                    </td>
                    </tr>";
                    $no++;
                  }
                  ?>                 
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    
    <?php }else{ ?>


    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">          
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="skripsi_dt" class="table table-responsive" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>                                                                  
                      <th>NIM</th>                                                    
                      <th>Nama Lengkap</th>                                                  
                      <th>Judul</th>                                                          
                      <th>Abstrak</th>                                                                                
                      <th>Tgl Ujian</th>                                                                                
                      <th>Dosbing 1</th>                                                          
                      <th>Dosbing 2</th>                                                          
                      <th>Artikel</th>                                                          
                      <th>Laporan</th>                                                          
                      <th width="10%"></th>
                    </tr>
                  </thead>
                  <tbody>                  
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php } ?>



