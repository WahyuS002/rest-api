<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mahasiswa_model', 'mahasiswa');

        $this->methods['index_get']['limit'] = 2;
    }

    public function index_get()
    {

        $id = $this->get('id');

        if ($id === null) {
            $data = $this->mahasiswa->getMahasiswa();
        } else {
            $data = $this->mahasiswa->getMahasiswa($id);
        }

        if ($data) {
            $this->response([
                'status' => true,
                'data' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'ID not Found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');

        if ($id === null) {
            $this->response([
                'status' => FALSE,
                'message' => 'Please Provide an ID'
            ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
        } else {
            if ($this->mahasiswa->deleteMahasiswa($id) > 0) {
                // ok
                $this->response([
                    'id' => $id,
                    'message' => 'Deleted the resource'
                ], REST_Controller::HTTP_OK);
            } else {
                // id no found
                $this->response([
                    'status' => false,
                    'message' => 'ID not Found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'nrp' => $this->post('nrp'),
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'jurusan' => $this->post('jurusan')
        ];

        if ($this->mahasiswa->createMahasiswa($data) > 0) {
            $this->response([
                'status' => true,
                'data' => $data,
                'message' => 'Created new Data'
            ], REST_Controller::HTTP_CREATED);
        } else {
            // id no found
            $this->response([
                'status' => false,
                'message' => 'ID not Found'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id = $this->put('id');

        $data = [
            'nrp' => $this->put('nrp'),
            'nama' => $this->put('nama'),
            'email' => $this->put('email'),
            'jurusan' => $this->put('jurusan')
        ];

        if ($this->mahasiswa->editMahasiswa($data, $id) > 0) {
            $this->response([
                'status' => false,
                'message' => 'Data has been edited'
            ], REST_Controller::HTTP_NO_CONTENT);
        } else {
            // id no found
            $this->response([
                'status' => false,
                'message' => 'ID not Found'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
