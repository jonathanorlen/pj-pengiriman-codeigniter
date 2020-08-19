<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class shipping_time extends MY_Controller {

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
        $data['konten'] = $this->load->view('shipping_time/daftar_shipping_time', NULL, TRUE);
        $data['halaman'] = $this->load->view('shipping_time/menu', $data, TRUE);
        $this->load->view('shipping_time/main', $data);       
        
    }	

    public function menu()
    {
        $data['aktif'] = 'master';
        $data['konten'] = $this->load->view('master/menu', NULL, TRUE);
        $data['halaman'] = $this->load->view('shipping_time/menu', $data, TRUE);
        $data['halaman'] = $this->load->view('shipping_time/menu', $data, TRUE);
        $this->load->view('shipping_time/main', $data);       
    }

    public function daftar()
    {
        $data['aktif'] = 'master';
        $data['konten'] = $this->load->view('shipping_time/daftar_shipping_time', NULL, TRUE);
        $data['halaman'] = $this->load->view('shipping_time/menu', $data, TRUE);
        $this->load->view('shipping_time/main', $data);       
    }

    public function tambah()
    {
        $data['aktif'] = 'master';
        $data['konten'] = $this->load->view('master/shipping_time/tambah_shipping_time', NULL, TRUE);
        $data['halaman'] = $this->load->view('shipping_time/menu', $data, TRUE);
        $this->load->view('shipping_time/main', $data);       
    }
    
    public function detail()
    {
        $data['aktif'] = 'master';
        $data['konten'] = $this->load->view('master/shipping_time/detail_shipping_time', NULL, TRUE);
        $data['halaman'] = $this->load->view('shipping_time/menu', $data, TRUE);
        $this->load->view('shipping_time/main', $data);       
    }

    public function simpan_shipping_time()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama_jadwal', 'Nama Jadwa;', 'required');
        $this->form_validation->set_rules('jam_1', 'Jam', 'required');
        $this->form_validation->set_rules('jam_2', 'Jam', 'required');    

        //jika form validasi berjalan salah maka tampilkan GAGAL
        if ($this->form_validation->run() == FALSE) {
            echo warn_msg(validation_errors());
        } 
        //jika form validasi berjalan benar maka inputkan data
        else {
            $data= $this->input->post();
            $this->db->insert("master_shipping", $data);
            echo $this->db->last_query();
            echo 'sukses';            
        }
    }    
     public function simpan_edit_shipping_time()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama_jadwal', 'Nama Jadwa;', 'required');
        $this->form_validation->set_rules('jam_1', 'Jam', 'required');
        $this->form_validation->set_rules('jam_2', 'Jam', 'required');    

        //jika form validasi berjalan salah maka tampilkan GAGAL
        if ($this->form_validation->run() == FALSE) {
            echo warn_msg(validation_errors());
        } 
        //jika form validasi berjalan benar maka inputkan data
        else {
            $data= $this->input->post();
            $this->db->update("master_shipping",$data,array('id'=>$data['id']));
            echo 'sukses';            
        }
    }    

    //------------------------------------------ Proses Delete----------------- --------------------//
    public function hapus(){
        $kode = $this->input->post('id');
        $this->db->delete('master_shipping',array('id'=>$kode));
    }

    
}
