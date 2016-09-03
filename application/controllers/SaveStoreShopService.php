<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'StoreShop.php';

class SaveStoreShopService extends CI_Controller {

    public function save()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

            $retorno = StoreShop::insert(
                $_GET['name'],
                $_GET['lat'],
                $_GET['lon']);

            if ($retorno) {
                print json_encode(
                    array(
                        'state' => 'SUCCESS GET',
                        'message' => 'Tienda Guardada Satisfactoriamente')
                );
            } else {
                print json_encode(
                    array(
                        'status' => 'failed GET',
                        'message' => 'Ocurrio un error al guardar la Tienda')
                );
            }
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $retorno = StoreShop::insert(
                $this->input->post('name'),
                $this->input->post('lat'),
                $this->input->post('lon'));
            
            if ($retorno) {
                print json_encode(
                    array(
                        'state' => 'SUCCESS POST',
                        'message' => 'Tienda Guardada Satisfactoriamente')
                );
            } else {
                print json_encode(
                    array(
                        'status' => 'failed POST',
                        'message' => 'Ocurrio un error al guardar la Tienda')
                );
            }

        }
    }

}
