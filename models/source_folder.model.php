<?php

class SourceFolder {

	private string $alias;
	private string $path;
	
	function __construct(string $alias, string $path) {
		$this->alias = $alias;
		$this->path = $path;
	}
	
	public function __get(string $attribute_name) {
		return $this->$attribute_name;
	}
    
	public function __set(string $attribute_name, $attribute_value) {
		if (isset($this->$attribute_name) === false)
			throw new Exception($attribute_name . " doesn't exist as attribute in " . __CLASS__ . ".");

			// throw new Exception("Cannot set " . gettype($attribute_value) . " in " . gettype($this->$attribute_name) . " " . $attribute_name . " in " . __CLASS__ . ".");
		$this->$attribute_name = $attribute_value;
    }

}
