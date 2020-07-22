<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Fathoni <m.fathoni@mail.com>
 */
class Site extends Frontend_Controller
{
	public function index()
	{
		if ($this->session->userdata('user') !== NULL)
		{
			if ($this->session->userdata('user')->tipe_user == TIPE_USER_ADMIN)
			{
				redirect(GLOBAL_BASE_URL . '/admin/');
			}
			else if ($this->session->userdata('user')->tipe_user == TIPE_USER_REVIEWER)
			{
				redirect(GLOBAL_BASE_URL . '/reviewer/');
			}
			else if ($this->session->userdata('user')->tipe_user == TIPE_USER_MAHASISWA)
			{
				redirect(GLOBAL_BASE_URL . '/mahasiswa/');
			}
			else
			{
				redirect('home');
			}
		}
		
		$this->smarty->display();
	}
	
	public function download()
	{
		$download_set = $this->db->order_by('created_at', 'DESC')->get('download')->result();
		
		$this->smarty->assign('download_set', $download_set);
		$this->smarty->display();
	}
	
	public function alur_kbmi_2019()
	{
		$this->smarty->display();
	}
	
	public function test_send_mail()
	{
		$this->load->library('email');  // configuration file : applications/user/config/email.php
		
		$this->email->from('no-reply@kibm.kemdikbud.go.id', 'KIBM');
		$this->email->to('m.fathoni@mail.com');
		$this->email->cc('mokhammad.fathoni.rokhman@gmail.com');

		$this->email->subject('Email test yang dikirim pada '. date('H:i:s d/m/Y'));
		
		//$this->smarty->assign('nama', "Yufi Yes");
		//$this->smarty->assign('email', "yufiazmi@gmail.com");
		//$this->smarty->assign('password', "IndonesiaMerdeka1945");
		
		$body = $this->smarty->fetch("email/registration.tpl");
		$this->email->message($body);
			
		$result = $this->email->send();
		
		if ($result)
			echo "Pengiriman berhasil";
		else
			echo "Pengiriman (koyoke) gagal";
	}
}
