<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Test_model extends CI_Model
{

	private $_batchImport;

	public function setBatchImport($batchImport)
	{
		$this->_batchImport = $batchImport;
	}

	//save data
	public function importData()
	{
		$data = $this->_batchImport;
		$this->db->insert_batch('import', $data);
	}

	//get users list
	public function usersList()
	{
		$this->db->select(array('e.id', 'e.first_name', 'e.last_name', 'e.email', 'd.name', 'e.group', 'e.fac_no'));
		$this->db->from('import as e');
		$this->db->join('departments as d', 'd.id = e.department_id');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_students_for_creator($creator_id)
	{
		$this->db->select(array('e.id', 'e.first_name', 'e.last_name', 'e.email', 'd.name', 'e.group', 'e.fac_no'));
		$this->db->from('import as e');
		$this->db->join('departments as d', 'd.id = e.department_id');
		$this->db->where('d.creator_id', $creator_id);

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_students_from_group($group){
		$this->db->select(array('e.id', 'e.first_name', 'e.last_name', 'e.email', 'd.name', 'e.group', 'e.fac_no'));
		$this->db->from('import as e');
		$this->db->join('departments as d', 'd.id = e.department_id');
		$this->db->where('d.creator_id', $_SESSION['user_id']);
		$this->db->where('e.group', $group);

		$query = $this->db->get();
		return $query->result_array();
	}

	public function getAllEmails()
	{
		$this->db->select(array('i.email'));
		$this->db->from('import as i');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_all_emails($department_id)
	{
		$this->db->select('email');
		$this->db->from('import');
		$this->db->where('department_id', $department_id);
		$result = $query = $this->db->get()->result_array();

		return $result;
	}

	public function getUserInfo($user_id)
	{
		$this->db->select();
		$this->db->from('import');
		$this->db->where('id', $user_id);
		return $query = $this->db->get()->result_array();
	}

	public function getUserEmail($user_id)
	{
		$this->db->select('email');
		$this->db->from('import');
		$this->db->where('id', $user_id);
		$result = $query = $this->db->get()->result_array();

		return $result;
	}

	//delete user from list
	public function delete_import($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('import');
		return true;
	}

	//update a user after edit
	public function update_import()
	{

		$id = $this->input->post('id');

		$data = array(
			'first_name' => html_escape($this->input->post('first_name')),
			'last_name' => html_escape($this->input->post('last_name')),
			'email' => html_escape($this->input->post('email')),
			'department_id' => html_escape($this->input->post('department_id')),
			'fac_no' => html_escape($this->input->post('fac_no')),
			'group' => html_escape($this->input->post('group'))
		);

		$this->db->where('id', $id);
		return $this->db->update('import', $data);
	}

	public function users_by_department_list($id)
	{
		$this->db->select(array('e.id', 'e.first_name', 'e.last_name', 'e.email', 'd.name', 'e.group', 'e.fac_no'));
		$this->db->from('import as e');
		$this->db->join('departments as d', 'd.id = e.department_id');
		$this->db->where('d.id', $id);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function set_default_department($default_id, $id)
	{
		$this->db->set('department_id', $default_id);
		$this->db->where('department_id', $id);
		$this->db->update('import');

	}

	public function get_student_name($id)
	{
		$this->db->select('name');
		$this->db->from('users');
		$this->db->where('id', $id);
		$result = $query = $this->db->get()->row_array()['name'];

		return $result;
	}

}
