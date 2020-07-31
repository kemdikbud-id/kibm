<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_Email $email
 */
class Home extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
	}
	
	public function index()
	{
		$this->smarty->display();
	}
	
	public function test_email()
	{
		$this->load->library('email');
		
		$this->email->from($this->config->item('smtp_user'), 'KIBM');
		$this->email->to('mokhammad.fathoni.rokhman@gmail.com');
		$this->email->cc('m.fathoni@mail.com');
		$this->email->subject('Jajal Email');
		$this->email->message('Ini adalah email jajal body');
		
		if ($this->email->send(FALSE))
		{
			echo "Berhasil";
		}
		else
		{
			show_error($this->email->print_debugger());
		}
	}
}
