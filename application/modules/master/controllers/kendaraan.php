<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class kendaraan extends MY_Controller {
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
	 * @see http://codeigniter.com/kendaraan_guide/general/urls.html
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
        $data['konten'] = $this->load->view('kendaraan/daftar_kendaraan', NULL, TRUE);
        $data['halaman'] = $this->load->view('kendaraan/menu', $data, TRUE);
        $this->load->view('kendaraan/main', $data);  
       
        	
	}	
    //------------------------------------------ View Data Table----------------- --------------------//
    public function menu()
    {
        $data['aktif'] = 'master';
        $data['konten'] = $this->load->view('master/menu', NULL, TRUE);
        $this->load->view ('main', $data);      
    }
	public function kendaraan()
	{
	    
       
        $data['aktif'] = 'master';
		$data['konten'] = $this->load->view('kendaraan/daftar_kendaraan', NULL, TRUE);
		$this->load->view ('main', $data);	
	}
	public function tambah()
	{
	   $data['aktif'] = 'master';
        $data['konten'] = $this->load->view('kendaraan/tambah_kendaraan', NULL, TRUE);
        $data['halaman'] = $this->load->view('kendaraan/menu', $data, TRUE);
        $this->load->view('kendaraan/main', $data);  
       
       	
	}
    public function detail()
    {
        $data['aktif'] = 'master';
        $data['konten'] = $this->load->view('kendaraan/detail_kendaraan', NULL, TRUE);
        $data['halaman'] = $this->load->view('kendaraan/menu', $data, TRUE);
        $this->load->view('kendaraan/main', $data); 
    }
    	//------------------------------------------ Proses Simpan----------------- --------------------//
     public function simpan_kendaraan()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('kode_kendaraan', 'Kode Kendaraan', 'required');
        $this->form_validation->set_rules('nama_kendaraan', 'Nama Kendaraan', 'required'); 
        $this->form_validation->set_rules('no_kendaraan', 'No. Kendaraan', 'required');
        $this->form_validation->set_rules('stnk', 'STNK', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        //jika form validasi berjalan salah maka tampilkan GAGAL
        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert alert-warning">Gagal Tersimpan.</div>';
        } 
        //jika form validasi berjalan benar maka inputkan data
        else {
            $data= $this->input->post();
            $this->db->insert("master_kendaraan", $data);
            echo $this->db->last_query();
            echo 'sukses';   
        }
    }
    //------------------------------------------ Proses Update----------------- --------------------//
    public function simpan_edit_kendaraan()
   {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('kode_kendaraan', 'Kode Kendaraan', 'required');
        $this->form_validation->set_rules('nama_kendaraan', 'Nama Kendaraan', 'required'); 
        $this->form_validation->set_rules('no_kendaraan', 'No. Kendaraan', 'required');
        $this->form_validation->set_rules('stnk', 'STNK', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        //jika form validasi berjalan salah maka tampilkan GAGAL
        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert alert-warning">Gagal Tersimpan.</div>';
        } 
        //jika form validasi berjalan benar maka inputkan data
        else {
            $data= $this->input->post();
            $this->db->update("master_kendaraan",$data,array('id'=>$data['id']));
            echo 'sukses';     
        }
        
    }
    //------------------------------------------ Proses Delete----------------- --------------------//
    public function hapus(){
        $id = $this->input->post('id');
        $this->db->delete('master_kendaraan',array('id'=>$id));
    }
}