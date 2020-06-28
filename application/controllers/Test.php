<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer;

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Test extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		//load model
		$this->load->model('Test_model');
		$this->load->model('Department_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		//check login
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}

		$data = array();
		$data['breadcrumbs'] = array('Home' => '#');

		$data['departments'] = $this->Department_model->get_my_courses($_SESSION['user_id']);

		$this->load->view('templates/header');
		$this->load->view('spreadsheet/index', $data);
		$this->load->view('templates/footer');
	}

	public function upload()
	{

		$course_id = $this->input->post('department_id',TRUE);

		//check login
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}

		require_once 'assets/vendor/PHPSpreadsheet/vendor/autoload.php';

		$data = array();
		$data['title'] = 'Import Excel Sheet';
		$data['breadcrumbs'] = array('Home' => '#');

		$this->form_validation->set_rules('fileURL', 'Upload File', 'callback_checkFileValidation');

		if ($this->form_validation->run() == false) {

			$this->load->view('templates/header');
			$this->load->view('spreadsheet/index', $data);
			$this->load->view('templates/footer');

		} else {
			//if file is uploaded
			if (!empty($_FILES['fileURL']['name'])) {
				//get file extension
				$extension = pathinfo($_FILES['fileURL']['name'], PATHINFO_EXTENSION);

				if ($extension == 'csv') {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} elseif ($extension == 'xlsx') {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
				}

				//file path
				$spreadsheet = $reader->load($_FILES['fileURL']['tmp_name']);
				$allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
				$SheetDataKey = array();
				//array count
				$arrayCount = count($allDataInSheet);
				$flag = 0;
				$createArray = array('First_Name', 'Last_Name', 'Email', 'Group', 'Fac_No');
				$makeArray = array('First_Name' => 'First_Name', 'Last_Name' => 'Last_Name', 'Email' => 'Email', 'Group' => 'Group', 'Fac_No' => 'Fac_No');

				foreach ($allDataInSheet as $dataInSheet) {
					foreach ($dataInSheet as $key => $value) {
						if (in_array(trim($value), $createArray)) {
							$value = preg_replace('/\s+/', '', $value);
							$SheetDataKey[trim($value)] = $key;
						}
					}
				}

				$dataDiff = array_diff_key($makeArray, $SheetDataKey);

				if (empty($dataDiff)) {
					$flag = 1;
				}

				//match excel sheet column
				if ($flag == 1) {
					for ($i = 2; $i <= $arrayCount; $i++) {

						$firstName = $SheetDataKey['First_Name'];
						$lastName = $SheetDataKey['Last_Name'];
						$email = $SheetDataKey['Email'];
						$group = $SheetDataKey['Group'];
						$facNo = $SheetDataKey['Fac_No'];

						$firstName = filter_var(trim($allDataInSheet[$i][$firstName]), FILTER_SANITIZE_STRING);
						$lastName = filter_var(trim($allDataInSheet[$i][$lastName]), FILTER_SANITIZE_STRING);
						$email = filter_var(trim($allDataInSheet[$i][$email]), FILTER_SANITIZE_STRING);
						$group = filter_var(trim($allDataInSheet[$i][$group]), FILTER_SANITIZE_STRING);
						$facNo = filter_var(trim($allDataInSheet[$i][$facNo]), FILTER_SANITIZE_STRING);

						$allEmails = $this->Test_model->getAllEmails();

						if (!$this->in_array_r($email, $allEmails)) {
							$fetchData[] = array('first_name' => $firstName, 'last_name' => $lastName, 'email' => $email, 'group' => $group, 'fac_no' => $facNo, 'department_id' => $course_id);
						}
					}

					if (!$fetchData) {

						$this->session->set_flashdata('invalidImport', 'Users already imported!');

						redirect('test');
					}

					$data['dataInfo'] = $fetchData;

					$this->Test_model->setBatchImport($fetchData);
					$this->Test_model->importData();

					$this->session->set_flashdata('importSuccess', 'Data imported successfully');

					$this->load->view('templates/header');
					$this->load->view('spreadsheet/display', $data);
					$this->load->view('templates/footer');

				} else {
					$data['errorMsg'] = "No match in excel sheet columns. Please import correct file!";

					$this->load->view('templates/header');
					$this->load->view('spreadsheet/index', $data);
					$this->load->view('templates/footer');
				}

			}
		}
	}

	//check validation
	public function checkFileValidation($string)
	{
		if ($_FILES['fileURL']['name'] != "") {
			$arr_file = explode('.', $_FILES['fileURL']['name']);
			$extension = end($arr_file);
			if (($extension == 'xlsx' || $extension == 'xls' || $extension == 'csv')) {
				return true;
			} else {
				$this->form_validation->set_message('checkFileValidation', 'Please choose correct file format!');
				return false;
			}
		} else {
			$this->form_validation->set_message('checkFileValidation', 'Please choose a file!');
			return false;
		}
	}

	public function getUsersList($id = NULL)
	{
		//check login
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}

//		if ($this->session->userdata('role')) {
//			redirect('users/login');
//		}

		if ($id == NULL) {
			$allUsers = $this->Test_model->usersList();
		} else {
			$allUsers = $this->Test_model->users_by_department_list($id);
		}

		if ($allUsers != null) {

			$data['usersList'] = $allUsers;

			if (!isset($data['mailSuccess'])) {
				$data['mailSuccess'] = 'Mail sent successfully';
			}

			$this->load->view('templates/header');
			$this->load->view('spreadsheet/all_users', $data);
			$this->load->view('templates/footer');

		} else {
			//if database is empty redirect to import page
			redirect('test/create');
		}
	}

	public function get_students_by_creator_id($course_creator_id)
	{
		//check login
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}

		$creator_students = $this->Test_model->get_students_for_creator($course_creator_id);

		if ($creator_students != null) {

			$data['usersList'] = $creator_students;

			if (!isset($data['mailSuccess'])) {
				$data['mailSuccess'] = 'Mail sent successfully';
			}

			$this->load->view('templates/header');
			$this->load->view('spreadsheet/all_users', $data);
			$this->load->view('templates/footer');

		} else {
			//if database is empty redirect to import page
			redirect('test/create');
		}
	}

	public function get_courses_student_is_in()
	{
		//check login
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}

		//$student_courses_data = $this->Test_model->get_students_courses_data($_SESSION['user_id']);
		$student_courses_data = array( 'example' => 5 );

		if ($student_courses_data != null) {

			$data['title'] = 'Колеги и преподаватели';
			$data['usersList'] = $student_courses_data;

			if (!isset($data['mailSuccess'])) {
				$data['mailSuccess'] = 'Mail sent successfully';
			}

			$this->load->view('templates/header');
			$this->load->view('spreadsheet/student_view', $data);
			$this->load->view('templates/footer');

		} else {
			//if database is empty redirect to import page
			redirect('departments/student_courses_to_join');
		}

	}

	public function get_students_by_group($group){

		//check login
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}

		$students_from_group = $this->Test_model->get_students_from_group($group);

		if ($students_from_group != null) {

			$data['usersList'] = $students_from_group;

			if (!isset($data['mailSuccess'])) {
				$data['mailSuccess'] = 'Mail sent successfully';
			}

			$this->load->view('templates/header');
			$this->load->view('spreadsheet/all_users', $data);
			$this->load->view('templates/footer');

		} else {
			//if database is empty redirect to import page
			redirect('test/create');
		}

	}

	//add data import manually
	public function create()
	{
		//check login
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}

		$data['title'] = 'Създаване на студент';

		if ($this->session->userdata('role') == 'Администратор') {
			$data['departments'] = $this->Department_model->get_departments_names();
		} else {
			$data['departments'] = $this->Department_model->get_my_courses($_SESSION['user_id']);
		}

		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('group', 'Group', 'required');
		$this->form_validation->set_rules('fac_no', 'Faculty Number', 'required');

		if ($this->form_validation->run() === FALSE) {

			$this->load->view('templates/header');
			$this->load->view('spreadsheet/create', $data);
			$this->load->view('templates/footer');

		} else {

			$firstName = html_escape($this->input->post('first_name'));
			$lastName = html_escape($this->input->post('last_name'));
			$email = html_escape($this->input->post('email'));
			$department = html_escape($this->input->post('department_id'));
			$group = html_escape($this->input->post('group'));
			$facNo = html_escape($this->input->post('fac_no'));

			$fetchData[] = array('first_name' => $firstName, 'last_name' => $lastName, 'email' => $email, 'department_id' => $department, 'fac_no' => $facNo, 'group' => $group);

			$data['dataInfo'] = $fetchData;

			$this->Test_model->setBatchImport($fetchData);
			$this->Test_model->importData();

			$this->session->set_flashdata('importSuccess', 'Data imported successfully');

			$this->load->view('templates/header');
			$this->load->view('spreadsheet/display', $data);
			$this->load->view('templates/footer');

		}

	}

	//edit page load
	public function edit($id)
	{
		//check login
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}

		$data['title'] = 'Редактиране на студент';

		$data['import'] = $this->Test_model->getUserInfo($id);

		$data['current_department'] = $this->Department_model->department_name($data['import'][0]['department_id']);

		$data['departments'] = $this->Department_model->get_departments_names($data['current_department'][0]['name']);

		if (empty($data['import'])) {
			show_404();
		}

		$this->load->view('templates/header');
		$this->load->view('spreadsheet/edit', $data);
		$this->load->view('templates/footer');

	}

	public function update()
	{
		//check login
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}

		$this->Test_model->update_import();

		$this->session->set_flashdata('updateSuccess', 'Успешно редактиране!');

		redirect('test/getUsersList');

	}

	//delete data import
	public function delete($id)
	{
		//check login
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}

		$data['title'] = 'Изтриване на студент';

		$this->Test_model->delete_import($id);

		$this->session->set_flashdata('deleteSuccess', 'Data deleted successfully');

		if ($_SESSION['role_name'] == 'Администратор') {
			redirect('test/getUsersList');
		} else {
			redirect('test/get_students_by_creator_id/' . $this->session->userdata('user_id'));
		}

	}

	public function get_user_email()
	{
		$user_id = $this->input->post("user_id", TRUE);

		$email = $this->Test_model->getUserEmail($user_id);

		echo json_encode($email);
	}

	//prevent duplicate emails entering db
	public function in_array_r($needle, $haystack, $strict = false)
	{
		foreach ($haystack as $item) {
			if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_array_r($needle, $item, $strict))) {
				return true;
			}
		}

		return false;
	}
}
