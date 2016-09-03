<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'aws/aws-autoloader.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class SaveImageService extends CI_Controller {


    public function save2()
    {
		$this->load->helper('url');
		echo " URL :  ".FCPATH;
	}
    public function save()
    {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            try {
				
                $img = $_POST['data'];
				$name = $_POST['image_name'];
                $img = str_replace('data:image/png;base64,', '', $img);
				$img = str_replace('data:image/jpeg;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);
                
                $success = file_put_contents(FCPATH."resources/image/".$name, $data);
                
				if($success) {
					print json_encode(
						array(
							'state' => 'SUCCESS POST IMAGE',
							'message' => 'Imagen Guardada Satisfactoriamente')
					);
				} else {
					print json_encode(
						array(
							'state' => 'FAILED POST IMAGE',
							'message' => 'Hubo un problema y la Imagen no se guardó')
					);
				}

            } catch (Exception $e) {
                print json_encode(
                    array(
                        'status' => 'Failed POST',
                        'message' => 'Ocurrio un error al guardar la Imagen')
                );

                echo $e->getMessage();
                return false;
            }

        }
		
		//echo "sendingStoredImage to AWS S3";
		
		//ADD THE KEYS
		if (!defined('awsAccessKey')) define('awsAccessKey', 'AWS_ACCESS_KEY');
		if (!defined('awsSecretKey')) define('awsSecretKey', 'AWS_SECRET_KEY');
		
		$client = S3Client::factory(
		array(
			'region' => 'us-west-2',
			'version' => 'latest',
			'scheme' => 'http',
			'credentials' => array(
				'key'    => awsAccessKey,
				'secret' => awsSecretKey
			 )
		));
		
		try {
			$client->putObject(array(
				//ADD THE BUCKET NAME
				'Bucket'     => 'elasticbeanstalk-XXXX-XXXXX-X-XXXXXXXXXXXX',
				'Key'        => 'images/'.$name,
				'SourceFile' => 'resources/image/'.$name,
				'StorageClass' => 'REDUCED_REDUNDANCY'
			));
			
		} catch (S3Exception $e) {
			echo $e->getMessage();
		}
		
		//echo "imageStoredOnAWS S3 Server";
    }

}
