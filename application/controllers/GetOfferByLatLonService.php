<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'Offer.php';

class GetOfferByLatLonService extends CI_Controller {

    public function getByLatLon()
    {
        try {
			
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {

				$lat = $_GET['lat'];
				$lon = $_GET['lon'];
				$radius = $_GET['r'];
				$categories = $_GET['c'];
				
			} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				
				$lat = $this->input->post('lat');
				$lon = $this->input->post('lon');
				$radius = $this->input->post('r');
				$categories = $this->input->post('c');

			}
			
			$users = Offer::getAllByLatLon($lat, $lon, $radius, $categories);

			if ($users) {

				$datos["offers"] = $users;
				print json_encode($datos);
				
			} else {
				print json_encode(array(
					"state" => "empty",
					"message" => "No near offers found ($lat, $lon)"
				));
			}
			
		
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
}