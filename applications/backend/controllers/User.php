<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property RequestUser_model $request_user_model
 * @property User_model $user_model
 * @property PerguruanTinggi_model $pt_model 
 * @property Program_model $program_model
 * @property RejectMessage_model $reject_message_model
 */
class User extends Backend_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
		
		$this->load->model(MODEL_REQUEST_USER, 'request_user_model');
		$this->load->model(MODEL_USER, 'user_model');
		$this->load->model(MODEL_PERGURUAN_TINGGI, 'pt_model');
		$this->load->model(MODEL_PROGRAM, 'program_model');
		$this->load->model(MODEL_REJECT_MESSAGE, 'reject_message_model');
	}
	
	public function index()
	{
		$data_set = $this->user_model->list_user();
		
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
	
	public function update($id)
	{		
		$this->smarty->display();
	}
	
	public function request()
	{
		$this->load->helper('time_elapsed');
		
		$data_set = $this->request_user_model->list_request();
		
		foreach ($data_set as &$data)
		{
			// get elapsed time
			$data->waktu = time_elapsed_string($data->created_at);
		}
		
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
	
	public function request_approve()
	{
		$id = (int)$this->input->get('id');
		
		$this->load->helper('random_password');
		
		$data = $this->request_user_model->get_single($id);
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			// start transaction
			$this->db->trans_start();
			
			// get variabel
			$pt			= $this->pt_model->get_single($this->input->post('perguruan_tinggi_id'));
			$program	= $this->program_model->get_single($data->program_id);
			
			$user = new User_model();
			$user->tipe_user			= TIPE_USER_NORMAL;
			$user->program_id			= $data->program_id;
			$user->perguruan_tinggi_id	= $pt->id;
			$user->email				= $data->email;
			
			// create user from perguruan tinggi
			if ($data->program_id == PROGRAM_PBBT)
				$user->username = trim($pt->npsn) . '01';
			if ($data->program_id == PROGRAM_KBMI)
				$user->username = trim($pt->npsn) . '02';
			
			// generate password
			$password = get_random_password(8, 8, FALSE, TRUE, FALSE);
			// hash password
			$user->password_hash = sha1($password);
			
			$user->created_at = date('Y-m-d H:i:s');
			
			$result = $this->user_model->create_user($user);
			
			// approve
			if ($result) $this->request_user_model->approve($id);
			
			// commit if success
			$this->db->trans_commit();
			
			// Assign variable
			$this->smarty->assign('nama', $data->nama_pengusul);
			$this->smarty->assign('nama_program', $program->nama_program);
			$this->smarty->assign('login_link', 'http://sim-pkmi.ristekdikti.go.id');
			$this->smarty->assign('username', $user->username);
			$this->smarty->assign('password', $password);
			$body = $this->smarty->fetch("email/request_user_approve.tpl");
			
			// Kirim Email
			$this->load->library('email');
			$this->email->from('no-reply@sim-pkmi.ristekdikti.go.id', 'Notifikasi SIM-PKMI');
			$this->email->to($data->email);
			$this->email->subject('Informasi Akun SIM-PKMI');
			$this->email->message($body);
			$result = $this->email->send();
			
			$this->session->set_flashdata('result', array(
				'page_title' => 'Daftar User Request',
				'message' => 'Berhasil',
				'link_1' => '<a href="'.site_url('user/request').'">Kembali ke daftar user request</a>'
			));
			
			redirect(site_url('alert/success'));
		}
		
		$this->smarty->assign('pt_set', $this->pt_model->list_by_name($data->perguruan_tinggi));
		$this->smarty->assign('program', $this->program_model->get_single($data->program_id));
		
		$this->smarty->assign('data', $data);
		$this->smarty->display();
	}
	
	public function request_reject()
	{
		$id = (int)$this->input->get('id');
		
		$data = $this->request_user_model->get_single($id);
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$reject_message_id	= $this->input->post('reject_message_id');
			$reject_message		= $this->input->post('reject_message');
			
			if ($reject_message_id != '-1')
				$reject_message = $this->reject_message_model->get_single($reject_message_id)->message;
			
			$this->request_user_model->reject($id, $reject_message);
			
			// Kirim email
			$this->load->library('email');  // configuration file : applications/user/config/email.php
		
			$this->email->from('no-reply@sim-pkmi.ristekdikti.go.id', 'Notifikasi SIM-PKMI');
			$this->email->to($data->email);
			$this->email->subject('Registrasi User SIM PKMI Tidak Disetujui '. date('H:i:s d/m/Y'));

			$this->smarty->assign('message', $reject_message);

			$body = $this->smarty->fetch("email/request_user_reject.tpl");
			$this->email->message($body);

			$result = $this->email->send();
			
			$this->session->set_flashdata('result', array(
				'page_title' => 'Daftar User Request',
				'message' => 'Berhasil',
				'link_1' => '<a href="'.site_url('user/request').'">Kembali ke daftar user request</a>'
			));
			
			redirect(site_url('alert/success'));
		}
		
		$this->smarty->assign('reject_message_set', $this->reject_message_model->list_all());
		
		$this->smarty->assign('data', $data);
		$this->smarty->display();
	}
}
