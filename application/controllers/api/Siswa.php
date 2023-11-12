<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';

class Siswa extends REST_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Siswa_model');

		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");

		if ( "OPTIONS" === $_SERVER['REQUEST_METHOD'] ) {
			die();
		}
	}

	public function index_get() {
		$id = $this->get('id');
		if( $id === null ) {
			$siswa = $this->Siswa_model->getSiswa();
		}
		else {
			$siswa = $this->Siswa_model->getSiswa($id);
		}
		
		if ($siswa)
		{
			// Set the response and exit
			$this->response($siswa, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		}
		else
		{
			// Set the response and exit
			$this->response([
				'status' => FALSE,
				'error' => 'No users were found'
			], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
		}   
	}

	public function index_delete()
    {
        $id = (int) $this->delete('id');

        // Validate the id.
        if ($id <= 0)
        {
            // Set the response and exit
            $this->response([
				'status'=> FALSE,
				'message' => 'Provide an id'
			], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        } else {
			if($this->Siswa_model->deleteSiswa( $id ) > 0){
				$message = [
					'status' => true,
					'id' => $id,
					'message' => 'Deleted the resource'
				];
				$this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
			} else {
				$this->response([
					'status'=> FALSE,
					'message' => 'id not found',
				], REST_Controller::HTTP_BAD_REQUEST);
			}

		}

        // $this->some_model->delete_something($id);
		
    }

	public function index_post()
    {
        // $this->some_model->update_user( ... );
        $data = [
            'name' => $this->post('name'),
			'last_name' => $this->post('last_name'),
			'phone' => $this->post('phone'),
            'email' => $this->post('email'),
			'address' => $this->post('address')
        ];

		if($this->Siswa_model->postSiswa($data) > 0){
			$this->set_response([
				'status' => true,
				'message' => 'New siswa has been created'
			], REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
		}

		else {
			$this->response([
				'status' => FALSE,
				'error' => 'No users were found'
			], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
		}

    }

	public function index_put(){
		$id = (int) $this->put('id');

		$data = [
            'name' => $this->post('name'),
			'last_name' => $this->post('last_name'),
			'phone' => $this->post('phone'),
            'email' => $this->post('email'),
			'address' => $this->post('address')
        ];

		if($this->Siswa_model->putSiswa($data, $id) > 0){
			$this->set_response([
				'status' => true,
				'message' => 'siswa has been updated'
			], REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
		}
		else {
			$this->response([
				'status' => FALSE,
				'error' => 'Siswa failed to update'
			], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
		}
	}
}
