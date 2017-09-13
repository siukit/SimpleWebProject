<?php
	/*This class is referenced from the lecture slides*/
	class DatabaseTable{
		private $table;
	    private $pdo;
	    //this is the constructor which takes the user defined $pdo and table as arguments
	    public function __construct($pdo, $table) {
	        $this->pdo = $pdo;
	        $this->table = $table;
		}
		//find the fields with specific value in a table
		public function find($field, $value) {
			$stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $field . ' = :value'); 
			$criteria = [
			'value' => $value
			];
	    	$stmt->execute($criteria);
	    	return $stmt;
		}
		//delete the row with specific value in a field
		public function delete($field, $value) {
			$stmt = $this->pdo->prepare('DELETE FROM ' . $this->table . ' WHERE ' . $field . ' = :value'); 
			$criteria = [
				'value' => $value
			];	
			$stmt->execute($criteria);
	    	return $stmt;
		}
		
		public function insert($record) {
			$keys = array_keys($record);
			$values = implode(', ', $keys);
			$valuesWithColon = implode(', :', $keys);
			$query = 'INSERT INTO ' . $this->table . ' (' . $values . ') VALUES (:' . $valuesWithColon . ')'; 
			$stmt = $this->pdo->prepare($query);
			$success = $stmt->execute($record);
			return $success;
		}
		//for some reason not working
		public function update($record, $primaryKey) { 
			$query = 'UPDATE ' . $this->table . ' SET ';
	        $parameters = [];
	        foreach ($record as $key => $value) {
	            $parameters[] = $key . ' = :' .$key;
	        }
	        $query .= implode(', ', $parameters);
			$query .= ' WHERE ' . $primaryKey . ' = :primaryKey'; 
			$record['primaryKey'] = $record[$primaryKey];
			$stmt = $this->pdo->prepare($query); 
			$stmt->execute($record);
		}
		/*
		public function save($record, $primaryKey) {
			$success = insert($record);
        	if (!$success) {
                update($record, $primaryKey);
			}
		}
		*/

		
	}	
?>