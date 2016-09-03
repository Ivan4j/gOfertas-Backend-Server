<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'GeoUser.php';

class GetAllUsersService extends CI_Controller {

    public function getAll()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST') {

                $users = GeoUser::getAll();

                if ($users) {

                    $datos["users"] = $users;

                    print json_encode($datos);
                } else {
                    print json_encode(array(
                        "state" => "failed",
                        "mensaje" => "Error"
                    ));
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
}