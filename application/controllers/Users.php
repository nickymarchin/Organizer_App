<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		//load model
		$this->load->model('User_model');
		$this->load->model('Email_model');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('Sha3');
	}

	//load registration page + submission
	public function register()
	{
		$data['title'] = 'Регистрация';

		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required|callback_check_username_exists');
		$this->form_validation->set_rules('email', 'Email', 'required|callback_check_email_exists');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('password2', 'Confirm Password', 'matches[password]');

		if ($this->form_validation->run() === FALSE) {

			$data['roles'] = $this->User_model->get_all_roles();

			$this->load->view('templates/header');
			$this->load->view('users/register', $data);
			$this->load->view('templates/footer');

		} else {

			//encrypt password before saving to the db
			//$enc_password = md5($this->input->post('password'));

			$input_password = $this->input->post('password');
			$enc_password = Sha3::hash($input_password, 224);

			$this->User_model->register($enc_password);

			$this->session->set_flashdata('user_registered', 'Успешна регистрация!');

			//or login?
			redirect('users/login');
		}
	}

	//log in user
	public function login()
	{
		//check login
		if ($this->session->userdata('logged_in')) {
			redirect('test/getUsersList');
		}

		$data['title'] = 'Вход';

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() === FALSE) {

			$this->load->view('templates/header');
			$this->load->view('users/login', $data);
			$this->load->view('templates/footer');

		} else {

			//get username
			$username = $this->input->post('username');

			//get and encrypt the password
			//$password = md5($this->input->post('password'));

			$input_password = $this->input->post('password');
			$password = Sha3::hash($input_password, 224);

			//user id or false if not correct
			$user_id = $this->User_model->login($username, $password);

			if ($user_id) {

				$user_role_name = $this->User_model->get_user_role_name($user_id);

				//create user session
				$user_data = array(
					'user_id' => $user_id,
					'username' => $username,
					'role' => $user_role_name,
					'logged_in' => true
				);

				$this->session->set_userdata($user_data);

				$this->session->set_flashdata('user_loggedin', 'Успешен вход в системата!');

				if ($user_role_name == 'Администратор') {
					redirect('test/getUsersList', $data);
				} else if ($user_role_name == 'Преподавател') {
					redirect('test/get_students_by_creator_id/' . $user_id, $data);
				} else {
					redirect('note');
				}

			} else {

				$this->session->set_flashdata('login_failed', 'Грешно потребителско име или парола!');

				redirect('users/login', $data);
			}
		}
	}

	public function logout()
	{
		//unset user data
		$this->session->unset_userdata('logged_in');
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('username');

		$this->session->set_flashdata('user_loggedout', 'Успешен изход!');

		redirect('users/login');

	}

	//callback for form validation
	public function check_username_exists($username)
	{
		$this->form_validation->set_message('check_username_exists',
			'Потребителското име е заето!');

		if ($this->User_model->check_username_exists($username)) {
			return true;
		} else {
			return false;
		}
	}

	//callback for form validation
	public function check_email_exists($email)
	{
		$this->form_validation->set_message('check_email_exists',
			'Потребител с този имейл вече съществува!');

		if ($this->User_model->check_email_exists($email)) {
			return true;
		} else {
			return false;
		}
	}

	public function emails_sent($offset = 0)
	{
		//check login
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}

		$data['title'] = 'Имейли изпратени от мое име';

		$id = $this->session->userdata('user_id');

		$rows = $this->Email_model->rows_count($this->session->userdata('user_id'));

		// ci pagination  config
		$config['base_url'] = 'http://localhost:83/users/emails_sent';
		$config['total_rows'] = $rows;
		$config['per_page'] = 4;
		$config['uri_segment'] = 3;
		$config['attributes'] = array('class' => 'pagination-links');

		// init pagination
		$this->pagination->initialize($config);

		$data['emailsList'] = $this->Email_model->emails_sent($id, $config['per_page'], $offset);

		$this->load->view('templates/header');
		$this->load->view('users/sent_emails', $data);
		$this->load->view('templates/footer');

	}
}
