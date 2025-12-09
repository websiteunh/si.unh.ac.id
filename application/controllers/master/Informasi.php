<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Informasi extends CI_Controller {

	var $tables =   "md_informasi";		
	var $file		=		"informasi";
	var $page		=		"master/informasi";
	var $pk     =   "id_informasi";
	var $title  =   "Informasi";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Informasi</a></li>										
	<li class='breadcrumb-item active'><a href='master/informasi'>Informasi</a></li>										
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
		$this->load->model('m_informasi');		
		$this->load->helper('permalink_helper');				

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
		$list = $this->m_informasi->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $isi) {			
						
			if($isi->status==1) $status = "<label class='badge badge-success'>publish</label>";			
			 else $status = "<label class='badge badge-danger'>draft</label>";	

			if(!is_null($isi->isi) && strlen($isi->isi)>100){
				$isinya = substr($isi->isi, 0,100)." ... ";
			}else{
				$isinya = $isi->isi;
			}										

			$cekKategori = $this->m_admin->getByID("md_kategori","id_kategori",$isi->id_kategori);
			$kategori = ($cekKategori->num_rows()>0)?$cekKategori->row()->kategori:'';

			if(!isset($isi->foto) AND $isi->foto==""){
        $foto = "user.png";
      }else{
        $foto = $isi->foto;
      }

      $fotos = "<img src='assets/uploads/images/$foto' class='img-fluid elevation-2' width='40px'>";

			$no++;
			$row = array();
			$row[] = $no;			
			$row[] = "<a href='master/informasi/detail?id=$isi->id_informasi'>$isi->judul </a> <br> $status";						
			$row[] = $kategori;						
			$row[] = $isinya;									
			$row[] = $fotos;									
			$row[] = "
						<div class='btn-group'>
              <button type='button' class='btn btn-success btn-sm dropdown-toggle' data-toggle='dropdown'>Action</button>
              <div class='dropdown-menu'>
                <a href=\"master/informasi/delete?id=$isi->id_informasi\" onclick=\"return confirm('Anda yakin?')\" class='dropdown-item'>Hapus</a>
                <a href=\"master/informasi/edit?id=$isi->id_informasi\" class='dropdown-item'>Edit</a>                
              </div>
            </div>";													
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_informasi->count_all(),
						"recordsFiltered" => $this->m_informasi->count_filtered(),
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
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/informasi'>";
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

		$data['judul'] 			= $this->input->post('judul');						
		$data['id_kategori'] 			= $this->input->post('id_kategori');				
		$data['status'] 			= $this->input->post('status');				
		$data['isi'] 			= $this->input->post('isi');						
		$data['embedfile'] 			= $this->input->post('embedfile');
		$data['slug'] 			= set_permalink($this->input->post('judul'));												
		$data['created_at'] 			= $waktu;		
		$data['created_by'] 			= $this->session->id_user;


		if($err==""){
	    $this->m_admin->insert($tabel,$data);					
	    $_SESSION['pesan'] 		= "Data berhasil disimpan";
	    $_SESSION['tipe'] 		= "success";						
	    echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/informasi'>";						
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
				$row = $this->m_admin->getByID("md_informasi","id_informasi",$id)->row();
	    	if(isset($row->foto)){
	    		unlink('assets/uploads/images/'.$row->foto);         	    		
	    	}
				$data['foto']	= $this->upload->file_name;
			}
		}
		$data['judul'] 			= $this->input->post('judul');						
		$data['slug'] 			= set_permalink($this->input->post('judul'));												
		$data['id_kategori'] 			= $this->input->post('id_kategori');				
		$data['status'] 			= $this->input->post('status');				
		$data['isi'] 			= $this->input->post('isi');						
		$data['embedfile'] 			= $this->input->post('embedfile');								
		$data['updated_at'] 			= $waktu;		
		$data['updated_by'] 			= $this->session->id_user;
    
    if($err==""){
	    $this->m_admin->update($tabel,$data,$pk,$id);					
	    $_SESSION['pesan'] 		= "Data berhasil diubah";
	    $_SESSION['tipe'] 		= "success";						
	    echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/informasi'>";						
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
		$data['dt_informasi'] = $this->m_admin->getByID($tabel,$pk,$id);		
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
		$data['dt_informasi'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}	
}
