<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Department_model extends CI_Model
{

	public function create_department()
	{
		$data = array(
			'name' => $this->input->post('name'),
			'creator_id' => $this->session->userdata('user_id')
		);
		return $this->db->insert('departments', $data);
	}

	public function get_departments_names($current_department = NULL)
	{
		$this->db->select('id, name');
		$this->db->from('departments');
		$this->db->where_not_in('id', 1);
		$this->db->where_not_in('name', $current_department);
		$this->db->order_by('name');

		$result = $query = $this->db->get()->result_array();

		return $result;
	}

	public function get_my_courses($user_id)
	{
		$this->db->select('id, name');
		$this->db->from('departments');
		if ($_SESSION['role'] == 'Преподавател') {
			$this->db->where('creator_id', $user_id);
		}
		$this->db->where_not_in('id', 1);
		$this->db->order_by('name');

		$result = $query = $this->db->get()->result_array();

		return $result;
	}

	public function department_name($id)
	{
		$this->db->select('name');
		$this->db->from('departments');
		$this->db->where('id', $id);
		return $query = $this->db->get()->result_array();
	}

	public function delete_department($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('departments');
		return true;
	}

	public function get_id_by_name($default_name)
	{
		$this->db->select('id');
		$this->db->from('departments');
		$this->db->where('name', $default_name);
		$result = $query = $this->db->get()->result_array();

		return $result;
	}

	public function get_course_creator_id($course_id)
	{
		$this->db->select('creator_id');
		$this->db->from('departments');
		$this->db->where('id', $course_id);

		$result = $query = $this->db->get()->row_array()['creator_id'];

		return $result;
	}

	public function send_join_request($user_id, $course_id, $creator_id)
	{
		$data = array(
			'student_id' => $user_id,
			'course_id' => $course_id,
			'creator_id' => $creator_id,
			'approved' => 0,
			'date_of_request' => date('Y-m-d')
		);

		$this->db->insert('course_requests', $data);
	}

	public function get_requests_for_approval($user_id)
	{
		$this->db->select('d.name AS course_name, u.name AS student_name');
		$this->db->from('course_requests AS c');
		$this->db->join('departments AS d', 'd.id = c.course_id', 'left');
		$this->db->join('users AS u', 'u.id = c.student_id', 'left');
		$this->db->where('c.creator_id', $user_id);
		$this->db->where('c.approved', 0);

		$query = $this->db->get()->result_array();

		return $query;

	}

	public function get_all_requests_for_approval()
	{
		$this->db->select('d.name AS course_name, u.name AS student_name');
		$this->db->from('course_requests AS c');
		$this->db->join('departments AS d', 'd.id = c.course_id', 'left');
		$this->db->join('users AS u', 'u.id = c.student_id', 'left');
		$this->db->where('c.approved', 0);

		$query = $this->db->get()->result_array();

		return $query;

	}

}
