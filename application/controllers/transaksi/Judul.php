<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Judul extends CI_Controller {

	var $tables =   "md_judul";		
	var $file		=		"judul";
	var $page		=		"transaksi/judul";
	var $pk     =   "id_judul";
	var $title  =   "Judul";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Kemahasiswaan</a></li>										
	<li class='breadcrumb-item active'><a href='transaksi/judul'>Judul</a></li>										
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
		$this->load->model('m_judul');		
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
		$id_user_type = $this->session->id_user_type;
		if($id_user_type!=3){			
			$data['set']		= "view";		
			$data['mode']		= "view";	
		}else{
			$data['set']		= "viewMhs";		
			$data['mode']		= "view";	
		}
		$this->template($data);	
	}
	public function ajax_list()
	{
		$list = $this->m_judul->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $isi) {			
			$edit="";
			if($isi->status==1){ 
				$edit="d-none";
				$status = "<label class='badge badge-warning'>baru</label>";			
			}elseif($isi->status==2){ 
			  $status = "<label class='badge badge-info'>diajukan</label>";	
			}elseif($isi->status==3){ 
				$edit="d-none";
			  $status = "<label class='badge badge-success'>diterima</label>";	
			}elseif($isi->status==4){ 
				$edit="d-none";				
			  $status = "<label class='badge badge-danger'>ditolak</label> <br>";	
			  $status .= $isi->alasan;
			}

					

			$cekMhs = $this->m_admin->getByID("md_user","email",$isi->nim);
			$nama = ($cekMhs->num_rows()>0)?$cekMhs->row()->nama_lengkap:'';
			
			$ids = encrypt_url($isi->id_judul);
			$judul = "<ul>";
			if($isi->status==3){
				$cek = $this->db->query("SELECT * FROM md_judul_detail WHERE judul_id = ? AND status = 2", array($isi->id_judul));
			}else{
				$cek = $this->db->query("SELECT * FROM md_judul_detail WHERE judul_id = ?", array($isi->id_judul));
			}

      foreach ($cek->result() as $key => $value) {      	
      	$judul.="<li>".$value->judul."</li>";
      }
      $judul.="</ul>";

			$ta = $isi->ta."/".$isi->ta+1;
			$no++;
			$row = array();
			$row[] = $no;			
			$row[] = $isi->nim;						
			$row[] = $nama;						
			$row[] = $ta;						
			$row[] = $judul;									
			$row[] = $status;									
			$row[] = "
						<div class='btn-group $edit'>
              <button type='button' class='btn btn-success btn-sm dropdown-toggle' data-toggle='dropdown'>Action</button>
              <div class='dropdown-menu'>                
                <a href=\"transaksi/judul/review/$ids\" class='dropdown-item'>Review</a>                
              </div>
            </div>";													
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_judul->count_all(),
						"recordsFiltered" => $this->m_judul->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	public function add()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Ajukan ".$this->title;	
		$data['bread']	= $this->bread;																														
		$data['set']		= "insert";	
		$data['mode']		= "insert";									
		$this->template($data);	
	}
	public function inputData($ids)
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Tambahkan ".$this->title;	
		$data['bread']	= $this->bread;																														
		$data['set']		= "inputData";	
		$data['mode']		= "insert";	
		$data['ids'] = $ids;								
		$this->template($data);	
	}
	public function review($ids)
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Review ".$this->title;	
		$data['bread']	= $this->bread;																														
		$data['set']		= "review";	
		$data['mode']		= "insert";	
		$data['ids'] = $ids;								
		$this->template($data);	
	}
	public function finish($ids)
	{								
		
		$id = decrypt_url($ids);
		$cek = $this->db->query("SELECT * FROM md_judul_detail WHERE judul_id = ?", array($id));
		if($cek->num_rows()==3){
			$data['status'] = 2;
			$data['submitted_at'] 			= waktu();		
			$this->m_admin->update("md_judul",$data,"id_judul",$id);			
			$_SESSION['pesan'] 		= "Judul berhasil diajukan";
	    $_SESSION['tipe'] 		= "success";		    
	    echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/judul'>";							     		
		}else{		
	    $_SESSION['pesan'] 		= "Judul yang anda ajukan kurang dari 3, silakan lanjutkan";
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";			
    }		
	}
	public function ed()
	{								
		$id 				= $this->input->get('id');		
		$ids 				= $this->input->get('ids');		
		$data['isi']    = $this->file;		
		$data['title']	= "Tambahkan ".$this->title;	
		$data['bread']	= $this->bread;																														
		$data['set']		= "inputData";	
		$data['mode']		= "edit";	
		$data['ids'] = $ids;			
		$data['id'] = $id;			
		$this->template($data);	
	}
	public function del()
	{				
		$id 				= $this->input->get('id');		
		$ids 				= $this->input->get('ids');		
		$this->m_admin->delete("md_judul_detail","id",$id);
		$_SESSION['pesan'] 	= "Data berhasil dihapus";
		$_SESSION['tipe'] 	= "success";
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/judul/inputData/".$ids."'>";
	}	
	public function delete()
	{				
		$id 				= decrypt_url($this->input->get('id'));				
		$this->m_admin->delete("md_judul_detail","judul_id",$id);
		$this->m_admin->delete("md_judul","id_judul",$id);
		$_SESSION['pesan'] 	= "Data berhasil dihapus";
		$_SESSION['tipe'] 	= "success";
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/judul'>";
	}		
	public function simpan1(){
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;		
		$config['upload_path'] 		= './assets/uploads/dokumen/';
		$config['allowed_types'] 	= 'pdf';
		$config['max_size']				= '500';		
    $config['encrypt_name'] 	= TRUE; 				

    $err = "";
    if(!empty($_FILES['file']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('file')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";				
				$data['file']	= $this->upload->file_name;
			}
		}

		$data['nim'] 			= $nim = $this->input->post('nim');						
		$data['ta'] 			= $ta = $this->input->post('ta');				
		$data['sms'] 			= $this->input->post('sms');				
		$data['tgl_ajukan'] 			= tgl();		
		$data['status'] 			= 1;	
		$data['created_at'] 			= $waktu;		
		$data['created_by'] 			= $this->session->id_user;

		if($err==""){
			$cek = $this->db->query("SELECT * FROM md_judul WHERE nim = ? AND ta = ?", array($nim, $ta));
			if($cek->num_rows()>0){
				$this->m_admin->update($tabel,$data,"id_judul",$cek->row()->id_judul);					
				$ids = encrypt_url($cek->row()->id_judul);
		    $_SESSION['pesan'] 		= "Data berhasil disimpan";
		    $_SESSION['tipe'] 		= "success";							    
			}else{		
		    $this->m_admin->insert($tabel,$data);			
		    $ids = encrypt_url($this->db->insert_id());
		    $_SESSION['pesan'] 		= "Data berhasil disimpan";
		    $_SESSION['tipe'] 		= "success";							    
		  }
		  echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/judul/inputData/".$ids."'>";							  
	  }else{
			$_SESSION['pesan'] 		= $err;
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";			
		}
	}
	public function update3()
	{
		$pilihan = $this->input->post("pilihan");
		$data['alasan'] = $this->input->post("alasan");
		$data['approval_at'] 			= waktu();		
		$data['approval_by'] 			= $this->session->id_user;
		if($pilihan!=''){
			$cekData = $this->db->query("SELECT * FROM md_judul_detail WHERE id = ?", array($pilihan));
			$datas['status'] = 2; 
			$datas['updated_at'] 			= waktu();		
			$datas['updated_by'] 			= $this->session->id_user;
			$this->m_admin->update("md_judul_detail",$datas,"id",$pilihan);

			$data['status'] = 3;
		}else{
			$data['status'] = 4;
		}
		$ids = $this->input->post("ids");
		$id = decrypt_url($ids);
		$this->m_admin->update("md_judul",$data,"id_judul",$id);
		$_SESSION['pesan'] 		= "Data berhasil disimpan";
    $_SESSION['tipe'] 		= "success";		


    echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/judul'>";							     
	}
	public function simpan2(){
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;		

		$ids = $this->input->post('ids');						
		$data['judul_id'] 			= $id = decrypt_url($ids);
		$data['judul'] 			= $this->input->post('judul');				
		$data['desk'] 			= $this->input->post('desk');				
		$data['masalah'] 			= $this->input->post('masalah');				
		$data['metopel'] 			= $this->input->post('metopel');				
		$data['teori'] 			= $this->input->post('teori');				
		$data['jenis'] 			= $this->input->post('jenis');				
		$data['manfaat'] 			= $this->input->post('manfaat');						
		$data['status'] 			= 1;	
		$data['created_at'] 			= $waktu;		
		$data['created_by'] 			= $this->session->id_user;

		$submit = $this->input->post("submit");
		if($submit=="tambah"){
			$this->m_admin->insert("md_judul_detail",$data);
			$_SESSION['pesan'] 		= "Data berhasil disimpan";
	    $_SESSION['tipe'] 		= "success";							 
	    echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/judul/inputData/".$ids."'>";							     
		}else{
			$cek = $this->db->query("SELECT * FROM md_judul_detail WHERE judul_id = ?", array($id));
			if($cek->num_rows()==3){
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/judul/finishData/".$ids."'>";							  
			}else{		
		    $_SESSION['pesan'] 		= "Judul yang anda ajukan kurang dari 3, silakan lanjutkan";
				$_SESSION['tipe'] 		= "danger";						
				echo "<script>history.go(-1)</script>";			
	    }
	  }
	  echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/judul/inputData/".$ids."'>";							  
	}
	public function update2(){
		$idj = $this->input->post('id');						
		$ids = $this->input->post('ids');								
		$data['judul'] 			= $this->input->post('judul');				
		$data['desk'] 			= $this->input->post('desk');				
		$data['masalah'] 			= $this->input->post('masalah');				
		$data['metopel'] 			= $this->input->post('metopel');				
		$data['teori'] 			= $this->input->post('teori');				
		$data['jenis'] 			= $this->input->post('jenis');				
		$data['manfaat'] 			= $this->input->post('manfaat');								
		$data['updated_at'] 			= waktu();		
		$data['updated_by'] 			= $this->session->id_user;
		$this->m_admin->update("md_judul_detail",$data,"id",$idj);		
		$_SESSION['pesan'] 		= "Data berhasil diubah";
    $_SESSION['tipe'] 		= "success";		    
    echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/judul/inputData/".$ids."'>";							     		
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
		$data['dt_judul'] = $this->m_admin->getByID($tabel,$pk,$id);		
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
		$data['dt_judul'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}	
}
