<?php

class database{

	private $db_host = "localhost";
	private $db_user = "root";
	private $db_pass = "";
	private $db_name = "testing";

	private $mysqli = "";
	private $result = [];
	private $conn = false;

	public function __construct(){
		if (!$this->conn) {
			$this->mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
			$this->conn = true;
			if ($this->mysqli->connect_error) {
				array_push($this->result, $this->mysqli->connect_error);
				return false;
			}
		} else {
			return true;
		}
	}

// INSERT
	public function insert($table, $params = array()){
		if ($this->tableExists($table)) {
			$table_columns = implode(', ', array_keys($params));
			$table_value = implode(', ', $params);
			$sql = "INSERT INTO $table ($table_columns) VALUES ($table_value)";

			if($this->mysqli->query($sql)){
				array_push($this->result, $this->mysqli->insert_id);
				return true;
			} else {
				array_push($this->result, $this->mysqli->connect_error);
				return false;
			}
		} else {
			return false;
		}
	}

// Function to update row in database

	public function update($table, $params =[], $where = null){
		if ($this->tableExists($table)) {
			$args = [];
			foreach ($params as $key => $value) {
				$args[] = "$key = '$value'";
			}
			$sql = "UPDATE $table SET " . implode(',', $args);
			if($where != null){
				$sql .= "WHERE $where";
			}

			if($this->mysqli->query($sql)){
				array_push($this->result, $this->mysqli->affected_rows);
			} else {
				array_push($this->result, $this->mysqli->error);
			}

		} else {
			return false;
		}
		
	}

	public function delete($table, $where = null){

		if ($this->tableExists($table)) {
			$sql = "DELETE FROM $table";
			if($where != null){
				$sql .= " WHERE $where";
			}

			if($this->mysqli->query($sql)){
				array_push($this->result, $this->mysqli->affected_rows);
				return true;
			} else {
				array_push($this->result, $this->mysqli->error);
				return false;
			}

		} else {
			return false;
		}
		
	}

	public function select($table, $rows="*", $join=null, $where=null, $order=null, $limt){

		if ($this->tableExists($table)) {
			$sql = "SELECT $rows FROM $table";
			
			if($join != null){
				$sql .= " JOIN $join";
			}

			if($where != null){
				$sql .= " WHERE $where";
			}

			if($order != null){
				$sql .= " ORDER BY $order";
			}

			if($limt != null){
				$sql .= " LIMIT 0,$limt";
			}

			$query = $this->mysqli->query($sql);

		if($query){
			$this->result = $query->fetch_all(MYSQLI_ASSOC);
			return true;
		}else{
			array_push($this->result, $this->mysqli->error);
			return false;
		}
		} else {
			return false;
		}
		
	}

	public function sql($sql){
		$query = $this->mysqli->query($sql);

		if($query){
			$this->result = $query->fetch_all(MYSQLI_ASSOC);
			return true;
		}else{
			array_push($this->result, $this->mysqli->error);
			return false;
		}
	}

private function tableExists($table){
	$sql = "SHOW TABLES FROM $this->db_name LIKE '$table'";
	$tableInDb = $this->mysqli->query($sql);
	if($tableInDb){
		if($tableInDb->num_rows == 1){
			return true;
		}else{
			array_push($this->result, $table."does not exist in this database");
			return false;
		}

	}
}

public function getResult(){
	$val = $this->result;
	$this->result = [];
	return $val;
}
	// close connection
	public function __destruct(){
		if ($this->conn) {
			if($this->mysqli->close()){
				$this->conn = false;
				return true;
			}
		}else{
			return false;
		}

	}
}

?>