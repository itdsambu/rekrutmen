<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class BaseController extends MY_Controller{
	
	protected $defaultredirecturl = 'Welcome/index';
	protected $sessname ='u_user';
	protected $loaddatatable = true;
	
}