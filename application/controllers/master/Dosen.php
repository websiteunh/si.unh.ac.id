<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen extends CI_Controller {

	var $tables =   "md_dosen";		
	var $file		=		"dosen";
	var $page		=		"master/dosen";
	var $pk     =   "id_dosen";
	var $title  =   "Dosen";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Dosen</a></li>										
	<li class='breadcrumb-item active'><a href='master/dosen'>Dosen</a></li>										
	</ol>";				          


	public function __construct()
	{		
		parent::__construct();
		//---- cek session -------//		

		//===== Load Database =====
		$this->load->database();
		$this->load->helper('url', 'string');
		//===== Load Model =====
		$this->load->model('m_admin');		
		$this->load->model('m_dosen');		

		//===== Load Library =====
		$this->load->library('upload');
	}
	protected function template($data)
	{
		$name = $this->session->userdata('nama');
		if($name=="")
		{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."a4dm11n?denied'>";
		}else{								
			$this->load->view('back_template/header',$data);
			$this->load->view('back_template/aside');			
			$this->load->view($this->page);		
			$this->load->view('back_template/footer');
		}
	}
	
	public function index()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "view";		
		$data['mode']		= "view";				
		$this->template($data);	
	}
	public function ajax_list()
	{
		$list = $this->m_dosen->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $isi) {			
						
			if($isi->status==1) $status = "<label class='badge badge-success'>aktif</label>";			
			 else $status = "<label class='badge badge-danger'>non-aktif</label>";								

			if(!is_null($isi->jabatan)) $jabatan = "<label class='badge badge-warning'>".str_replace("-", " ", $isi->jabatan)."</label>";			
			 else $jabatan = "";								

			if($isi->jabfung=="non"){
				$jabfung = "Non Jabfung";
			}elseif($isi->jabfung=="aa"){
				$jabfung = "Asisten Ahli";
			}elseif($isi->jabfung=="l"){
				$jabfung = "Lektor";
			}elseif($isi->jabfung=="lk"){
				$jabfung = "Lektor Kepala";
			}elseif($isi->jabfung=="gb"){
				$jabfung = "Guru Besar";
			}

			if(!isset($isi->foto) AND $isi->foto==""){
        $foto = "user.png";
      }else{
        $foto = $isi->foto;
      }

			$no++;
			$row = array();
			$row[] = $no;			
			$row[] = "<a href='master/dosen/detail?id=$isi->id_dosen'>$isi->nidn </a> <br> $status $jabatan";						
			$row[] = $isi->nik;						
			$row[] = $isi->nuptk;						
			$row[] = $isi->nama_lengkap;						
			$row[] = $isi->gol." / ".$jabfung;						
			$row[] = $isi->email." <br> ".$isi->no_hp;						
			$row[] = $isi->bidangRiset;		
			$row[] = $isi->sinta;			
			$row[] = "<img src='assets/uploads/images/$foto' class='img-fluid'>";								
			$row[] = "
						<div class='btn-group'>
              <button type='button' class='btn btn-success btn-sm dropdown-toggle' data-toggle='dropdown'>Action</button>
              <div class='dropdown-menu'>
                <a href=\"master/dosen/delete?id=$isi->id_dosen\" onclick=\"return confirm('Anda yakin?')\" class='dropdown-item'>Hapus</a>
                <a href=\"master/dosen/edit?id=$isi->id_dosen\" class='dropdown-item'>Edit</a>
                <a href=\"master/dosen/akun?id=$isi->id_dosen\" class='dropdown-item'>Aktivasi</a>                
              </div>
            </div>";													
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_dosen->count_all(),
						"recordsFiltered" => $this->m_dosen->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	public function add()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Tambah ".$this->title;	
		$data['bread']	= $this->bread;																														
		$data['set']		= "insert";	
		$data['mode']		= "insert";									
		$this->template($data);	
	}
	public function delete()
	{		
		$tabel			= $this->tables;
		$pk 				= $this->pk;
		$id 				= $this->input->get('id');		
		$this->m_admin->delete($tabel,$pk,$id);
		$_SESSION['pesan'] 	= "Data berhasil dihapus";
		$_SESSION['tipe'] 	= "success";
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/dosen'>";
	}	
	public function akun()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;		
		$id = $this->input->get("id");
		$row = $this->m_admin->getByID("md_dosen","id_dosen",$id)->row();
		$data['id_dosen'] 			= $row->id_dosen;
		$data['nama_lengkap'] 			= $row->nama_lengkap;		
		$data['email'] 		= $row->nidn;
		$data['no_hp'] 			= $row->no_hp;
		$data['tgl_daftar'] = $waktu;
		$data['id_user_type'] 			= 2;
		$data['status'] 			= 1;		
		$pass = $this->m_admin->getByID("md_setting","id_setting","1")->row()->pass_dosen;		
		$data['password'] = md5(encr().$pass);
		$data['level'] = $data['jenis'] 			= "dosen";
		$data['foto'] 			= "";		
		$data['created_at'] 			= $waktu;
		$sql = $this->m_admin->getByID("md_user","email",$row->nidn);
		if(!is_null($row->nidn) && !is_null($row->no_hp)){
			if($sql->num_rows() == 0){
				$this->m_admin->insert("md_user",$data);					
				$_SESSION['pesan'] 		= "Akun berhasil dibuat";
				$_SESSION['tipe'] 		= "success";						
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/dosen'>";					
			}else{
				$this->m_admin->update("md_user",$data,"email",$row->nidn);							
				$_SESSION['pesan'] 		= "Akun berhasil direset";
				$_SESSION['tipe'] 		= "success";						
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/dosen'>";					
			}
		}else{
			$_SESSION['pesan'] 		= "Email dan No HP tidak boleh kosong";
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";
		}				
	}	
	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;
		$config['upload_path'] 		= './assets/uploads/images/';
		$config['allowed_types'] 	= 'jpg|jpeg|png';
		$config['max_size']				= '1000';		
    $config['encrypt_name'] 	= TRUE; 				

    $err = "";
    if(!empty($_FILES['foto']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('foto')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";				
				$data['foto']	= $this->upload->file_name;
			}
		}

		$data['nama_lengkap'] 			= $this->input->post('nama_lengkap');						
		$data['email'] 			= $this->input->post('email');				
		$data['status'] 			= $this->input->post('status');				
		$data['no_hp'] 			= $this->input->post('no_hp');		
		$data['nuptk'] 		= $this->input->post('nuptk');		
		$data['nidn'] 			= $this->input->post('nidn');						
		$data['nik'] 			= $this->input->post('nik');						
		$data['jabfung'] 			= $this->input->post('jabfung');						
		$data['gol'] 			= $this->input->post('gol');						
		$data['jabatan'] 			= $this->input->post('jabatan');						
		$data['no_hp'] 			= $this->input->post('no_hp');						
		$data['sinta'] 			= $this->input->post('sinta');						
		$data['gscholar'] 			= $this->input->post('gscholar');						
		$data['matakuliah'] 			= $this->input->post('matakuliah');						
		$data['bidangRiset'] 			= $this->input->post('bidangRiset');						
		$data['created_at'] 			= $waktu;		


		if($err==""){
	    $this->m_admin->insert($tabel,$data);					
	    $_SESSION['pesan'] 		= "Data berhasil disimpan";
	    $_SESSION['tipe'] 		= "success";						
	    echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/dosen'>";						
	  }else{
			$_SESSION['pesan'] 		= $err;
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";			
		}
	}		
	public function update()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;				
		$id			= $this->input->post('id');						
		$config['upload_path'] 		= './assets/uploads/images/';
		$config['allowed_types'] 	= 'jpg|png|bmp|jpeg';
		$config['max_size']				= '1000';		
    $config['encrypt_name'] 	= TRUE; 						

    $err = "";
    if(!empty($_FILES['foto']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('foto')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";
				$row = $this->m_admin->getByID("md_dosen","id_dosen",$id)->row();
	    	if(isset($row->foto)){
	    		unlink('assets/uploads/images/'.$row->foto);         	    		
	    	}
				$data['foto']	= $this->upload->file_name;
			}
		}
		$data['nama_lengkap'] 			= $this->input->post('nama_lengkap');						
		$data['email'] 			= $this->input->post('email');				
		$data['status'] 			= $this->input->post('status');				
		$data['no_hp'] 			= $this->input->post('no_hp');						
		$data['nidn'] 			= $this->input->post('nidn');						
		$data['nik'] 			= $this->input->post('nik');						
		$data['nuptk'] 		= $this->input->post('nuptk');		
		$data['jabfung'] 			= $this->input->post('jabfung');						
		$data['gol'] 			= $this->input->post('gol');						
		$data['jabatan'] 			= $this->input->post('jabatan');						
		$data['no_hp'] 			= $this->input->post('no_hp');						
		$data['sinta'] 			= $this->input->post('sinta');						
		$data['gscholar'] 			= $this->input->post('gscholar');						
		$data['matakuliah'] 			= $this->input->post('matakuliah');						
		$data['bidangRiset'] 			= $this->input->post('bidangRiset');						
		$data['updated_at'] 			= $waktu;		
    
    if($err==""){
	    $this->m_admin->update($tabel,$data,$pk,$id);					
	    $_SESSION['pesan'] 		= "Data berhasil diubah";
	    $_SESSION['tipe'] 		= "success";						
	    echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/dosen'>";						
	  }else{
			$_SESSION['pesan'] 		= $err;
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";			
		}
	}	
	public function edit()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Ubah ".$this->title;	
		$data['bread']	= $this->bread;
		$tabel	= $this->tables;
		$pk			= $this->pk;
		$id 		= $this->input->get('id');																															
		$data['set']		= "insert";		
		$data['mode']		= "edit";				
		$data['dt_dosen'] = $this->m_admin->getByID($tabel,$pk,$id);		
		$this->template($data);	
	}		
	public function detail()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Detail ".$this->title;	
		$data['bread']	= $this->bread;
		$tabel	= $this->tables;
		$pk			= $this->pk;
		$id 		= $this->input->get('id');																															
		$data['set']		= "insert";				
		$data['dt_dosen'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}	
}
