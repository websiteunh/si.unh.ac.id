<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kp extends CI_Controller {

	var $tables =   "md_kp";		
	var $page		=		"transaksi/kp";
	var $file		=		"kp";
	var $pk     =   "id_kp";
	var $title  =   "Kerja Praktik";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Master</a></li>										
	<li class='breadcrumb-item active'><a href='transaksi/kp'>Kerja Praktik</a></li>										
	</ol>";				          


	public function __construct()
	{		
		parent::__construct();
		//---- cek session -------//		

		//===== Load Database =====
		$this->load->database();
		$this->load->helper('url', 'string');
		$this->load->helper('permalink_helper');				
		//===== Load Model =====
		$this->load->model('m_admin');		
		$this->load->model('m_kp');		

		//===== Load Library =====
		$this->load->library('upload');
	}
	protected function template($data)
	{
		$name = $this->session->userdata('nama');
		if($data['set']=='delete' OR $data['set']=='edit' OR $data['set']=='view') $set=$data['set'];
			else $set = "insert";
		$auth = $this->m_admin->user_auth($this->file,$set);						
		if($name==""){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."a4dm11n'>";
		}elseif($auth=='false'){		
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."denied'>";		
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
		$id_user_type = $this->session->id_user_type;
		if($id_user_type==1){			
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
		$list = $this->m_kp->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $isi) {			
      $cekMhs = $this->m_admin->getByID("md_user","email",$isi->nim);
			$nama = ($cekMhs->num_rows()>0)?$cekMhs->row()->nama_lengkap:'';

			$cekDosen = $this->m_admin->getByID("md_dosen","id_dosen",$isi->id_dosbing);
			$dosen = ($cekDosen->num_rows()>0)?$cekDosen->row()->nama_lengkap:'';

			$proposal="";
			if(!is_null($isi->proposal)){
				$proposal = "<a href='assets/kp/$isi->proposal' class='btn btn-success btn-sm'>lihat file</a>";
			}

			$laporan="";
			if(!is_null($isi->laporan)){
				$laporan = "<a href='assets/kp/$isi->laporan' class='btn btn-success btn-sm'>lihat file</a>";
			}

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $isi->nim;
			$row[] = $nama;
			$row[] = "<a href='transaksi/kp/detail?id=$isi->id_kp'>$isi->judul</a>";						
			$row[] = $isi->abstrak;
			$row[] = $dosen;
			$row[] = $proposal;
			$row[] = $laporan;
			$row[] = "
						<a href=\"transaksi/kp/delete?id=$isi->id_kp\" onclick=\"return confirm('Anda yakin?')\" class=\"btn btn-danger btn-sm\" title=\"Hapus\"><i class=\"fa fa-trash\"></i></a>                          
            <a href=\"transaksi/kp/edit?id=$isi->id_kp\" class=\"btn btn-primary btn-sm\" title=\"Edit\"><i class=\"fa fa-edit\"></i></a>";	
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_kp->count_all(),
						"recordsFiltered" => $this->m_kp->count_filtered(),
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
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/kp'>";
	}		
	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tgl 		= gmdate("Y-m-d", time()+60*60*7);		
		$login_id		= $this->session->userdata("id_user");		
		$tabel		= $this->tables;		
		$pk				= $this->pk;
		$config['upload_path'] 		= './assets/kp/';
		$config['allowed_types'] 	= 'pdf';
		$config['max_size']				= '1000';		
    $config['encrypt_name'] 	= TRUE; 				

    $err = "";
    if(!empty($_FILES['proposal']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('proposal')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";				
				$data['proposal']	= $this->upload->file_name;
			}
		}
		$err2 = "";
    if(!empty($_FILES['laporan']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('laporan')){
				$err2 = $this->upload->display_errors();				
			}else{
				$err2 = "";				
				$data['laporan']	= $this->upload->file_name;
			}
		}

				
		$data['judul'] 			= $this->input->post('judul');								
		$data['abstrak'] 			= $this->input->post('abstrak');								
		$data['id_dosbing'] 			= $this->input->post('id_dosbing');						
		$data['nim'] 			= $this->input->post('nim');						
		$data['tgl_kirim'] 			= tgl();
		$data['status'] 			= 1;
		$data['created_at'] 			= $waktu;		
		$data['created_by'] 			= $login_id;		
		if($err=="" AND $err2==""){
			$this->m_admin->insert($tabel,$data);					
			$_SESSION['pesan'] 		= "Data berhasil disimpan";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/kp'>";					
		}else{
			$_SESSION['pesan'] 		= $err;
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";			
		}
		
	}	
	public function update()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tgl 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;		
		$config['upload_path'] 		= './assets/kp/';
		$config['allowed_types'] 	= 'pdf';
		$config['max_size']				= '1000';		
    $config['encrypt_name'] 	= TRUE; 				
		$id 	= $this->input->post('id');		

    $err = "";
    if(!empty($_FILES['proposal']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('proposal')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";
				$row = $this->m_admin->getByID("md_kp","id_kp",$id)->row();
	    	if(isset($row->proposal)){
	    		unlink('assets/kp/'.$row->proposal);         	    		
	    	}
				$data['proposal']	= $this->upload->file_name;
			}
		}
		$err2 = "";
    if(!empty($_FILES['laporan']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('laporan')){
				$err2 = $this->upload->display_errors();				
			}else{
				$err2 = "";
				$row = $this->m_admin->getByID("md_kp","id_kp",$id)->row();
	    	if(isset($row->laporan)){
	    		unlink('assets/kp/'.$row->laporan);         	    		
	    	}
				$data['laporan']	= $this->upload->file_name;
			}
		}
		
		$data['judul'] 			= $this->input->post('judul');								
		$data['abstrak'] 			= $this->input->post('abstrak');								
		$data['id_dosbing'] 			= $this->input->post('id_dosbing');						
		$data['nim'] 			= $this->input->post('nim');						
		$data['updated_at'] 			= $waktu;		
		if($err=="" AND $err2==""){
			$this->m_admin->update($tabel,$data,$pk,$id);					
			$_SESSION['pesan'] 		= "Data berhasil diubah";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/kp'>";					
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
		$data['dt_kp'] = $this->m_admin->getByID($tabel,$pk,$id);		
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
		$data['dt_kp'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}
}
