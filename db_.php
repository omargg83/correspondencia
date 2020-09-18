<?php
require_once("control_db.php");

class dashboard extends Salud{
	public function __construct(){
		parent::__construct();

	}
}

$db = new dashboard();
