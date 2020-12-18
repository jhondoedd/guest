<?php
class Home_model extends CI_Model
{
	function get_hadir()
	{
		$this->db->order_by("guest_name", "asc");
		$query = $this->db->get("m_guest");
		$tmp = $this->db->last_query();
		return $query;
	}
	
	function import_data($data)
	{
// 		$this->db->delete("m_guest");
		$sql = "delete from m_guest";
		$query = $this->db->query($sql);
		$this->db->insert_batch('m_guest', $data);
		return "ok";
	}
	
	function update_tamu($nama, $data)
	{
		$this->db->where("guest_name", $nama);
		$query = $this->db->get("m_guest")->result_array();
		$tmp = "no";
		if (count($query) > 0) {
			$this->db->where("guest_name", $nama);
			$this->db->update('m_guest', $data);
			$tmp = "ok";
		} 
		return $tmp;
	}
}