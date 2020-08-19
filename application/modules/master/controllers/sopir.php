<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class sopir extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();		
		if ($this->session->userdata('astrosession') == FALSE) {
			redirect(base_url('authenticate'));			
		}
        $this->load->library('form_validation');
	}

	public function index()
	{
        $data['aktif'] = 'master';
        $data['konten'] = $this->load->view('sopir/daftar_sopir', NULL, TRUE);
        $data['halaman'] = $this->load->view('sopir/menu', $data, TRUE);
        $this->load->view('sopir/main', $data);  

       /* $data['aktif']='master';
		$data['konten'] = $this->load->view('sopir/daftar_sopir', NULL, TRUE);
		$this->load->view ('main', $data);	*/
		
	}	

    //------------------------------------------ View Data Table----------------- --------------------//

    public function menu()
    {
        $data['aktif']='master';
        $data['konten'] = $this->load->view('master/menu', NULL, TRUE);
        $this->load->view ('main', $data);      
    }

	public function hak_akses()
	{
        $data['aktif']='master';
		$data['konten'] = $this->load->view('sopir/daftar_sopir', NULL, TRUE);
		$this->load->view ('main', $data);	
	}

	public function tambah()
	{
	    $data['aktif'] = 'master';
        $data['konten'] = $this->load->view('sopir/tambah_sopir', NULL, TRUE);
        $data['halaman'] = $this->load->view('sopir/menu', $data, TRUE);
        $this->load->view('sopir/main', $data);  
       
        
	}

    public function detail()
    {
        $data['aktif'] = 'master';
        $data['konten'] = $this->load->view('sopir/detail_sopir', NULL, TRUE);
        $data['halaman'] = $this->load->view('sopir/menu', $data, TRUE);
        $this->load->view('sopir/main', $data);  
        
         
    }

    public function get_kode()
    {
        $kode_sopir = $this->input->post('kode_sopir');
        $query = $this->db->get_where('master_sopir',array('kode_sopir' => $kode_sopir))->num_rows();

        if($query > 0){
            echo "1";
        }
        else{
            echo "0";
        }
    }
    
    	//------------------------------------------ Proses Simpan----------------- --------------------//
   	

    public function simpan_tambah_sopir()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('kode_supir', 'Kode Supir', 'required');
        $this->form_validation->set_rules('nama', 'Nama Supir', 'required'); 
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('no_hp', 'Telepon', 'required');

        //jika form validasi berjalan salah maka tampilkan GAGAL
        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert alert-warning">Gagal Tersimpan.</div>';
        } 
        //jika form validasi berjalan benar maka inputkan data
        else {
            $data= $this->input->post();
            $this->db->insert("master_supir", $data);
            echo $this->db->last_query();
            echo 'sukses';   
        }
    }

    
    //------------------------------------------ Proses Update----------------- --------------------//
    
    public function simpan_edit_supir()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('kode_supir', 'Kode Supir', 'required');
        $this->form_validation->set_rules('nama', 'Nama Supir', 'required'); 
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('no_hp', 'Telepon', 'required');

        //jika form validasi berjalan salah maka tampilkan GAGAL
        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert alert-warning">Gagal Tersimpan.</div>';
        } 
        //jika form validasi berjalan benar maka inputkan data
        else {
           $data= $this->input->post();
            $this->db->update("master_supir",$data,array('id'=>$data['id']));
            echo 'sukses';     
        }
    }
    
   
    //------------------------------------------ Proses Delete----------------- --------------------//
    public function hapus(){
        $id = $this->input->post('id');
        $this->db->delete('master_supir',array('id'=>$id));
    }

}
