<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'Category.php';

class GetAllCategoriesService extends CI_Controller {

    public function getAll()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST') {

                $users = Category::getAll();

                if ($users) {

                    $datos["categorias"] = $users;

                    print json_encode($datos);
                } else {
                    print json_encode(array(
                        "state" => "failed",
                        "message" => "Error"
                    ));
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
}