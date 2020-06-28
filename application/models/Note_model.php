<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Note_model extends CI_Model
{
	public function add_note($data)
	{
		$this->db->insert("notes", $data);
	}

	public function get_notes()
	{
		$this->db->select();
		$this->db->from('notes');
		$this->db->where('user_id', $_SESSION['user_id']);


		$query = $this->db->get()->result_array();

		return $query;
	}

	public function get_user_notes($id)
	{
		$this->db->select('id, start, duration_time, location, description');
		$this->db->from('notes');
		$this->db->where('user_id', $_SESSION['user_id']);
		$this->db->order_by('id', 'desc');

		$query = $this->db->get()->result_array();

		return $query;
	}
}
