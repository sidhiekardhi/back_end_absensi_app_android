<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Absen extends REST_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model('Absen_model');
        //$this->load->model('Absen_model');
    }

    public function shift_get(){
       
            $shift = $this->Absen_model->getShift();

            if($shift){
            $this->response([
                'status' => true,
                'message' => 'data ref parameter shift',
                'data' => $shift
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'data not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

   

    public function absenn_get(){
        
        $absen = $this->Absen_model->getAbsen();

        if($absen){
        $this->response([
            'status' => true,
            'message' => 'data absen',
            'data' => $absen
        ], REST_Controller::HTTP_OK);
    } else {
        $this->response([
            'status' => false,
            'message' => 'data not found'
        ], REST_Controller::HTTP_NOT_FOUND);
    }
    }


    public function absenn_post(){

        $foto= $this->uploadImage();
        $data= [
            'sales_code' => $this->post('sales_code'),
            'name' => $this->post('name'),
            'unit' => $this->post('unit'),
            'branch' => $this->post('branch'),
            'position' => $this->post('position'),
            'foto' => $foto,
            'created_date_foto' => $this->post('created_date_foto'),
            'kategori' => $this->post('kategori'),
            'geo_info' => $this->post('geo_info'),
            'shift_name' => $this->post('shift_name'),
            'longshift_status' => $this->post('longshift_status'),
            'approved_status' => $this->post('approved_status'),
            'approved_by' => $this->post('approved_by'),
            'approved_date' => $this->post('approved_date'),
            'created_date' => $this->post('created_date'),
            'keterangan' => $this->post('keterangan')
        ];

        if($this->Absen_model->createAbsen($data)> 0){
            $this->response([
                'status' => true,
                'message' => 'absent successfully',
                'data' => $data
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => ' absent failed'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }
    }


    public function uploadImage()
    {
      $config['upload_path'] = './uploads/';
      $config['allowed_types'] = 'gif|jpg|png';
      $config['overwrite'] = true;
      $config['max_size'] = 1024;

      $this->load->library('upload');
      $this->upload->initialize($config);

      if ( ! $this->upload->do_upload('foto'))
      {
        $error = array('error' => $this->upload->display_errors());
         print_r($error);
      //  $this->load->view('upload_form', $error);
      }
      else
      {
        return $this->upload->data("file_name");
      }
    }

    private function _deleteImage($id)
    {
       
        $mahasiswa = $this->Absen_model->getMahasiswa($id);
        if ($mahasiswa['foto'] != "") {
            $filename = explode(".", $mahasiswa['foto'])[0];
            return array_map('unlink', glob(FCPATH."/uploads/$filename.*"));
        }
    }  
    
}