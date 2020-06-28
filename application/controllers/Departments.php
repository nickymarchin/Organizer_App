<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Departments extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Test_model');
		$this->load->model('Department_model');
	}

	public function index()
	{
		//check login
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}

		$data['title'] = 'Курсове';

		$data['categories'] = $this->Department_model->get_departments_names();

		$this->load->view('templates/header');
		$this->load->view('department/departments_list', $data);
		$this->load->view('templates/footer');
	}

	public function student_courses_to_join()
	{
		//check login
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}

		$data['title'] = 'Курсове';

		$data['categories'] = $this->Department_model->get_departments_names();

		$this->load->view('templates/header');
		$this->load->view('department/student_courses_list', $data);
		$this->load->view('templates/footer');
	}

	public function get_my_courses($user_id)
	{
		//check login
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}

		$data['title'] = 'Курсове';

		$data['categories'] = $this->Department_model->get_my_courses($user_id);

		$this->load->view('templates/header');
		$this->load->view('department/departments_list', $data);
		$this->load->view('templates/footer');
	}

	public function create()
	{
		//check login
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}

		$data['title'] = 'Създай нов курс';

		$this->form_validation->set_rules('name', 'Name', 'required');

		if ($this->form_validation->run() === FALSE) {

			$this->load->view('templates/header');
			$this->load->view('department/create', $data);
			$this->load->view('templates/footer');

		} else {

			$this->Department_model->create_department();
			if ($_SESSION['role'] == 'Администратор'){
				redirect('departments');
			} else {
				redirect('departments/get_my_courses/' . $this->session->userdata('user_id'));
			}

		}
	}

	public function delete($id)
	{

		//check login
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}

		$default_id = $this->Department_model->get_id_by_name('<--- Без зададен курс --->');

		$this->Test_model->set_default_department($default_id[0]['id'], $id);

		$this->Department_model->delete_department($id);


		$this->session->set_flashdata('deleteSuccess', 'Department deleted successfully');

		if ($_SESSION['role'] == 'Администратор'){
			redirect('departments');
		} else {
			redirect('departments/get_my_courses/' . $this->session->userdata('user_id'));
		}

	}

	public function send_join_request($course_id)
	{
		//check login
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}

		$student_id = $_SESSION['user_id'];

		$creator_id = $this->Department_model->get_course_creator_id($course_id);

		//save request to database
		$this->Department_model->send_join_request($_SESSION['user_id'], $course_id, $creator_id);

		redirect('departments/student_courses_to_join');
	}

	public function get_requests_for_approval()
	{
		//check login
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}

		$data['title'] = 'Заявки на студенти';

		$requests_for_approval = array_unique($this->Department_model->get_requests_for_approval($_SESSION['user_id']), SORT_REGULAR);

		$data['requests'] = $requests_for_approval;

		$this->load->view('templates/header');
		$this->load->view('department/requests_list', $data);
		$this->load->view('templates/footer');

	}

	public function get_all_requests_for_approval()
	{
		//check login
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}

		$data['title'] = 'Заявки на студенти';

		$requests_for_approval = array_unique($this->Department_model->get_all_requests_for_approval(), SORT_REGULAR);

		$data['requests'] = $requests_for_approval;

		$this->load->view('templates/header');
		$this->load->view('department/requests_list', $data);
		$this->load->view('templates/footer');
	}

//    public function get_department_members($id)
//    {
//        //check login
//        if (!$this->session->userdata('logged_in')) {
//            redirect('users/login');
//        }
//
//        $department_members = $this->Test_model->users_by_department_list($id);
//
//        if ($department_members != null) {
//
//            $data['usersList'] = $department_members;
//
//            $data['id'] = $id;
//
//            $department_name = $this->Department_model->department_name($id);
//
//            $data['department_name'] = $department_name[0]['name'];
//
//            $this->session->set_flashdata('department', 'Data from department: ' . $department_name[0]['name']);
//
//            $this->load->view('templates/header');
//            $this->load->view('spreadsheet/all_users', $data);
//            $this->load->view('templates/footer');
//
//        } else {
//            //if database is empty redirect to import page
//            redirect('test/create');
//        }
//    }
}
