<?php

require 'singleton.php';

class Configuration extends Singleton {

	
	public function __construct() {
        //$this->DBH = new PDO("mysql:host=localhost;dbname=test", 'root', '');
        $this->DBH = new PDO("mysql:host=localhost;dbname=make_my_shit", 'root', 'root');
		$this->DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }

	public function getDBH() {
        return $this->DBH;
    }


}
/*

require 'singleton.php';

class Configuration extends Singleton {

    
    public function __construct() {
        //$this->DBH = new PDO("mysql:host=localhost;dbname=test", 'root', '');
        $this->DBH = new PDO("mysql:host=localhost;dbname=zoranmed_mms", 'zoranmed_mmsuser', ')XAy(TVMRIN_');
        $this->DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }

    public function getDBH() {
        return $this->DBH;
    }


}
*/
?>