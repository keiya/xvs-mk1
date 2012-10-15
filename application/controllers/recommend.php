<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recommend extends CI_Controller {

	public function save_history() {
		$this->load->model('User_model');
		$this->load->library('session');
		$vid = preg_replace("/[^0-9]+/", "", $this->input->post('video_id'));
		$duration = preg_replace("/[^0-9\.]+/", "", $this->input->post('duration'));
		if ($uid = $this->session->userdata('userid')) {
			if ($this->User_model->check_user($uid) == 0) {
				$uid = $this->_create_user();
				$this->_create_history($uid,$vid,$duration);
			}
			else {
				$this->_create_history($uid,$vid,$duration);
			}
		}
		else {
			$uid = $this->_create_user();
			$this->_create_history($uid,$vid,$duration);
		}
	}

	private function _create_user() {
		if ($uid = $this->User_model->create_user()) {
			$this->session->set_userdata(array('userid'=>$uid));
			return $uid;
		}
	}

	private function _create_history($uid,$vid=null,$duration=0) {
		if ($vid || $duration > 30) {
			$this->User_model->create_history($uid,$vid,$duration);
		}
	}

}

