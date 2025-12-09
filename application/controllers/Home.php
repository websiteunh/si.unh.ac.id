<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

  var $tables =   "ind_user";		
  var $file		=		"dashboard";
  var $page		=		"dashboard";
  var $pk     =   "user_id";
  var $title  =   "Home";
  var $bread	=   "<a href='' class='current'>Home</a>";				          

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
			$this->load->view('frontend/header',$data);
			$this->load->view('frontend/aside');			
			$this->load->view($this->page);		
			$this->load->view('frontend/footer');
		}
	}
	public function index()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "home";				
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();		
		$this->load->view("frontend/header",$data);						
		$this->load->view("frontend/index");						
		$this->load->view("frontend/footer");						
	}
	public function maintenance()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "home";				
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();		
		$this->load->view("m4int3nanc3",$data);								
	}
	public function loginMhs()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "kontak";				
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();
		$this->load->view("frontend/header",$data);						
		$this->load->view("frontend/loginMhs");						
		$this->load->view("frontend/footer");						
		
	}
	public function registrasiMhs()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "kontak";				
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();
		$this->load->view("frontend/header",$data);						
		$this->load->view("frontend/registrasiMhs");						
		$this->load->view("frontend/footer");							
	}
	public function blog()
  {        
    //konfigurasi pagination
    $config['base_url'] = 'blog/pages'; //site url
    $config['total_rows'] = $this->db->count_all('md_artikel'); //total row
    $config['per_page'] = 4;  //show record per halaman
    $config["uri_segment"] = 3;  // uri parameter
    $choice = $config["total_rows"] / $config["per_page"];
    // $config["num_links"] = 2;//floor($choice);

    // Membuat Style pagination untuk BootStrap v4
    $config['use_page_numbers'] = TRUE;
    $config['reuse_query_string'] = TRUE;
    $config['first_link']       = 'First';
    $config['last_link']        = 'Last';
    $config['next_link']        = 'Next';
    $config['prev_link']        = 'Prev';
    $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']   = '</ul></nav></div>';
    $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']    = '</span></li>';
    $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']  = '</span>Next</li>';
    $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
    $config['first_tagl_close'] = '</span></li>';
    $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['last_tagl_close']  = '</span></li>';

    $this->pagination->initialize($config);
    $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    //panggil function get_mahasiswa_list yang ada pada mmodel mahasiswa_model. 
    // public function getList($tables,$limit,$page,$by,$sort){
    $limit = $config['per_page'];
    $start = $data['page'];
    $data['dt_artikel'] = $this->db->query("SELECT md_artikel_kategori.permalink AS permalink_ka, md_artikel.*,md_artikel_kategori.kategori,md_user.nama_lengkap FROM md_artikel 
        LEFT JOIN md_artikel_kategori ON md_artikel.id_artikel_kategori = md_artikel_kategori.id_artikel_kategori
        LEFT JOIN md_user ON md_artikel.created_by = md_user.id_user
        WHERE md_artikel.status = 'publish' ORDER BY md_artikel.id_artikel DESC LIMIT $start, $limit");
        
    //$data['data'] = $this->m_admin->getList("md_artikel",$config["per_page"], $data['page'],"id_artikel","DESC");                   
    $data['pagination'] = $this->pagination->create_links();
    $data['title']      = "Blog";   
    $data['setting'] = $this->m_admin->getByID("md_setting","id_setting",1)->row();         
    $data['cari'] =  $id = $this->input->get("cari");       
    $data['set'] = "blog";      
    $data['mode'] = ""; 
 

    $this->load->view('frontend/header',$data);		
		$this->load->view("frontend/blog");		
		$this->load->view('frontend/footer');
	}
	
	public function saveRegistrasi(){
		$data2['nama_lengkap'] = $this->input->post("nama_lengkap",TRUE);
		$data2['email'] = $email = $this->input->post("email",TRUE);
		$data2['nim'] = $this->input->post("nim",TRUE);
		$password = $this->input->post("password",TRUE);
		$password2 = $this->input->post("password2",TRUE);
		if($password==$password2){
			$cek = $this->m_admin->getByID("md_user","email",$email);
			if($cek->num_rows()==0){
				$data2['status'] = 1;
				$data2['created_at'] = waktu();
				$data2['password'] = md5(encr().$this->input->post('password'));				
				$data2['level'] = "user";
				$data2['id_user_type'] = "3";
				$data2['jenis'] = "mahasiswa";
				$data2['status'] = "1";
				$data2['created_at'] = waktu();
				$data2['tgl_daftar'] = tgl();				
				$this->m_admin->insert("md_user",$data2);				
				$_SESSION['pesan'] 	= "Selamat, akun kamu berhasil didaftarkan. Silakan login";
				$_SESSION['tipe'] 	= "success";			
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."login-mhs'>";		
			}else{
				$_SESSION['pesan'] 	= "Email sudah terdaftar";
				$_SESSION['tipe'] 	= "danger";
				echo "<script>history.go(-1)</script>";							
			}			
		}else{
			$_SESSION['pesan'] 	= "Password harus sama!";
			$_SESSION['tipe'] 	= "danger";
			echo "<script>history.go(-1)</script>";							
		}				
	}

	public function kategori($permalink){
		$dt_kategori = $this->db->query("SELECT * FROM md_artikel_kategori WHERE permalink = ?", array($permalink));
		$data['cari'] = $dt_kategori->row()->kategori;		
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "blog";				
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();
		$this->load->view("frontend/header",$data);						
		$this->load->view("frontend/cari");						
		$this->load->view("frontend/footer");		
	}
	public function penulis($id){
		$dt_kategori = $this->db->query("SELECT md_artikel.*, md_user.nama_lengkap FROM md_artikel 
			LEFT JOIN md_user ON md_artikel.created_by = md_user.id_user
			WHERE md_artikel.created_by = ?", array($id));
		$data['cari'] = $dt_kategori->row()->nama_lengkap;
		$data['id'] = $id;
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "blog";				
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();
		$this->load->view("frontend/header",$data);						
		$this->load->view("frontend/penulis");						
		$this->load->view("frontend/footer");		
	}
	public function loginPost()
	{
		$username =	$this->input->post('username');
		$password = md5(encr().$this->input->post('password'));				
		$tgl 			= gmdate("Y-m-d h:i:s", time() + 60 * 60 * 7);
		
		$rs_login = $this->m_admin->login_user($username, $password);				
		if ($rs_login->num_rows() == 1) {
			$row = $rs_login->row();										
			$newdata = array(
				'username'  => $row->email,
				'nama'     	=> $row->nama_lengkap,
				'foto'     	=> $row->foto,
				'id_user' 	=> $row->id_user,
				'level' 		=> $row->level,														
				'id_user_type' => $row->id_user_type				
			);
			$nama = $row->nama_lengkap;
			$this->session->set_userdata($newdata);
			$_SESSION['pesan'] 	= "Selamat Datang, ".$nama."!";
			$_SESSION['tipe'] 	= "success";
			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "a4dm11n/dashboard'>";						
		} else {
			echo "<script>alert('Kombinasi Username & Password salah!')</script>";
			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "home?usernametidakada'>";
		}					
	}	
	public function detail($permalink)
  {
      $data['permalink'] =  $permalink;        
      $data['dt_artikel'] = $dt = $this->db->query("SELECT md_user.desc, md_user.foto AS fotos, md_artikel.*, md_artikel_kategori.permalink AS permalink_ka, md_artikel_kategori.kategori, md_user.nama_lengkap FROM md_artikel
          LEFT JOIN md_artikel_kategori ON md_artikel.id_artikel_kategori = md_artikel_kategori.id_artikel_kategori
          LEFT JOIN md_user ON md_artikel.created_by = md_user.id_user          
          WHERE md_artikel.permalink = ?", array($permalink));          
      
      // Check if article exists
      if($dt->num_rows() == 0) {
          show_404();
          return;
      }
      
      $data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();
      $data['set'] = "blog";

      $sql = $this->m_admin->getByID("md_artikel","permalink",$permalink)->row();
      if($sql) {
          $datas['baca'] = $sql->baca+1;
          $this->m_admin->update("md_artikel",$datas,"id_artikel",$sql->id_artikel);
      }
      
      $row = $data['dt_artikel']->row();
      $data['title']      = $row->judul;
      $data['description'] = strip_tags($row->preview);
      $data['keywords'] = $row->keywords;

      $this->load->view('frontend/header',$data);			
			$this->load->view("frontend/detail");		
			$this->load->view('frontend/footer');
  }
  public function cari()
	{								
		$data['cari'] = $this->input->post("cari",true);
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "blog";				
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();
		$this->load->view("frontend/header",$data);						
		$this->load->view("frontend/cari");						
		$this->load->view("frontend/footer");							
	}

	public function dosen()
	{										
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "dosen";				
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();		
		$this->load->view("frontend/header",$data);						
		$this->load->view("frontend/dosen");						
		$this->load->view("frontend/footer");							
	}

	public function dosenDetail($nidn)
	{										
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "dosen";				
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();		
		$this->load->view("frontend/header",$data);						
		$this->load->view("frontend/dosenDetail");						
		$this->load->view("frontend/footer");							
	}

	public function infoDetail($id)
	{										
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "informasi";			
		$data['permalink'] = $id;
		$data['dt_artikel'] = $dt = $this->db->query("SELECT md_informasi.*, md_kategori.kategori, md_kategori.slug AS slug_k FROM md_informasi
				JOIN md_kategori ON md_informasi.id_kategori = md_kategori.id_kategori
        WHERE md_informasi.slug = ?", array($id));          
      $data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();	
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();		
		$this->load->view("frontend/header",$data);						
		$this->load->view("frontend/detailInfo");						
		$this->load->view("frontend/footer");							
	}
	public function informasi($id)
	{										
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "informasi";			
		$data['permalink'] = $id;
		$data['dt_artikel'] = $dt = $this->db->query("SELECT md_informasi.*, md_kategori.kategori, md_kategori.slug AS slug_k FROM md_informasi
				JOIN md_kategori ON md_informasi.id_kategori = md_kategori.id_kategori
        WHERE md_kategori.slug = ?", array($id));          
    $data['info'] = $this->m_admin->getByID("md_kategori","slug",$id)->row()->kategori;      
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();		
		$this->load->view("frontend/header",$data);						
		$this->load->view("frontend/informasi");						
		$this->load->view("frontend/footer");							
	}
	public function p($id)
	{										
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "profil";			
		$data['permalink'] = $id;
		$data['dt_artikel'] = $dt = $this->db->query("SELECT md_informasi.*, md_kategori.kategori, md_kategori.slug AS slug_k FROM md_informasi
				JOIN md_kategori ON md_informasi.id_kategori = md_kategori.id_kategori
        WHERE md_informasi.slug = ?", array($id));          
    $data['info'] = $dt->row()->kategori;      
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();		
		$this->load->view("frontend/header",$data);						
		$this->load->view("frontend/detailInfo");						
		$this->load->view("frontend/footer");							
	}

	public function a($id)
	{										
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "akreditasi";			
		$data['permalink'] = $id;
		$data['dt_artikel'] = $dt = $this->db->query("SELECT md_informasi.*, md_kategori.kategori, md_kategori.slug AS slug_k FROM md_informasi
				JOIN md_kategori ON md_informasi.id_kategori = md_kategori.id_kategori
        WHERE md_informasi.slug = ?", array($id));          
    $data['info'] = $dt->row()->kategori;      
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();		
		$this->load->view("frontend/header",$data);						
		$this->load->view("frontend/detailInfo");						
		$this->load->view("frontend/footer");							
	}	
 
}
