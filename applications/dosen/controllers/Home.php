<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 */
class Home extends Dosen_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->smarty->display();
	}
}
