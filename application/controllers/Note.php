<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Note extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Test_model');
		$this->load->model('Note_model');
		$this->load->model('Department_model');
	}

	public function index()
	{
		//check login
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}

		$data['title'] = 'Календар с бележки';

		$data['notes'] = $this->Note_model->get_user_notes($_SESSION['user_id']);

		$this->load->view('templates/header');
		$this->load->view('notes/notes', $data);
		$this->load->view('templates/footer');
	}

	public function add_note()
	{
		$note_description = $this->input->post('note_description', TRUE);
		$note_duration = $this->input->post('duration', TRUE);
		$note_location = $this->input->post('note_location', TRUE);

		$note_data = array(
			"date_of_request" => date('Y-m-d'),
			"start" => $this->format_date($this->input->post("start_time", TRUE)),
			"end" => $this->format_date($this->input->post("end_time", TRUE)),
			"location" => $note_location,
			"user_id" => $_SESSION['user_id'],
			"username" => $_SESSION['username'],
			"description" => $note_description,
			"duration_time" => $note_duration,
		);

		if (!empty($note_data)) {
			$this->Note_model->add_note($note_data);
		}

		redirect('note');

	}

	public function delete_note()
	{
		$id = $this->input->post('id');

		$this->db->where("id", $id)->delete('notes');

		$response['redirect'] = true;

		echo json_encode($response);
	}

	public function get_notes()
	{
		$result = $this->Note_model->get_notes();

		if (!empty($result)) {

			for ($i = 0; $i < count($result); $i++) {

				$result[$i]['color'] = '#17a2b8';

			}

			echo json_encode($result);

		} else {
			echo "Query is empty";
		}
	}

	function format_date($date)
	{
		$parts = explode(' ', $date);
		$result = $parts[0];
		$format_date = str_replace('.', '-', date('Y-m-d', strtotime($result)));
		return $format_date .= ' ' . $parts[1];
	}
}

