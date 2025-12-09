<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class A4dm11n extends CI_Controller {

  var $tables =   "ind_user";		
  var $file		=		"dashboard";
  var $page		=		"dashboard";
  var $pk     =   "user_id";
  var $title  =   "Dashboard";
  var $bread	=   "<a href='' class='current'>Dashboard</a>";				          

	public function __construct()
	{		
		parent::__construct();
		//---- cek session -------//		

		//===== Load Database =====
		$this->load->database();
		$this->load->helper('url', 'string');
		//===== Load Model =====
		$this->load->model('m_admin');		
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
		$this->load->view("login",$data);		
	}
	public function login()
	{
		$username =	$this->input->post('username');
		$password = md5(encr().$this->input->post('password'));				
		$tgl 			= gmdate("Y-m-d h:i:s", time() + 60 * 60 * 7);		
		$rs_login = $this->m_admin->login($username, $password);				
		if ($rs_login->num_rows() == 1) {
			$row = $rs_login->row();										
			$newdata = array(
				'username'  => $row->email,
				'nama'     	=> $row->nama_lengkap,
				'foto'     	=> $row->foto,
				'id_user' 	=> $row->id_user,
				'level' 		=> $row->level,										
				'jenis' 		=> $row->jenis,										
				'id_dosen' 		=> $row->id_dosen,
				'id_user_type' => $row->id_user_type,
				'app' => "repo-iim"
			);
			$nama = $row->nama_lengkap;
			$this->session->set_userdata($newdata);
			$_SESSION['pesan'] 	= "Selamat Datang, ".$nama."!";
			$_SESSION['tipe'] 	= "success";
			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "a4dm11n/dashboard'>";						
		} else {
			$_SESSION['pesan'] 	= "Kombinasi Username dan Password salah!";
			$_SESSION['tipe'] 	= "danger";
			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "a4dm11n?usernametidakada'>";
		}		
			
	}
	public function logout()
	{		
		$id_user_type = $this->session->id_user_type;
		session_destroy();
		session_unset();
		if($id_user_type==3){
			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "home'>";
		}else{
			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "a4dm11n'>";
		}
				
	}
	public function dashboard()	
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "dashboard";		
		$data['title2']	= "Dashboard";				
		$this->template($data);	
	}
	public function infografis()	
	{																
		$data['isi']    = "infografis";		
		$data['title']	= "infografis";	
		$data['bread']	= "Infografis";																													
		$data['set']		= "view";						
		$this->load->view('back_template/header',$data);
		$this->load->view('back_template/aside');			
		$this->load->view("infografis");		
		$this->load->view('back_template/footer');
	}	
	
}
