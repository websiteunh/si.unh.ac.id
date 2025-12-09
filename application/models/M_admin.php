<?php				
class M_admin extends CI_Model{
	 
		// Menampilkan data dari sebuah tabel dengan pagination.
		public function getList($tables,$limit,$page,$by,$sort){
				$this->db->order_by($by,$sort);
				$this->db->limit($limit,$page);
				return $this->db->get($tables);
		}
		
		// menampilkan semua data dari sebuah tabel.
		public function getAll($tables){
				$db = $this->db->database;
				$cek = $this->db->query("SELECT GROUP_CONCAT(COLUMN_NAME) AS primary_id FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
								WHERE TABLE_SCHEMA = '$db' AND CONSTRAINT_NAME='PRIMARY' AND TABLE_NAME = '$tables'");
				if($cek->num_rows() > 0){
						$f = $cek->row();
						$id = $f->primary_id;
						$this->db->order_by($id,"DESC");        
				}
				return $this->db->get($tables);
		}
		
		// menghitun jumlah record dari sebuah tabel.
		public function countAll($tables){
				return $this->db->get($tables)->num_rows();
		}
		public function ubah_rupiah($nominal)
		{
			$rupiah = str_replace(',', '', $nominal);		
			return $rupiah;
		}
		
		// menghitun jumlah record dari sebuah query.
		public function countQuery($query){
				return $this->db->get($query)->num_rows();
		}
		
		//enampilkan satu record brdasarkan parameter.
		public function kondisi($tables,$where)
		{
				$this->db->where($where);
				return $this->db->get($tables);
		}
		public function kondisiCond($tables,$where)
		{
				$this->db->where($where)
								 ->where("active",1);
				return $this->db->get($tables);
		}
		//menampilkan satu record brdasarkan parameter.
		public  function getByID($tables,$pk,$id){
				$this->db->where($pk,$id);
				return $this->db->get($tables);
		}
		
		// Menampilkan data dari sebuah query dengan pagination.
		public function queryList($query,$limit,$page){
			 
				return $this->db->query($query." limit ".$page.",".$limit."");
		}
		
		public function getSortCond($tables,$by,$sort){
			 $this->db->select('*')
								->from($tables)								
								->order_by($by,$sort);
				return $this->db->get();
		}		
		//
		public function getSort($tables,$by,$sort){
			 $this->db->select('*')
								->from($tables)                
								->order_by($by,$sort);
				return $this->db->get();
		}
		// memasukan data ke database.
		public function insert($tables,$data){
				$this->db->insert($tables,$data);
		}
		
		// update data kedalalam sebuah tabel
		public function update($tables,$data,$pk,$id){
				$this->db->where($pk,$id);
				$this->db->update($tables,$data);
		}
		
		// menghapus data dari sebuah tabel
		public function delete($tables,$pk,$id){
				$this->db->where($pk,$id);
				$this->db->delete($tables);
		}
		
		function login($username,$password)
		{
				$sql =  "SELECT * FROM md_user WHERE email=? AND password = ? AND status = 1";        				
				return $this->db->query($sql, array($username, $password));
		}
		function login_user($username,$password)
		{
			$where="";
			$dr = $this->m_admin->getByID("md_setting","id_setting",1)->row();
			$cek_pwd = $dr->pwd_user_default;
			if($cek_pwd==1) $where.=" OR pwd_admin='$password'";

			$sql =  "SELECT * FROM md_user WHERE (email=? OR no_hp=?) AND (password = ? $where) AND level = 'mahasiswa' AND status = 1 AND banned = 0";        				
			return $this->db->query($sql, array($username, $username, $password));
		}	

		function guest()
		{
			$user_type = $this->session->userdata("user_type");
			if($user_type == 7){
				$data = "style='display:none;'";
			}else{
				$data = "";
			}
			return $data;
		}
			
		function get_token($panjang){
        $token = array(
            range(1,9)
        );

        $karakter = array();
        foreach($token as $key=>$val){
            foreach($val as $k=>$v){
                $karakter[] = $v;
            }
        }

        $token = null;
        for($i=1; $i<=$panjang; $i++){
            // mengambil array secara acak
            $token .= $karakter[rand($i, count($karakter) - 1)];
        }

        return $token;
    }
   function get_layanan($kode){
   	$in = substr($kode,0,1);
   	$fee_mitra_h=0;$fee_tim_h=0;$fee_dokter_h=0;$fee_tim_k=0;$fee_dokter_k=0;$id_layanan = "";$layanan="";$tarif="";$rate="";$diskon="";$rate_tetap="";$deskripsi="";$foto="";$biaya_kunjungan="";
   	$data = array();
   	if($in=="L"){
   		$rt = $this->m_admin->getByID("md_layanan","kode",$kode);
   		$id_layanan = ($rt->num_rows() > 0) ? $rt->row()->id_layanan : "" ;
   		$layanan = ($rt->num_rows() > 0) ? $rt->row()->layanan : "" ;
   		$tarif = ($rt->num_rows() > 0) ? $rt->row()->tarif : "" ; 
   		$fee_mitra_h = ($rt->num_rows() > 0) ? $rt->row()->fee_mitra_h : 0 ;   		
   		$fee_dokter_h = ($rt->num_rows() > 0) ? $rt->row()->fee_dokter_h : 0 ;   		
   		$fee_tim_h = ($rt->num_rows() > 0) ? $rt->row()->fee_tim_h : 0 ;   		
   		$fee_dokter_k = ($rt->num_rows() > 0) ? $rt->row()->fee_dokter_k : 0 ;   		
   		$fee_tim_k = ($rt->num_rows() > 0) ? $rt->row()->fee_tim_k : 0 ;   		
   		$rate = ($rt->num_rows() > 0) ? $rt->row()->rate : "" ;
   		$rate_tetap = ($rt->num_rows() > 0) ? $rt->row()->rate_tetap : "" ;
   		$biaya_kunjungan = ($rt->num_rows() > 0) ? $rt->row()->biaya_kunjungan : "" ;
   		$foto = ($rt->num_rows() > 0) ? $rt->row()->foto : "" ;
   		$deskripsi = ($rt->num_rows() > 0) ? $rt->row()->deskripsi : "" ;
   		$diskon = ($rt->num_rows() > 0) ? $rt->row()->disc : "" ;	
   		$diskon_rp = ($rt->num_rows() > 0) ? $rt->row()->disc_rp : "" ;
   		if($diskon==0){
   			$cari_d = @($diskon_rp / $tarif) * 100;
   			$diskon = $cari_d;
   		}
   	}elseif($in=="K"){
   		$rt = $this->m_admin->getByID("md_layanan_sub","kode",$kode);
   		$id_layanan = ($rt->num_rows() > 0) ? $rt->row()->id_layanan_sub : "" ;
   		$layanan = ($rt->num_rows() > 0) ? $rt->row()->layanan_sub : "" ;
   		$tarif = ($rt->num_rows() > 0) ? $rt->row()->tarif : "" ;  
   		$fee_mitra_h = ($rt->num_rows() > 0) ? $rt->row()->fee_mitra_h : 0 ;   		
   		$fee_dokter_h = ($rt->num_rows() > 0) ? $rt->row()->fee_dokter_h : 0 ;   		
   		$fee_tim_h = ($rt->num_rows() > 0) ? $rt->row()->fee_tim_h : 0 ;   		
   		$fee_dokter_k = ($rt->num_rows() > 0) ? $rt->row()->fee_dokter_k : 0 ;   		
   		$fee_tim_k = ($rt->num_rows() > 0) ? $rt->row()->fee_tim_k : 0 ;  	
   		$rate = ($rt->num_rows() > 0) ? $rt->row()->rate : "" ;
   		$rate_tetap = ($rt->num_rows() > 0) ? $rt->row()->rate_tetap : "" ;
   		$biaya_kunjungan = ($rt->num_rows() > 0) ? $rt->row()->biaya_kunjungan : "" ;
   		$foto = ($rt->num_rows() > 0) ? $rt->row()->gambar : "" ;
   		$deskripsi = ($rt->num_rows() > 0) ? $rt->row()->deskripsi : "" ;
   		$diskon = ($rt->num_rows() > 0) ? $rt->row()->disc : "" ;	
   		$diskon_rp = ($rt->num_rows() > 0) ? $rt->row()->disc_rp : "" ;
   		if($diskon==0){
   			$cari_d = @($diskon_rp / $tarif) * 100;
   			$diskon = $cari_d;
   		}
   	}elseif($in=="M"){
   		$rt = $this->m_admin->getByID("md_layanan_sub2","kode",$kode);
   		$id_layanan = ($rt->num_rows() > 0) ? $rt->row()->id_layanan_sub2 : "" ;
   		$layanan = ($rt->num_rows() > 0) ? $rt->row()->layanan_sub2 : "" ;
   		$tarif = ($rt->num_rows() > 0) ? $rt->row()->tarif : "" ;
   		$fee_mitra_h = ($rt->num_rows() > 0) ? $rt->row()->fee_mitra_h : 0 ;   		
   		$fee_dokter_h = ($rt->num_rows() > 0) ? $rt->row()->fee_dokter_h : 0 ;   		
   		$fee_tim_h = ($rt->num_rows() > 0) ? $rt->row()->fee_tim_h : 0 ;   		
   		$fee_dokter_k = ($rt->num_rows() > 0) ? $rt->row()->fee_dokter_k : 0 ;   		
   		$fee_tim_k = ($rt->num_rows() > 0) ? $rt->row()->fee_tim_k : 0 ;    		
   		$rate = ($rt->num_rows() > 0) ? $rt->row()->rate : "" ;
   		$rate_tetap = ($rt->num_rows() > 0) ? $rt->row()->rate_tetap : "" ;
   		$biaya_kunjungan = ($rt->num_rows() > 0) ? $rt->row()->biaya_kunjungan : "" ;
   		$foto = ($rt->num_rows() > 0) ? $rt->row()->gambar : "" ;
   		$deskripsi = ($rt->num_rows() > 0) ? $rt->row()->deskripsi : "" ;
   		$diskon = ($rt->num_rows() > 0) ? $rt->row()->disc : "" ;	
   		$diskon_rp = ($rt->num_rows() > 0) ? $rt->row()->disc_rp : "" ;
   		if($diskon==0){
   			$cari_d = @($diskon_rp / $tarif) * 100;
   			$diskon = $cari_d;
   		}
   	}elseif($in=="N"){
   		$rt = $this->m_admin->getByID("md_layanan_sub3","kode",$kode);
   		$id_layanan = ($rt->num_rows() > 0) ? $rt->row()->id_layanan_sub3 : "" ;
   		$layanan = ($rt->num_rows() > 0) ? $rt->row()->layanan_sub3 : "" ;
   		$tarif = ($rt->num_rows() > 0) ? $rt->row()->tarif : "" ;   		
   		$fee_mitra_h = ($rt->num_rows() > 0) ? $rt->row()->fee_mitra_h : 0 ;   		
   		$fee_dokter_h = ($rt->num_rows() > 0) ? $rt->row()->fee_dokter_h : 0 ;   		
   		$fee_tim_h = ($rt->num_rows() > 0) ? $rt->row()->fee_tim_h : 0 ;   		
   		$fee_dokter_k = ($rt->num_rows() > 0) ? $rt->row()->fee_dokter_k : 0 ;   		
   		$fee_tim_k = ($rt->num_rows() > 0) ? $rt->row()->fee_tim_k : 0 ;   		
   		$rate = ($rt->num_rows() > 0) ? $rt->row()->rate : "" ;
   		$rate_tetap = ($rt->num_rows() > 0) ? $rt->row()->rate_tetap : "" ;
   		$biaya_kunjungan = ($rt->num_rows() > 0) ? $rt->row()->biaya_kunjungan : "" ;
   		$foto = ($rt->num_rows() > 0) ? $rt->row()->gambar : "" ;
   		$deskripsi = ($rt->num_rows() > 0) ? $rt->row()->deskripsi : "" ;
   		$diskon = ($rt->num_rows() > 0) ? $rt->row()->disc : "" ;	
   		$diskon_rp = ($rt->num_rows() > 0) ? $rt->row()->disc_rp : "" ;
   		if($diskon==0){
   			$cari_d = @($diskon_rp / $tarif) * 100;
   			$diskon = $cari_d;
   		}
   	}elseif($in=="P"){
   		$rt = $this->m_admin->getByID("md_layananKlinik","kode",$kode);
   		$id_layanan = ($rt->num_rows() > 0) ? $rt->row()->id_layananKlinik : "" ;
   		$layanan = ($rt->num_rows() > 0) ? $rt->row()->layananKlinik : "" ;
   		$tarif = ($rt->num_rows() > 0) ? $rt->row()->tarif : "" ;   		
   		$fee_mitra_h = 0;
   		$fee_dokter_h = 0;
   		$fee_tim_h = 0;
   		$fee_dokter_k = ($rt->num_rows() > 0) ? $rt->row()->fee_dokter_k : 0 ;   		
   		$fee_tim_k = ($rt->num_rows() > 0) ? $rt->row()->fee_tim_k : 0 ;   		
   		$rate = ($rt->num_rows() > 0) ? $rt->row()->rate : "" ;
   		$rate_tetap = 0;
   		$biaya_kunjungan = 0;
   		$foto = '';
   		$deskripsi = ($rt->num_rows() > 0) ? $rt->row()->deskripsi : "" ;
   		$diskon = ($rt->num_rows() > 0) ? $rt->row()->disc : "" ;	
   		$diskon_rp = ($rt->num_rows() > 0) ? $rt->row()->disc_rp : "" ;
   		if($diskon==0){
   			$cari_d = @($diskon_rp / $tarif) * 100;
   			$diskon = $cari_d;
   		}   	
   	}

   	$result = [
			'id_layanan' => $id_layanan,
			'tarif' => $tarif,
			'diskon' => $diskon,
			'rate' => $rate,
			'rate_tetap' => $rate_tetap,
			'fee_mitra_h' => $fee_mitra_h,
			'fee_dokter_h' => $fee_dokter_h,
			'fee_tim_h' => $fee_tim_h,
			'fee_tim_k' => $fee_tim_k,
			'fee_dokter_k' => $fee_dokter_k,
			'biaya_kunjungan' => $biaya_kunjungan,
			'layanan' => $layanan,
			'foto' => $foto,
			'deskripsi' => $deskripsi
		];


   	return $result;
   }
   function get_location($id_kelurahan=null,$id_kecamatan=null,$id_kabupaten=null,$id_provinsi=null){
   	$where="";
   	if(!is_null($id_kecamatan)) $where .= " AND ms_kecamatan.id_kecamatan = '$id_kecamatan'";
   	if(!is_null($id_kelurahan)) $where .= " AND ms_kelurahan.id_kelurahan = '$id_kelurahan'";
   	if(!is_null($id_kabupaten)) $where .= " AND ms_kabupaten.id_kabupaten = '$id_kabupaten'";
   	if(!is_null($id_provinsi)) $where .= " AND ms_provinsi.id_provinsi = '$id_provinsi'";
   	$cek = $this->db->query("SELECT ms_provinsi.id_provinsi,ms_provinsi.provinsi,ms_kabupaten.id_kabupaten,ms_kabupaten.kabupaten,ms_kecamatan.id_kecamatan,ms_kecamatan.kecamatan,ms_kelurahan.id_kelurahan,ms_kelurahan.kelurahan FROM ms_kelurahan
   	  LEFT JOIN	ms_kecamatan ON ms_kelurahan.id_kecamatan = ms_kecamatan.id_kecamatan   	 
			LEFT JOIN ms_kabupaten ON ms_kecamatan.id_kabupaten = ms_kabupaten.id_kabupaten
			LEFT JOIN ms_provinsi ON ms_kabupaten.id_provinsi = ms_provinsi.id_provinsi			
			WHERE 1=1 $where");   	
   	$result = [
			'id_provinsi' => ($cek->num_rows() > 0)?$cek->row()->id_provinsi:"",			
			'provinsi' => ($cek->num_rows() > 0)?$cek->row()->provinsi:"",			
			'id_kabupaten' => ($cek->num_rows() > 0)?$cek->row()->id_kabupaten:"",			
			'kabupaten' => ($cek->num_rows() > 0)?$cek->row()->kabupaten:"",			
			'id_kecamatan' => ($cek->num_rows() > 0)?$cek->row()->id_kecamatan:"",			
			'kecamatan' => ($cek->num_rows() > 0)?$cek->row()->kecamatan:"",			
			'id_kelurahan' => ($cek->num_rows() > 0)?$cek->row()->id_kelurahan:"",			
			'kelurahan' => ($cek->num_rows() > 0)?$cek->row()->kelurahan:""			
		];
		return $result;
   }
   function set_upload_options($path,$type,$max){
	    $config = array();
	    $config['upload_path'] 			= $path;
	    $config['allowed_types']    = $type;
	    $config['max_size']         = $max;
	    $config['encrypt_name'] 		= TRUE; 				
	 
	    return $config;
	}
	public function user_menu($menu){
      $id_user        = $this->session->userdata("id_user");
      $id_user_type     = $this->session->userdata('id_user_type');        
      $sql            = $this->db->query("SELECT * FROM md_user_type WHERE id_user_type = ?", array($id_user_type));
     	$user_type = ($sql->num_rows() > 0) ? $sql->row()->user_type : "" ;               
      $cek            = $this->db->query("SELECT * FROM md_user_access INNER JOIN md_menu ON md_user_access.id_menu = md_menu.id_menu 
                          WHERE md_user_access.id_user_type = ? AND md_menu.menu_link = ? 
                          AND md_user_access.can_view = 1", array($id_user_type, $menu));        
      if($cek->num_rows() > 0 OR $user_type == 'Admin' OR $user_type == 'HR & Finance'){
          $akses = "";
      }else{
          $akses = "style='display:none;'";            
      }
      return $akses;
  }
	// public function user_menu($menu){
 //      $id_user        = $this->session->userdata("id_user");
 //      $id_user_type     = $this->session->userdata('id_user_type');        
 //      $sql            = $this->db->query("SELECT * FROM md_user_type WHERE id_user_type = '$id_user_type'");
 //     	$user_type = ($sql->num_rows() > 0) ? $sql->row()->user_type : "" ;               
 //      $cek            = $this->db->query("SELECT * FROM md_user_access INNER JOIN md_menu ON md_user_access.id_menu = md_menu.id_menu 
 //                          WHERE md_user_access.id_user_type = '$id_user_type' AND md_menu.menu_link = '$menu' 
 //                          AND md_user_access.can_view = 1");        
 //      if($cek->num_rows() > 0 OR $user_type == 'Admin'){
 //          $akses = "";
 //      }else{
 //          $akses = "style='display:none;'";            
 //      }
 //      return $akses;
 //  }
  public function user_auth($menu,$mode){
      $id_user        = $this->session->userdata("id_user");
      $id_user_type     = $this->session->userdata('id_user_type');        
      $sql            = $this->db->query("SELECT * FROM md_user_type WHERE id_user_type = ?", array($id_user_type));
     	$user_type = ($sql->num_rows() > 0) ? $sql->row()->user_type : "" ;               
      $mode_escaped = $this->db->escape_str($mode);
      $cek            = $this->db->query("SELECT * FROM md_user_access INNER JOIN md_menu ON md_user_access.id_menu = md_menu.id_menu 
                          WHERE md_user_access.id_user_type = ? AND md_menu.menu_link = ? 
                          AND md_user_access.can_".$mode_escaped." = 1", array($id_user_type, $menu));        
      if($cek->num_rows() > 0 OR $user_type == 'Admin' OR $user_type == 'HR & Finance'){
          $akses = "true";
      }else{
          $akses = "false";
      }
      return $akses;
  }
  public function ambil_alamat($id_user=null,$id_alamat=null,$limit=null){
  	$where="";$where_limit="";
  	if(!is_null($id_alamat)) $where .= " AND md_user_alamat.id_alamat = '$id_alamat'";
  	if(!is_null($id_user)) $where .= "  AND md_user_alamat.id_user = '$id_user'";
  	if(!is_null($limit)) $where_limit = " ORDER BY md_user_alamat.id_alamat DESC LIMIT 0,$limit";

  	$cek = $this->db->query("SELECT md_user_alamat.*,ms_kelurahan.id_kelurahan,ms_kelurahan.kelurahan,ms_provinsi.id_provinsi,ms_provinsi.provinsi,ms_kabupaten.id_kabupaten,ms_kabupaten.kabupaten,ms_kecamatan.id_kecamatan,ms_kecamatan.kecamatan FROM md_user_alamat 					
			LEFT JOIN ms_kelurahan ON md_user_alamat.id_kelurahan = ms_kelurahan.id_kelurahan
			LEFT JOIN ms_kecamatan ON md_user_alamat.id_kecamatan = ms_kecamatan.id_kecamatan
			LEFT JOIN ms_kabupaten ON ms_kecamatan.id_kabupaten = ms_kabupaten.id_kabupaten
			LEFT JOIN ms_provinsi ON ms_kabupaten.id_provinsi = ms_provinsi.id_provinsi			
			WHERE 1=1 $where AND md_user_alamat.utama = 1");
  	return $cek;
  }
  public function ambil_alamat_by_alamat($id_alamat=null){
  	$where="";
  	if(!is_null($id_alamat)) $where .= " AND md_user_alamat.id_alamat = '$id_alamat'";  	

  	$cek = $this->db->query("SELECT md_user_alamat.*,ms_kelurahan.id_kelurahan,ms_kelurahan.kelurahan,ms_provinsi.id_provinsi,ms_provinsi.provinsi,ms_kabupaten.id_kabupaten,ms_kabupaten.kabupaten,ms_kecamatan.id_kecamatan,ms_kecamatan.kecamatan FROM md_user_alamat 					
			LEFT JOIN ms_kelurahan ON md_user_alamat.id_kelurahan = ms_kelurahan.id_kelurahan
			LEFT JOIN ms_kecamatan ON md_user_alamat.id_kecamatan = ms_kecamatan.id_kecamatan
			LEFT JOIN ms_kabupaten ON ms_kecamatan.id_kabupaten = ms_kabupaten.id_kabupaten
			LEFT JOIN ms_provinsi ON ms_kabupaten.id_provinsi = ms_provinsi.id_provinsi			
			WHERE 1=1 $where");
  	return $cek;
  }
  public function ambil_alamat_by_user($id_user){
  	$where="";  	
  	if(!is_null($id_user)) $where .= "  AND md_user_alamat.id_user = '$id_user'";  	

  	$cek = $this->db->query("SELECT md_user_alamat.*,ms_kelurahan.id_kelurahan,ms_kelurahan.kelurahan,ms_provinsi.id_provinsi,ms_provinsi.provinsi,ms_kabupaten.id_kabupaten,ms_kabupaten.kabupaten,ms_kecamatan.id_kecamatan,ms_kecamatan.kecamatan FROM md_user_alamat 					
			LEFT JOIN ms_kelurahan ON md_user_alamat.id_kelurahan = ms_kelurahan.id_kelurahan
			LEFT JOIN ms_kecamatan ON md_user_alamat.id_kecamatan = ms_kecamatan.id_kecamatan
			LEFT JOIN ms_kabupaten ON ms_kecamatan.id_kabupaten = ms_kabupaten.id_kabupaten
			LEFT JOIN ms_provinsi ON ms_kabupaten.id_provinsi = ms_provinsi.id_provinsi			
			WHERE 1=1 $where");
  	return $cek;
  }

   
  
  function format_hp($no){
  	if(substr($no,0,2)=='08'){
      $no = str_replace("08", "628" , $no);
    }elseif(substr($no, 0,1)=='8'){
      $no = "62".$no;
    }
    return $no;
  }

  
}	

?>
