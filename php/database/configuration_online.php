<?php

require 'singleton.php';

class Configuration extends Singleton {

	
	public function __construct() {
        //$this->DBH = new PDO("mysql:host=localhost;dbname=test", 'root', '');
        $this->DBH = new PDO("mysql:host=localhost;dbname=pipe_tools", 'dusan', '3thingsIwouldDo');
		$this->DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }

	public function getDBH() {
        return $this->DBH;
    }


}
?>