<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'GeoUser.php';

class LogInUserService extends CI_Controller {

    public function logIn()
    {
        try {
			
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {

				$username = $_GET['username'];
				$password = $_GET['password'];
				
			} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				
				$username = $this->input->post('username');
				$password = $this->input->post('password');
			}
			
			$user = GeoUser::getByLogin($username, $password);

			if ($user) {

				print json_encode($user);
				
			} else {
				print json_encode(array(
					"state" => "empty",
					"message" => "Usuario o Password Incorrecto"
				));
			}
		
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

}
