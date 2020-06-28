<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


class User_model extends CI_Model
{
	public function register($enc_password)
	{
		//User data array
		$data = array(
			'name' => $this->input->post('name'),
			'email' => $this->input->post('email'),
			'username' => $this->input->post('username'),
			'password' => $enc_password,
			'role_id' => $this->input->post('role_id')
		);

		//insert
		return $this->db->insert('users', $data);
	}

	public function login($username, $password)
	{
		//validate
		$this->db->where('username', $username);
		$this->db->where('password', $password);

		$result = $this->db->get('users');

		if ($result->num_rows() == 1) {
			return $result->row(0)->id;
		} else {
			return false;
		}
	}

	public function check_username_exists($username)
	{
		$query = $this->db->get_where('users', array('username' => $username));

		if ($query->row_array() === NULL) {
			return true;
		} else {
			return false;
		}
	}

	public function check_email_exists($email)
	{
		$query = $this->db->get_where('users', array('email' => $email));

		if ($query->row_array() === NULL) {
			return true;
		} else {
			return false;
		}
	}

	public function get_all_roles()
	{
		$this->db->select('id, role_name');
		$this->db->from('roles');

		$result = $query = $this->db->get()->result_array();

		return $result;
	}

	public function get_user_role_name($user_id)
	{

		$this->db->select('r.role_name');
		$this->db->from('roles AS r');
		$this->db->join('users AS u', 'r.id = u.role_id');
		$this->db->where('u.id', $user_id);

		return $query = $this->db->get()->row_array()['role_name'];
	}
}
