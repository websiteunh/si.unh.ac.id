     

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
		if($set=="insert" && $mode!="import"){
			if($mode == 'insert'){
				$read = "";
				$read2 = "";
				$form = "save";
				$vis  = "";
				$form_id = "";
				$row = "";
			}elseif($mode == 'detail'){
				$row  = $dt_mahasiswa->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "save";              
				$form_id = "";
			}elseif($mode == 'edit'){
				$row  = $dt_mahasiswa->row();
				$read = "";
				$read2 = "";
				$form = "update";              
				$vis  = "";
				$form_id = "<input type='hidden' name='id' value='$row->id_user'>";              
			}
			?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="master/mahasiswa" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <form action="master/mahasiswa/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">                
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Nama Lengkap</label>
                      <div class="col-sm-10">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->nama_lengkap : "" ; ?>" name="nama_lengkap" placeholder="Nama User" class="form-control form-control-sm " />
                      </div>                                          
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">NIM</label>
                      <div class="col-sm-4">
                        <?php echo $form_id ?>
                        <input type="number" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->email : "" ; ?>" name="email" placeholder="NIM" class="form-control form-control-sm " />
                      </div>                    
                      <label class="col-sm-2 col-form-label-sm">Password</label>
                      <div class="col-sm-4">                          
                        <input type="password" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? "" : "" ; ?>" name="password" placeholder="Password" class="form-control form-control-sm " />                                                                        
                      </div>
                    </div> 

                    <div class="form-group row">                      
                      <label class="col-sm-2 col-form-label-sm">No HP</label>
                      <div class="col-sm-4">                          
                        <input type="number" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->no_hp : "" ; ?>" name="no_hp" placeholder="No HP" class="form-control form-control-sm " />                                                                        
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
    <?php
    } elseif ($set == 'insert' and $mode == 'import') {
    ?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">
                <a href="master/mahasiswa" class="btn btn-warning btn-sm"><i class="fa fa-chevron-left"></i> Kembali</a>
                <a href="master/mahasiswa/download" class="btn btn-success btn-sm"><i class="mdi mdi-download"></i> Download Template</a>
              </h4>
            </div>
            <div class="card-body">
              <form action="master/mahasiswa/importExcel" method="POST" enctype="multipart/form-data" class="form-sample">
                <div class="row">
                  <div class="col-12">
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Upload</label>
                      <div class="col-sm-8">
                        <input type="file" name="file" class="form-control form-control-sm" />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <hr>
                    <div class="row">
                      <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">Save</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php }else{ ?>


    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">
              <a href="master/mahasiswa/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</a>
              <a href="master/mahasiswa/import" class="btn btn-warning btn-sm"><i class="fa fa-download"></i> Import</a>
            </h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="example1" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>                                            
                      <th>Nama Lengkap</th>     
                      <th>NIM</th>                                                             
                      <th>No HP</th>                                                                                   
                      <th width="10%"></th>
                    </tr>
                  </thead>
                  <tbody>                  
                  <?php 
                  $no=1;
                  if($this->session->id_user_type==1) $list = $this->db->query("SELECT * FROM md_user WHERE jenis = 'mahasiswa' ORDER BY id_user DESC");
                    else  $list = $this->db->query("SELECT * FROM md_user WHERE id_user_type <> 1 AND jenis = 'mahasiswa' ORDER BY id_user DESC");                  
                  foreach ($list->result() as $isi) {
                    $r = $this->m_admin->getByID("md_user_type","id_user_type",$isi->id_user_type);
                    $user_type = ($r->num_rows() > 0) ? $r->row()->user_type : "" ;         
                    $jenis = (!is_null($isi->jenis) AND $isi->jenis!="") ? $isi->jenis : "umum" ;         
                    
                    if(!isset($isi->foto) AND $isi->foto==""){
                      $foto = "user.png";
                    }else{
                      $foto = $isi->foto;
                    }
                    
                    
                    if($isi->status==1) $status = "<label class='badge badge-success'>Aktif</label>";      
                      else $status = "";  
                    if($isi->banned==1) $banned = "<label class='badge badge-danger'>Banned</label>";      
                      else $banned = "";                            
                    

                    echo "
                    <tr>
                    <td>$no</td>                    
                    <td><a href='master/mahasiswa/detail?id=$isi->id_user'>$isi->nama_lengkap</a></td>
                    <td>$isi->email $status $banned</td>                                        
                    <td>$isi->no_hp</td>                                                                            
                    <td>
                      <div class='btn-group'>
                        <button type='button' class='btn btn-success btn-sm dropdown-toggle' data-toggle='dropdown'>Action</button>
                        <div class='dropdown-menu'>
                          <a href=\"master/mahasiswa/delete?id=$isi->id_user\" onclick=\"return confirm('Anda yakin?')\" class='dropdown-item'>Hapus</a>
                          <a href=\"master/mahasiswa/akun?id=$isi->id_user\" onclick=\"return confirm('Anda yakin?')\" class='dropdown-item'>Reset</a>
                          <a href=\"master/mahasiswa/banned?id=$isi->id_user\" onclick=\"return confirm('Anda yakin?')\" class='dropdown-item'>Blokir</a>
                          <a href=\"master/mahasiswa/edit?id=$isi->id_user\" class='dropdown-item'>Edit</a>                          
                        </div>
                      </div>                          
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

  <?php } ?>

