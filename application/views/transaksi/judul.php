     

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
    if($set=="insert"){ ?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="transaksi/judul" class="btn btn-warning btn-sm"><i class="fa fa-chevron-left"></i> Kembali</a></h4>
            </div>
            <div class="card-body">
              <div class="btn-group btn-block mb-3">
                <button class="btn btn-warning btn-flat">Profil</button>
                <button class="btn btn-default btn-flat" disabled>Data Judul</button>                
              </div>
              <hr>
              <form action="transaksi/judul/simpan1" method="POST" enctype="multipart/form-data" class="form-sample">                  
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
                      <label class="col-sm-2 col-form-label-sm">Tahun Akademik</label>
                      <div class="col-sm-2">                        
                        <select required class="form-control form-control-sm" name="ta">                          
                          <option value="">- choose -</option>
                          <?php    
                          $d = date('Y');
                          for ($i=$d-2; $i <= $d+5; $i++) {                             
                            $i2 = $i+1;
                            if($d==$i) $r = 'selected';
                              else $r = '';
                            echo "<option $r value='$i'>$i / $i2</option>";
                          }
                          ?>
                        </select>
                      </div>
                      <label class="col-sm-2 col-form-label-sm">Semester</label>
                      <div class="col-sm-1">                        
                        <select required class="form-control form-control-sm" name="sms">                          
                          <option value="">- choose -</option>
                          <?php                              
                          for ($i=1; $i <= 14; $i++) {                                                         
                            if($i==7) $r = 'selected';
                              else $r = '';
                            echo "<option $r value='$i'>$i</option>";
                          }
                          ?>
                        </select>
                      </div>                      
                    </div>  
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Transkrip Nilai <small>(*.pdf, maksimal 500kb)</small></label>
                      <div class="col-sm-5">                        
                        <input type="file" name="file" class="form-control form-control-sm" accept=".pdf">
                      </div>
                    </div>                                                                                                               
                  </div>   
                </div>
                <div class="row">
                  <div class="col-12">                
                    <hr>
                    <div class="row">
                      <div class="col-md-6">                    
                        <button type="submit" name="submit" value="save" class="btn btn-primary">Simpan dan Lanjutkan <i class="fa fa-chevron-right"></i> </button>
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

    <?php 
    }elseif($set=="inputData"){ 
      if($mode == 'insert'){
        $read = "";
        $read2 = "";
        $form = "simpan2";
        $vis  = "";
        $form_id = "";
        $row = "";      
      }elseif($mode == 'edit'){
        $row  = $this->db->query("SELECT * FROM md_judul_detail WHERE id = '$id'")->row();
        $read = "";
        $read2 = "";
        $form = "update2";              
        $vis  = "";
        $form_id = "<input type='hidden' name='id' value='$row->id'>";              
      }
      
    ?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="transaksi/judul" class="btn btn-warning btn-sm"><i class="fa fa-chevron-left"></i> Kembali</a></h4>
            </div>
            <div class="card-body">
              <div class="btn-group btn-block mb-3">
                <button class="btn btn-success btn-flat">Profil <i class="fa fa-check"></i></button>
                <button class="btn btn-warning btn-flat" disabled>Data Judul</button>                
              </div>
              <hr>

              <div class="table-responsive">
                <table class="table table-responsive table-hover" id="example2">
                  <thead>
                    <tr>
                      <th rowspan="2" width="5%">No</th>
                      <th rowspan="2">Judul</th>
                      <th rowspan="2">Deskripsi Singkat</th>
                      <th colspan="3">Jumlah Daftar Kepustaaan Acuan yang tersedia (yang dimiliki) dan berhubungan dengan:</th>
                      <th rowspan="2">Jenis Penelitian</th>
                      <th rowspan="2">Manfaat</th>
                      <th rowspan="2" width="10%">#</th>
                    </tr>
                    <tr>
                      <td>Aspek (permasalahan) yang akan diteliti</td>
                      <td>Metodologi Penelitian</td>
                      <td>Teori Lain</td>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $no=1;
                  $id = decrypt_url($ids);
                  $cek = $this->db->query("SELECT * FROM md_judul_detail WHERE judul_id = '$id'");
                  foreach ($cek->result() as $key => $value) {
                    echo "
                      <tr>
                        <td>$no</td>
                        <td>$value->judul</td>
                        <td>$value->desk</td>
                        <td>$value->masalah</td>
                        <td>$value->metopel</td>
                        <td>$value->teori</td>
                        <td>$value->jenis</td>
                        <td>$value->manfaat</td>
                        <td>
                          <a class='btn btn-danger btn-sm' href='transaksi/judul/del?ids=$ids&id=$value->id'><i class='fa fa-trash'></i></a>
                          <a class='btn btn-primary btn-sm' href='transaksi/judul/ed?ids=$ids&id=$value->id'><i class='fa fa-edit'></i></a>
                        </td>
                      </tr>
                    ";
                    $no++;
                  }
                  ?> 
                  </tbody>
                </table>
              </div>
              <hr>
              <form action="transaksi/judul/<?=$form?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">                
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Judul</label>
                      <div class="col-sm-10">   
                        <?=$form_id?>
                        <input type="hidden" name="ids" value="<?=$ids?>">                                                                 
                        <textarea id="summernote2" name="judul" class="form-control" rows="3" required><?php echo $tampil = ($row!='') ? $row->judul : "" ; ?></textarea>
                      </div>   
                    </div>                                 
                    <div class="form-group row">                                                              
                      <label class="col-sm-2 col-form-label-sm">Deskripsi Singkat tentang Permasalahan (aspek) yang akan diteliti</label>
                      <div class="col-sm-10">                        
                        <textarea id="summernote1" name="desk" class="form-control" rows="3" required><?php echo $tampil = ($row!='') ? $row->desk : "" ; ?></textarea>
                      </div>                  
                    </div>    
                    <div class="form-group row">                                                              
                      <label class="col-sm-2 col-form-label-sm">Aspek (permasalahan) yang akan diteliti</label>
                      <div class="col-sm-10">                        
                        <textarea id="summernote" name="masalah" class="form-control" rows="3" required><?php echo $tampil = ($row!='') ? $row->masalah : "" ; ?></textarea>
                      </div>                  
                    </div>    
                    <div class="form-group row">                                                              
                      <label class="col-sm-2 col-form-label-sm">Metodologi Penelitian</label>
                      <div class="col-sm-10">                        
                        <textarea id="summernote3" name="metopel" class="form-control" rows="3" required><?php echo $tampil = ($row!='') ? $row->metopel : "" ; ?></textarea>
                      </div>                  
                    </div>    
                    <div class="form-group row">                                                              
                      <label class="col-sm-2 col-form-label-sm">Teori Lain (Sebagai Pendukung)</label>
                      <div class="col-sm-10">                        
                        <textarea id="summernote4" name="teori" class="form-control" rows="3" required><?php echo $tampil = ($row!='') ? $row->teori : "" ; ?></textarea>
                      </div>                  
                    </div>    
                    <div class="form-group row">                                                              
                      <label class="col-sm-2 col-form-label-sm">Jenis Penelitian</label>
                      <div class="col-sm-10">                        
                        <textarea id="summernote5" name="jenis" class="form-control" rows="3" required><?php echo $tampil = ($row!='') ? $row->jenis : "" ; ?></textarea>
                      </div>                  
                    </div>    
                    <div class="form-group row">                                                              
                      <label class="col-sm-2 col-form-label-sm">Manfaat</label>
                      <div class="col-sm-10">                        
                        <textarea id="summernote6" name="manfaat" class="form-control" rows="3" required><?php echo $tampil = ($row!='') ? $row->manfaat : "" ; ?></textarea>
                      </div>                  
                    </div>    
                    
                  </div>   
                </div>
                <div class="row">
                  <div class="col-12">                
                    <hr>
                    <div class="row">
                      <div class="col-md-6">            
                        <?php 
                        if($cek->num_rows()==3) $rr="d-none";
                          else $rr="";
                        ?>
                        <?php if($mode=="edit"){ ?>        
                          <button type="submit" name="submit" value="edit" class="btn btn-warning">Update <i class="fa fa-edit"></i> </button>
                        <?php }else{ ?>
                          <button type="submit" name="submit" value="tambah" class="btn btn-success <?=$rr?>">Tambahkan Judul <i class="fa fa-plus"></i> </button>                          
                        <?php } ?>                        
                        <?php if($cek->num_rows()==3){ ?>
                          <a onclick="return confirm('Anda yakin semua judul sudah benar?')" href="transaksi/judul/finish/<?=$ids?>" class="btn btn-primary">Ajukan Judul <i class="fa fa-plane"></i> </a>
                        <?php } ?>
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

    <?php 
    }elseif($set=="review"){       
      $id = decrypt_url($ids);
      $row  = $this->db->query("SELECT * FROM md_judul WHERE id_judul = '$id'")->row();
      $read = "";
      $read2 = "";
      $form = "update3";              
      $vis  = "";
      $form_id = "<input type='hidden' name='id' value='$row->id_judul'>";                    
      
    ?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="transaksi/judul" class="btn btn-warning btn-sm"><i class="fa fa-chevron-left"></i> Kembali</a></h4>
            </div>
            <div class="card-body">              

              <div class="table-responsive">
                <table class="table table-responsive table-hover" id="example2">
                  <thead>
                    <tr>
                      <th rowspan="2" width="5%">No</th>                      
                      <th rowspan="2">Judul</th>
                      <th rowspan="2">Deskripsi Singkat</th>
                      <th colspan="3">Jumlah Daftar Kepustaaan Acuan yang tersedia (yang dimiliki) dan berhubungan dengan:</th>
                      <th rowspan="2">Jenis Penelitian</th>
                      <th rowspan="2">Manfaat</th>                                                                
                    </tr>
                    <tr>
                      <td>Aspek (permasalahan) yang akan diteliti</td>
                      <td>Metodologi Penelitian</td>
                      <td>Teori Lain</td>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $no=1;
                  $id = decrypt_url($ids);
                  $cek = $this->db->query("SELECT * FROM md_judul_detail WHERE judul_id = '$id'");
                  foreach ($cek->result() as $key => $value) {
                    echo "
                      <tr>
                        <td>$no</td>                        
                        <td>$value->judul</td>
                        <td>$value->desk</td>
                        <td>$value->masalah</td>
                        <td>$value->metopel</td>
                        <td>$value->teori</td>
                        <td>$value->jenis</td>
                        <td>$value->manfaat</td>                                                
                      </tr>
                    ";
                    $no++;
                  }
                  ?> 
                  </tbody>
                </table>
                <hr>
                <form action="transaksi/judul/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                  <div class="row">
                    <div class="col-12">                
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label-sm">Pilihan</label>
                        <div class="col-sm-10">                        
                          <select class="form-control form-control-sm" name="pilihan">
                            <option value="">Tidak Diterima</option>
                            <?php 
                            foreach ($cek->result() as $key => $value) {
                              echo 
                                "<option value='$value->id'>$value->judul</option>";
                            }
                            ?>
                          </select>
                        </div>                                          
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label-sm">Catatan</label>
                        <div class="col-sm-10">  
                          <input type="hidden" value="<?=$ids?>" name="ids">                      
                          <textarea class="form-control" name="alasan"></textarea>
                        </div>                                          
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                          <button type="submit" class="btn btn-success" onclick="return confirm('Anda yakin?')">Simpan</button>
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
    </div>
        

    <?php }elseif($set=="viewMhs"){ ?>


    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title"><a href="transaksi/judul/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Ajukan Judul</a></h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="example2" class="table table-responsive" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>                                                                  
                      <th>NIM</th>                                                    
                      <th>Nama Lengkap</th>                                                  
                      <th>Tahun Akademik</th>                                                          
                      <th>Judul</th>                                                                                
                      <th>Status</th>                                                          
                      <th width="10%"></th>
                    </tr>
                  </thead>
                  <tbody>   
                  <?php 
                  $no=1;
                  $nim = $this->session->username;
                  $list = $this->m_admin->getByID("md_judul","nim",$nim);
                  foreach ($list->result() as $isi) {     
                    $edit="d-none";
                    if($isi->status==1){ 
                      $edit="";
                      $status = "<label class='badge badge-warning'>baru</label>";      
                    }elseif($isi->status==2){ 
                      $status = "<label class='badge badge-info'>diajukan</label>"; 
                    }elseif($isi->status==3){ 
                      $status = "<label class='badge badge-success'>diterima</label>";  
                    }elseif($isi->status==4){ 
                      $edit="";
                      $status = "<label class='badge badge-danger'>ditolak</label> <br>";  
                      $status .= $isi->alasan;
                    }

                        

                    $cekMhs = $this->m_admin->getByID("md_user","email",$isi->nim);
                    $nama = ($cekMhs->num_rows()>0)?$cekMhs->row()->nama_lengkap:'';
                    
                    $ids = encrypt_url($isi->id_judul);
                    $judul = "<ul>";
                    if($isi->status==3){
                      $cek = $this->db->query("SELECT * FROM md_judul_detail WHERE judul_id = '$isi->id_judul' AND status = 2");
                    }else{
                      $cek = $this->db->query("SELECT * FROM md_judul_detail WHERE judul_id = '$isi->id_judul'");
                    }
                    foreach ($cek->result() as $key => $value) {        
                      $judul.="<li>".$value->judul."</li>";
                    }
                    $judul.="</ul>";

                    $ta = $isi->ta."/".$isi->ta+1;                    
                    echo "
                      <tr> 
                        <td>$no</td>
                        <td>$isi->nim</td>
                        <td>$nama</td>
                        <td>$ta</td>
                        <td>$judul</td>
                        <td>$status</td>
                        <td>
                          <div class='btn-group $edit'>
                            <button type='button' class='btn btn-success btn-sm dropdown-toggle' data-toggle='dropdown'>Action</button>
                            <div class='dropdown-menu'>
                              <a href=\"transaksi/judul/delete?id=$ids\" onclick=\"return confirm('Anda yakin?')\" class='dropdown-item'>Hapus</a>
                              <a href=\"transaksi/judul/inputData/$ids\" class='dropdown-item'>Edit</a>                
                            </div>
                          </div>
                        </td>
                      </tr>
                      ";  
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
                <table id="judul_dt" class="table table-responsive" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>                                                                  
                      <th>NIM</th>                                                    
                      <th>Nama Lengkap</th>                                                  
                      <th>Tahun Akademik</th>                                                          
                      <th>Judul</th>                                                                                
                      <th>Status</th>                                                          
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



