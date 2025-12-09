<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends CI_Controller {

	var $tables =   "md_user";		
	var $page		=		"master/mahasiswa";
	var $file		=		"mahasiswa";
	var $pk     =   "id_user";
	var $title  =   "Mahasiswa";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Master</a></li>										
	<li class='breadcrumb-item active'><a href='master/mahasiswa'>Mahasiswa</a></li>										
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
		$this->load->model('m_user');		

		//===== Load Library =====
		$this->load->library('upload');
	}
	protected function template($data)
	{
		$name = $this->session->userdata('nama');
		$auth = $this->m_admin->user_auth($this->file,$data['set']);						
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
		$data['set']		= "view";		
		$data['mode']		= "view";				
		$this->template($data);	
	}	
	public function add()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Tambah ".$this->title;	
		$data['bread']	= $this->bread;																															
		$data['dt_user_type'] = $this->m_admin->getByID('md_user_type',"id_user_type",3);		
		//$data['dt_kelurahan'] = $this->m_admin->getAll('ms_kelurahan');		
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
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/mahasiswa'>";
	}	
	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;
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
				$data['foto']	= $this->upload->file_name;
			}
		}
		$data['status'] 			= 1;
		$data['id_user_type'] 			= 3;
		$data['nama_lengkap'] 			= $this->input->post('nama_lengkap');						
		$data['email'] 			= $this->input->post('email');				
		$data['no_hp'] 			= $this->input->post('no_hp');				
		$data['jenis'] 			= "mahasiswa";						
		$data['password'] 			= md5(encr().$this->input->post('password'));				
		$data['tgl_daftar'] 			= $waktu;
		$data['created_at'] 			= $waktu;
		
		$this->m_admin->insert($tabel,$data);					
		$_SESSION['pesan'] 		= "Data berhasil diubah";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/mahasiswa'>";							
	}	
	public function update()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;	
		$config['upload_path'] 		= './assets/uploads/images/';
		$config['allowed_types'] 	= 'jpg|png|bmp|jpeg';
		$config['max_size']				= '1000';		
    $config['encrypt_name'] 	= TRUE; 				
		$id 	= $this->input->post('id');		

    $err = "";
    if(!empty($_FILES['foto']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('foto')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";
				$row = $this->m_admin->getByID("md_karyawan","id_karyawan",$id)->row();
	    	if(isset($row->foto)){
	    		unlink('assets/uploads/images/'.$row->foto);         	    		
	    	}
				$data['foto']	= $this->upload->file_name;
			}
		}			
		
		$data['nama_lengkap'] 			= $this->input->post('nama_lengkap');						
		$data['email'] 			= $this->input->post('email');				
		$data['no_hp'] 			= $this->input->post('no_hp');						
		$password 			= $this->input->post('password');
		if($password!=""){				
			$data['password'] 			= md5(encr().$this->input->post('password'));				
		}
		$data['updated_at'] 			= $waktu;
		
		$this->m_admin->update($tabel,$data,$pk,$id);					
		$_SESSION['pesan'] 		= "Data berhasil diubah";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/mahasiswa'>";					
		
	}
	public function download()
	{				
		$this->load->view('master/templateMhs');
	}
	public function importExcel() {		
    $id_user = $this->session->userdata("id_user");				
    $config = $this->m_admin->set_upload_options('./excel/', 'xlsx', '10000');
    $err = "";
    if (!empty($_FILES['file']['name'])) {
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('file')) {
            $err = $this->upload->display_errors();
            $_SESSION['pesan'] = $err;
            $_SESSION['tipe'] = "danger";						
            echo "<script>history.go(-1)</script>";
            exit();
        } else {
            $err = "";
            $data['file'] = $fileName = $this->upload->file_name;
        }

        $file_excel = './excel/' . $fileName;

        $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();		
        $spreadsheet = $render->load($file_excel);

        $data = $spreadsheet->getActiveSheet()->toArray();
        
        foreach ($data as $x => $rowData) {
            if ($x == 0) {
                continue;
            }
            
            $pass = $rowData[1] . "_mhs";
            $password = md5(encr() . $pass);				

            // Data yang akan disimpan atau diupdate
            $simpandata = [				
                "email" => $rowData[1],
                "nama_lengkap" => $rowData[0],                
                "jenis" => "mahasiswa",
                "status" => 1,
                "id_user_type" => 3,
                "password" => $password,	        	       
                "tgl_daftar" => waktu(),
                "created_at" => waktu(),	        
                "level" => "mahasiswa"	        
            ];

            // Periksa apakah email sudah ada
            $existing = $this->db->get_where('md_user', ['email' => $rowData[1]])->row_array();

            if ($existing) {
                // Jika data sudah ada, lakukan update
                $this->db->update('md_user', $simpandata, ['email' => $rowData[1]]);
            } else {
                // Jika data belum ada, lakukan insert
                $this->db->insert('md_user', $simpandata);
            }
        }
    }		

    $_SESSION['pesan'] = "Data berhasil diimport";
    $_SESSION['tipe'] = "success";						
    echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "master/mahasiswa'>";
	} 
	public function import()
	{			
		$data['isi']    = $this->file;		
		$data['title']	= "Import ".$this->title;	
		$data['bread']	= $this->bread;																															
		$data['set']		= "insert";	
		$data['mode']		= "import";									
		$this->template($data);	
	}
	public function akun()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;	
		$id = $this->input->get("id");
		$cek = $this->m_admin->getByID("md_user","id_user",$id)->row();		
		
		$pass = $cek->email."_mhs";
		$password = md5(encr().$pass);				
		
		$data['password'] 	= $password;
		$data['status'] 	= 1;
		$data['banned'] 	= 0;
		$data['updated_at']	= $waktu;
		
		$this->m_admin->update($tabel,$data,$pk,$id);					
		$_SESSION['pesan'] 		= "Password berhasil direset";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/mahasiswa'>";					
		
	}
	public function aktifkan()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;	
		$id = $this->input->get("id");		
		$data['status'] = $data['admin_verified'] = $data['email_verified'] 	= 1;
		$data['updated_at'] = $data['verified_time']	= $waktu;
		
		$this->m_admin->update($tabel,$data,$pk,$id);					
		$_SESSION['pesan'] 		= "Akun berhasil diaktifasi";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/mahasiswa'>";					
		
	}
	public function banned()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;	
		$id = $this->input->get("id");		
		$data['status'] = 0;
		$data['banned'] = 1;
		$data['updated_at'] = $waktu;
		
		$this->m_admin->update($tabel,$data,$pk,$id);					
		$_SESSION['pesan'] 		= "Akun berhasil di-banned";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/mahasiswa'>";					
		
	}	
	public function resend(){
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;	
		$id = $this->input->get("id");		
		$cek = $this->m_admin->getByID("md_user","id_user",$id)->row();
		$email_dec = $cek->email;

		$otp = rand(1000,9999);		
		$this->db->query("UPDATE md_user SET otp = ? WHERE email = ?", array($otp, $email_dec));		
		$kirim = $this->m_admin->send_verifikasi($email_dec,$otp);
		
		if($kirim=="berhasil"){
			$this->db->query("UPDATE md_user SET email_sent = 1 WHERE email = ?", array($email_dec));
			$_SESSION['pesan'] 		= "Kode OTP terkirim, silahkan cek kotak masuk Email atau spam anda";
			$_SESSION['tipe'] 		= "success";
		}else{
			$_SESSION['pesan'] 		= $kirim;
			$_SESSION['tipe'] 		= "danger";
		}
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/user'>";					

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
		$data['dt_user_type'] = $this->m_admin->getByID('md_user_type',"id_user_type",3);		
		//$data['dt_kelurahan'] = $this->m_admin->getAll('ms_kelurahan');		
		$data['dt_mahasiswa'] = $this->m_admin->getByID($tabel,$pk,$id);		
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
		$data['dt_user_type'] = $this->m_admin->getByID('md_user_type',"id_user_type",3);		
		//$data['dt_kelurahan'] = $this->m_admin->getAll('ms_kelurahan');		
		$data['dt_mahasiswa'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}
}
