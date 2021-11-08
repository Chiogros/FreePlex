<?php

class SourceFolderDAO {

	private PDO $db;
    
	function __construct() {
		$dsn = "sqlite:../data/mmdb";
		try { 
			$this->db = new PDO($dsn); 
		} catch(PDOException $e) { 
			echo "The database cannot be opened: " . $e->getMessage(); 
		}
	}

	public function add_SourceFolder(SourceFolder $SF) {

		// Verify that source folder isn't already in db
		if ($this->exists_SourceFolder($SF))
			throw new Exception("A source folder with this alias or pointing to the same path is already in database.");

		// Add SourceFolder in db
		$sql = "INSERT INTO SourceFolders VALUES (
			:alias,
			:path)";
		
		$request = $this->db->prepare($sql);
		if ($request === false)
			throw new Exception("Cannot add SourceFolder in database: cannot prepare request. Is database available?");
		
		$request->bindValue(':alias', $SF->alias, PDO::PARAM_STR);
		$request->bindValue(':path', $SF->path , PDO::PARAM_STR);
		$request->execute();
	}
    
	public function exists_SourceFolder(SourceFolder $SF) : bool {
		$sql = "SELECT COUNT(*) FROM SourceFolders WHERE alias = :alias OR path = :path";
		
		try {
			$request = $this->prepare_request($sql);
			$request->bindValue(':alias', $SF->alias, PDO::PARAM_STR);
			$request->bindValue(':path', $SF->path, PDO::PARAM_STR);
			$request->execute();
			return $request->fetch()[0];
		} catch (Exception $ex) {
			throw $ex;
		}
	}
	
	public function exists_SourceFolder(string $aliasORpath) : bool {
		$sql = "SELECT COUNT(*) FROM SourceFolders WHERE alias = :alias OR path = :path";
		
		try {
			$request = $this->prepare_request($sql);
			$request->bindValue(':alias', $aliasORpath, PDO::PARAM_STR);
			$request->bindValue(':path', $aliasORpath, PDO::PARAM_STR);
			$request->execute();
			return $request->fetch()[0];
		} catch (Exception $ex) {
			throw $ex;
		}
	}
    
	public function get_SourceFolder(string $aliasORpath) : SourceFolder {
		
		$sql = "SELECT * FROM SourceFolders WHERE alias = :alias OR path = :path";

		if ($this->exists_SourceFolder($aliasORpath) === false)
			throw new Exception("This source folder doesn't exist in database.");
		
		try {
			$request = $this->prepare_request($sql);
			$request->bindValue(':alias', $aliasORpath, PDO::PARAM_STR);
			$request->bindValue(':path', $aliasORpath, PDO::PARAM_STR);
			$request->execute();
			return $request->fetchAll(PDO::FETCH_CLASS, "SourceFolder");
		} catch (Exception $ex) {
			throw $ex;
		}
	}
    
	public function get_all_alias() : array {
		$sql = "SELECT alias FROM SourceFolders";
		
		try {
			$request = $this->prepare_request($sql);
			$request->execute();
			return $request->fetchAll(PDO::FETCH_COLUMN, 0);
		} catch (Exception $ex) {
			throw $ex;
		}
	}
    
	public function get_number_of_source_folders() : int {
		$sql = "SELECT COUNT(*) FROM SourceFolders";
		
		try {
			$request = $this->prepare_request($sql);
			$request->execute();
			return $request->fetch()[0];
		} catch (Exception $ex) {
			throw $ex;
		}
	}
    
    private function prepare_request(string $sql) : PDOStatement {
		$request = $this->db->prepare($sql);
		if ($request === false)
			throw new Exception("Cannot prepare request. Is database available?");
		
		return $request;
	}
    
	public function remove_SourceFolder(string $aliasORpath) : bool {
		$sql = "DELETE FROM SourceFolders WHERE alias = :alias OR path = :path";

		if ($this->exists_SourceFolder($aliasORpath) === false)
			throw new Exception("This source folder doesn't exist in database.");
		
		try {
			$request = $this->prepare_request($sql);
			$request->bindValue(':alias', $aliasORpath, PDO::PARAM_STR);
			$request->bindValue(':path', $aliasORpath, PDO::PARAM_STR);
			$request->execute();
			return $request->execute();
		} catch (Exception $ex) {
			throw $ex;
		}
	}
    
}
