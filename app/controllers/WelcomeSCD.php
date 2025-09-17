<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class WelcomeSCD extends Controller {
	public function profile($fname, $lname) 
    {
		$data['lname'] = $lname;
		$data['fname'] = $fname;
		$this->call->view('profile', $data);
	}
}
?>

   
