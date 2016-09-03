<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'Offer.php';

class GetOfferByIdService extends CI_Controller {

    public function getById()
    {
        try {
			
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {

				$offerID = $_GET['offer_id'];
				
			} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				
				$offerID = $this->input->post('offer_id');
				
			}
			
			$users = Offer::getById($offerID);

			if ($users) {

				print json_encode($users);
				
			} else {
				print json_encode(array(
					"state" => "empty",
					"message" => "Ningua oferta asociada con este ID = ".$offerID
				));
			}
		
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
}