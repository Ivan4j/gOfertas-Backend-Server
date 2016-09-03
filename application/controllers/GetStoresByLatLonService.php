<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'StoreShop.php';

class GetStoresByLatLonService extends CI_Controller {

    public function getByLatLon()
    {
        try {
			
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {

				$lat = $_GET['lat'];
				$lon = $_GET['lon'];
				$radius = $_GET['r'];
				
			} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				
				$lat = $this->input->post('lat');
				$lon = $this->input->post('lon');
				$radius = $this->input->post('r');

			}

			$stores = StoreShop::getAllByLatLon($lat, $lon, $radius);

			if ($stores) {

				$datos["stores"] = $stores;
				print json_encode($datos);
				
			} else {
				print json_encode(array(
					"state" => "empty",
					"message" => "No se encontraron tiendas cercanas ($lat, $lon)"
				));
			}
			
		
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
}