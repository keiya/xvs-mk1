<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function index() {
		$this->load->view('admin',array());
	}

	public function login() {
		if (hash('sha256',$this->input->post('password')) == '7362efaf18e2c810bc9a8cac4255822f0624468d9ddced9f23b5ce2b6081642f') {
			$this->session->set_userdata('is_admin',true);
			header('Location:/');
		}
		else {
			echo 'Auth Failed';
		}
	}

	public function cache() {
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		if ($this->session->userdata('is_admin')) {
			$this->load->library('cacheman');
			$this->cacheman->show_entry();
		}
	}

}

