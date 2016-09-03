<?php

require 'Database.php';

class StoreShop
{
    function __construct()
    {
    }

    public static function getAll()
    {
        $consulta = "SELECT * FROM STORE";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();

            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function getById($idStore)
    {
        $consulta = "SELECT *
                             FROM STORE
                             WHERE STORE_ID = ?";

        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($idUser));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            return -1;
        }
    }
	
	public static function getAllByLatLon($lat, $lon, $radius)
    {
		if($radius)
			$radius = $radius / 1000 / 1.60934;
		else
			$radius = 0.25;
		
		$query = 
		"SELECT s.STORE_ID storeid, s.NAME name, s.LAT latitud, s.LON longitud,
		( 3959 * acos( cos( radians($lat) ) *
			  cos( radians( s.LAT ) ) * cos( radians( s.LON ) - radians($lon) ) +
			  sin( radians($lat) ) *
			  sin( radians( s.LAT ) ) ) )
			  AS distance
		FROM STORE s
		HAVING distance < $radius
		ORDER BY distance
		";
		
        try {
        
            $comando = Database::getInstance()->getDb()->prepare($query);
            $comando->execute();
			
            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function insert(
        $Name,
        $Lat,
        $Lon
    )
    {

    $consulta = "SELECT MAX(STORE_ID)+1 STORE_ID FROM STORE";
        $comando = Database::getInstance()->getDb()->query($consulta);
        $result = $comando->fetch(1);
        $NextStoreID = $result[0];


        $comando = "INSERT INTO STORE ( " .
            " STORE_ID," .
            " NAME," .
            " LAT," .
            " LON)" .
            " VALUES( ?,?,?,?)";

        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(
            array(
                $NextStoreID,
                $Name,
                $Lat,
                $Lon
            )
        );

    }

}

?>