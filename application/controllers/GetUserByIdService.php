<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'GeoUser.php';

class GetUserByIdService extends CI_Controller {

    public function getById()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $userId = $_GET['user_id'];
            } else if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $userId = $lat = $this->input->post('user_id');
            }

            $users = GeoUser::getById($userId);

            if ($users) {

                $datos["user"] = $users;

                print json_encode($datos);
            } else {
                print json_encode(array(
                    "state" => "empty",
                    "message" => "No hay usuario asociado al ID"
                ));
            }
        
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
}