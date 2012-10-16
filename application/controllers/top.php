<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Top extends CI_Controller {

	public function index() {
		$this->load->model('Top_model');
		$this->load->library('user_agent');
		/*
		if ($this->agent->accept_lang('de')) {
			$region = array('german','germany');
		}
		else if ($this->agent->accept_lang('ja')) {
		*/
			$region = array('japanese','japan');
		/*
		}
		else if ($this->agent->accept_lang('ru')) {
			$region = array('russian','russia');
		}
		else if ($this->agent->accept_lang('pt')) {
			$region = array('brasil','brasileira');
		}
		else if ($this->agent->accept_lang('bn')) {
			$region = array('indian','india');
		}
		else if ($this->agent->accept_lang('ar')) {
			$region = array('arabian','arabic');
		}
		else if ($this->agent->accept_lang('es')) {
			$region = array('spanish','hispanic');
		}
		else if ($this->agent->accept_lang('hi')) {
			$region = array('indian');
		}
		else if ($this->agent->accept_lang('en')) {
			$region = array('american','america');
		}
		else if ($this->agent->accept_lang('zh')) {
			$region = array('chinese','china');
		}
		*/
		$datas = array();
		$datas['new'] = $this->Top_model->get_new_videos($region);
		$datas['high'] = $this->Top_model->get_highly_rated();
		$this->load->view('layout',array(
			'body'=>
				$this->load->view('top',array(
					'datas'=>$datas,
				),TRUE)
		));
	}

}
