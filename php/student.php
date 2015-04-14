<?php 
	class Student {
		function Student($arr) {

			foreach ($arr as $key => $value) {
				$this->$key = $value;			 	
			} 

		}
	}
	
	