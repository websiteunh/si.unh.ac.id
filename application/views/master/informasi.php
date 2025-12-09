     

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
        $row  = $dt_informasi->row();              
        $read = "readonly";
        $read2 = "disabled";
        $vis  = "style='display:none;'";
        $form = "approve";              
        $form_id = "<input type='hidden' name='id' value='$row->id_informasi'>";              
      }elseif($mode == 'edit'){
        $row  = $dt_informasi->row();
        $read = "";
        $read2 = "";
        $form = "update";              
        $vis  = "";
        $form_id = "<input type='hidden' name='id' value='$row->id_informasi'>";              
      }

      if(isset($_GET['l'])){
        $link = "master/informasi/lamaran";
      }elseif(isset($_GET['h'])){
        $link = "master/informasi/history";
      }else{
        $link = "master/informasi";
      }
      ?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="<?php echo $link ?>" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <form action="master/informasi/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">                
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Judul</label>
                      <div class="col-sm-8">                        
                        <?php echo $form_id ?>                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->judul : "" ; ?>" name="judul" placeholder="Judul" class="form-control form-control-sm " />
                      </div>                                    
                                                                                        
                      <label class="col-sm-1 col-form-label-sm">Status</label>
                      <div class="col-sm-1">                        
                        <select class="form-control form-control-sm " <?php echo $read2 ?> name="status">
                          <?php echo $tampil = ($row!='') ? $row->status : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <option <?php if($tampil=="1") echo 'selected' ?> value="1">Publish</option>
                          <option <?php if($tampil=="0") echo 'selected' ?> value="0">Draft</option>
                        </select>
                      </div>                  
                    </div>    

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Kategori</label>
                      <div class="col-sm-4">                        
                        <select class="form-control form-control-sm select2" <?php echo $read2 ?> name="id_kategori">
                          <?php $tampil = ($row!='') ? $row->id_kategori : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <?php    
                          $dt_kategori = $this->m_admin->getAll("md_kategori");                       
                          foreach ($dt_kategori->result() as $isi) {
                            $id_kategori = ($row!='') ? $row->id_kategori : "";
                            if($id_kategori!='' && $id_kategori==$isi->id_kategori){
                             $se = "selected";
                            }else{
                              $se="";
                            }
                            echo "<option $se value='$isi->id_kategori'>$isi->kategori</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>                                                                                              

                    <div class="form-group row">                      
                      <label class="col-sm-2 col-form-label-sm">Link Gdrive Embedded (Jika ada)</label>
                      <div class="col-sm-10">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->embedfile : "" ; ?>" name="embedfile" placeholder="Link GDrive" class="form-control form-control-sm " />                        
                      </div>                
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Isi</label>
                      <div class="col-sm-10">                        
                        <textarea class="form-control" id="summernote" name="isi">
                          <?php echo $tampil = ($row!='') ? $row->isi : "" ; ?>
                        </textarea>
                      </div>                                                                    
                    </div>                  

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Thumbnail</label>
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
            <h4 class="card-title"><a href="master/informasi/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</a></h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="informasi_dt" class="table table-responsive" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>                                                                  
                      <th>Judul</th>                                                    
                      <th>Kategori</th>                                                  
                      <th>Isi</th>                                                          
                      <th>Thumbnail</th>                                                          
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

