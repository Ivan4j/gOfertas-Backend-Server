<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'GeoUser.php';

class CheckUsernameService extends CI_Controller {

    public function check()
    {
        try {
			
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {

				$username = $_GET['username'];
				
			} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				
				$username = $this->input->post('username');
			}
			
			$user = GeoUser::checkUsername($username);

			if ($user) {

				print json_encode(array(
					"state" => "Error",
					"message" => "El nombre de usuario ya existe, elegir otro"
				));
				
			} else {
				print json_encode(array(
					"state" => "empty",
					"message" => "Nombre de usuario disponible"
				));
			}
		
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

}
