<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'Offer.php';

class SaveOfferService extends CI_Controller {

    public function save()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {


            $response = Offer::insert(
                //$_GET['offer_id'],
                $_GET['title'],
                $_GET['description'],
                $_GET['score'],
                $_GET['category_id'],
                $_GET['price'],
                $_GET['store_id'],
                $_GET['lat'],
                $_GET['lon'],
                $_GET['picture'],
                $_GET['url'],
                $_GET['is_nationalwide'],
                $_GET['user_id']);

            if ($response) {
                print json_encode(
                    array(
                        'state' => 'SUCCESS GET',
                        'message' => 'Oferta Guardada Satisfactoriamente')
                );
            } else {
                print json_encode(
                    array(
                        'status' => 'failed GET',
                        'message' => 'Ocurrio un error al guardar la oferta')
                );
            }
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $response = Offer::insert(
                //$this->input->post('offer_id'),
                $this->input->post('title'),
                $this->input->post('description'),
                $this->input->post('score'),
                $this->input->post('category_id'),
                $this->input->post('price'),
                $this->input->post('store_id'),
                $this->input->post('lat'),
                $this->input->post('lon'),
                $this->input->post('picture'),
                $this->input->post('url'),
                $this->input->post('is_nationalwide'),
                $this->input->post('user_id'));
            
            if ($response) {
                print json_encode(
                    array(
                        'state' => 'SUCCESS POST',
                        'message' => 'Oferta Guardada Satisfactoriamente')
                );
            } else {
                print json_encode(
                    array(
                        'status' => 'failed POST',
                        'message' => 'Ocurrio un error al guardar la oferta')
                );
            }

        }
    }

}
