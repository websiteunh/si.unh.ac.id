     

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
			}elseif($mode == 'detail' OR $mode == 'approval'){
				$row  = $dt_dosen->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "approve";              
				$form_id = "<input type='hidden' name='id' value='$row->id_dosen'>";              
			}elseif($mode == 'edit'){
				$row  = $dt_dosen->row();
				$read = "";
				$read2 = "";
				$form = "update";              
				$vis  = "";
				$form_id = "<input type='hidden' name='id' value='$row->id_dosen'>";              
			}

      if(isset($_GET['l'])){
        $link = "master/dosen/lamaran";
      }elseif(isset($_GET['h'])){
        $link = "master/dosen/history";
      }else{
        $link = "master/dosen";
      }
			?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="<?php echo $link ?>" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <form action="master/dosen/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">                
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Nama Lengkap</label>
                      <div class="col-sm-6">                        
                        <?php echo $form_id ?>                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->nama_lengkap : "" ; ?>" name="nama_lengkap" placeholder="Nama Lengkap" class="form-control form-control-sm " />
                      </div>                                    
                                                                                        
                      <label class="col-sm-1 col-form-label-sm">Status</label>
                      <div class="col-sm-2">                        
                        <select class="form-control form-control-sm " <?php echo $read2 ?> name="status">
                          <?php echo $tampil = ($row!='') ? $row->status : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <option <?php if($tampil=="1") echo 'selected' ?> value="1">Aktif</option>
                          <option <?php if($tampil=="0") echo 'selected' ?> value="0">Non-Aktif</option>
                        </select>
                      </div>                  
                    </div>    

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">NIDN</label>
                      <div class="col-sm-3">                        
                        <input type="number" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->nidn : "" ; ?>" name="nidn" placeholder="NIDN" class="form-control form-control-sm " />                                                
                      </div>                                          
                      <label class="col-sm-1 col-form-label-sm">NUPTK</label>
                      <div class="col-sm-2">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->nuptk : "" ; ?>" name="nuptk" placeholder="NUPTK" class="form-control form-control-sm " />                        
                      </div>                                          
                      <label class="col-sm-1 col-form-label-sm">NIK</label>
                      <div class="col-sm-2">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->nik : "" ; ?>" name="nik" placeholder="NIK" class="form-control form-control-sm " />                        
                      </div>                                          
                    </div>                                                        
                    
                    <div class="form-group row">                      
                      <label class="col-sm-2 col-form-label-sm">Jabfung</label>
                      <div class="col-sm-3">                        
                        <select class="form-control form-control-sm " <?php echo $read2 ?> name="jabfung">
                          <?php echo $tampil = ($row!='') ? $row->jabfung : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <option value="non" <?php if($tampil=="non") echo 'selected' ?>>Non Jabfung</option>
                          <option value="aa" <?php if($tampil=="aa") echo 'selected' ?>>Asisten Ahli</option>                          
                          <option value="l" <?php if($tampil=="l") echo 'selected' ?>>Lektor</option>
                          <option value="lk" <?php if($tampil=="lk") echo 'selected' ?>>Lektor Kepala</option>
                          <option value="gb" <?php if($tampil=="gb") echo 'selected' ?>>Guru Besar</option>
                        </select>
                      </div>
                      <label class="col-sm-1 col-form-label-sm">Golongan</label>
                      <div class="col-sm-2">                        
                        <select class="form-control form-control-sm " <?php echo $read2 ?> name="gol">
                          <?php echo $tampil = ($row!='') ? $row->gol : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <option <?php if($tampil=="IIIa") echo 'selected' ?>>IIIa</option>
                          <option <?php if($tampil=="IIIb") echo 'selected' ?>>IIIb</option>                          
                          <option <?php if($tampil=="IIIc") echo 'selected' ?>>IIIc</option>
                          <option <?php if($tampil=="IIId") echo 'selected' ?>>IIId</option>
                          <option <?php if($tampil=="IVa") echo 'selected' ?>>IVa</option>
                          <option <?php if($tampil=="IVb") echo 'selected' ?>>IVb</option>
                          <option <?php if($tampil=="IVc") echo 'selected' ?>>IVc</option>
                          <option <?php if($tampil=="IVd") echo 'selected' ?>>IVd</option>
                        </select>
                      </div>                                                              
                      <label class="col-sm-1 col-form-label-sm">Jabatan</label>
                      <div class="col-sm-3">                        
                        <select class="form-control form-control-sm " <?php echo $read2 ?> name="jabatan">
                          <?php echo $tampil = ($row!='') ? $row->jabatan : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <option value="ketua-prodi" <?php if($tampil=="ketua-prodi") echo 'selected' ?>>Ketua Prodi</option>
                          <option value="sekretaris-prodi" <?php if($tampil=="sekretaris-prodi") echo 'selected' ?>>Sekretaris Prodi</option>
                          <option value="dosen-tetap" <?php if($tampil=="dosen-tetap") echo 'selected' ?>>Dosen Tetap</option>
                        </select>
                      </div>                                          
                    </div>                     

                    <div class="form-group row">                      
                      <label class="col-sm-2 col-form-label-sm">Email</label>
                      <div class="col-sm-3">                        
                        <input type="email" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->email : "" ; ?>" name="email" placeholder="Email" class="form-control form-control-sm " />                        
                      </div>                
                      <label class="col-sm-1 col-form-label-sm">No HP</label>
                      <div class="col-sm-2">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->no_hp : "" ; ?>" name="no_hp" placeholder="No HP" class="form-control form-control-sm " />                                                
                      </div>                                                                    
                    </div>

                    <div class="form-group row">                      
                      <label class="col-sm-2 col-form-label-sm">URL Sinta</label>
                      <div class="col-sm-6">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->sinta : "" ; ?>" name="sinta" placeholder="URL Sinta" class="form-control form-control-sm " />                        
                      </div>                
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">URL G-Scholar</label>
                      <div class="col-sm-6">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->gscholar : "" ; ?>" name="gscholar" placeholder="URL Google Scholar" class="form-control form-control-sm " />                                                
                      </div>                                                                    
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Bidang Riset</label>
                      <div class="col-sm-10">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->bidangRiset : "" ; ?>" name="bidangRiset" placeholder="Bidang Riset" class="form-control form-control-sm " />                                                
                      </div>                                                                
                    </div>     

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Matakuliah yg Diampu</label>
                      <div class="col-sm-10">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->matakuliah : "" ; ?>" name="matakuliah" placeholder="Matakuliah" class="form-control form-control-sm " />                                                
                      </div>                                                                
                    </div>     

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Foto</label>
                      <?php 
                      $rt = "style=display:none";
                      $foto="";
                      if($mode!="insert"){ 
                        $rt = "";
                        if(!isset($row->foto) OR $row->foto==""){
                          $foto = "user.png";
                        }else{
                          $foto = $row->foto;
                        }
                      }
                      ?>
                        <div class='col-sm-4'>
                        <input type="file" name="foto" class="form-control form-control-sm ">                          
                        </div>
                        <div class='col-sm-2'></div>
                        <div <?php echo $rt ?> class='col-sm-4'><img width="300px" src="assets/uploads/images/<?php echo $foto ?>">                                              
                      </div>                                                                
                    </div>                                   
                                       
                  </div>   
                </div>
                <div class="row">
                  <div class="col-12">                
                    <hr>
                    <div class="row" <?php echo $vis ?> >
                      <div class="col-md-6">                    
                        <button type="submit" name="submit" value="save" class="btn btn-primary">Save</button>
                        <button type="reset" class="btn btn-light">Cancel</button>               
                      </div>
                    </div>
                    <?php if($mode=='approval'){ ?>
                    <div class="row">
                      <div class="col-md-6">                    
                        <button type="submit" name="submit" onclick="return confirm('Anda yakin approve data ini?')" value="approve" class="btn btn-primary">Approve</button>
                        <button type="submit" name="submit" onclick="return confirm('Anda yakin reject data ini?')" value="reject" class="btn btn-gradient-danger mr-2">Reject</button>                        
                      </div>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </form>                                
            </div>
          </div>
        </div>
      </div>
    </div>
        

    <?php }else{ ?>


    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title"><a href="master/dosen/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</a></h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="dosen_dt" class="table table-responsive" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>                                            
                      <th>NIDN</th>                           
                      <th>NIK</th>                                                                           
                      <th>NUPTK</th>                                                                           
                      <th>Nama Lengkap</th>                                    
                      <th>Golongan/Jabfung</th>                                    
                      <th>Kontak</th>                                    
                      <th>Bidang Riset</th>                                                          
                      <th>URL Sinta</th>                                                          
                      <th>Foto</th>                                                          
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

