<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'GeoUser.php';

class SaveUserService extends CI_Controller {

    public function save()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

            $retorno = GeoUser::insert(
                //$_GET['user_id'],
                $_GET['username'],
                $_GET['email'],
                $_GET['password'],
                $_GET['status']);

            if ($retorno) {
                print json_encode(
                    array(
                        'state' => 'SUCCESS GET',
                        'message' => 'Usuario Guardado Satisfactoriamente')
                );
            } else {
                print json_encode(
                    array(
                        'status' => 'failed GET',
                        'message' => 'Ocurrio un error al guardar el usuario')
                );
            }
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $retorno = GeoUser::insert(
                //$this->input->post('user_id'),
                $this->input->post('username'),
                $this->input->post('email'),
                $this->input->post('password'),
                $this->input->post('status'));
            
            if ($retorno) {
                print json_encode(
                    array(
                        'state' => 'SUCCESS POST',
                        'message' => 'Usuario Guardado Satisfactoriamente')
                );
            } else {
                print json_encode(
                    array(
                        'status' => 'failed POST',
                        'message' => 'Ocurrio un error al guardar el usuario')
                );
            }

        }
    }

}
