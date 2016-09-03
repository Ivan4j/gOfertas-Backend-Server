<?php

require 'Database.php';

class Offer
{
    function __construct()
    {
    }

    public static function getAll()
    {
        
        $consulta = "SELECT o.OFFER_ID ofertaid, o.TITLE titulo, o.DESCRIPTION descripcion, o.SCORE calificacion,
                        o.CATEGORY_ID categoriaid, c.DESCRIPTION categoria, o.PRICE precio,
                        o.STORE_ID tiendaid, s.NAME tienda, o.LAT latitud, o.LON longitud, 
                        o.PICTURE foto, o.URL url, o.IS_NATIONWIDE nacional,
                        o.TIMESTAMP timestamp, o.USER_ID usuarioid, o.ACTIVE activo
                        FROM OFFER o, Category c, STORE s
                        WHERE o.category_id = c.category_id
                        and o.store_id = s.store_id
                        order by 1";

        try {
            
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();

            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
	

    public static function getAllByLatLon($lat, $lon, $radius, $categories)
    {
        if($radius)
			$radius = $radius / 1000 / 1.60934;
		else
			$radius = 0.25;
		
        if($categories != "-1")
            $categories_condition = " AND o.CATEGORY_ID in ($categories) ";
        else
            $categories_condition = "";

		$query = 
		"SELECT o.OFFER_ID ofertaid, o.TITLE titulo, o.LAT latitud, o.LON longitud, o.PRICE precio, o.SCORE calificacion, o.PICTURE foto,
        s.NAME tienda, o.STORE_ID tiendaid,
        c.DESCRIPTION categoria, o.CATEGORY_ID categoriaid, 
		( 3959 * acos( cos( radians($lat) ) *
			  cos( radians( o.LAT ) ) * cos( radians( o.LON ) - radians($lon) ) +
			  sin( radians($lat) ) *
			  sin( radians( o.LAT ) ) ) )
			  AS distance
		FROM OFFER o, Category c, STORE s
        WHERE o.category_id = c.category_id
        and o.store_id = s.store_id 
        ".$categories_condition."
		HAVING distance < $radius
		ORDER BY distance LIMIT 0 , 20";
		
        //echo $query;
		
        try {
        
            $comando = Database::getInstance()->getDb()->prepare($query);
            $comando->execute();
			
            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function getById($idOffer)
    {
        $consulta = "SELECT o.OFFER_ID ofertaid, o.TITLE titulo, o.DESCRIPTION descripcion, o.SCORE calificacion,
                            o.CATEGORY_ID categoriaid, c.DESCRIPTION categoria, o.PRICE precio,
                            o.STORE_ID tiendaid, s.NAME tienda, o.LAT latitud, o.LON longitud, 
                            o.PICTURE foto, o.URL url, o.IS_NATIONWIDE nacional,
                            o.TIMESTAMP timestamp, o.USER_ID usuarioid, o.ACTIVE activo
                            FROM OFFER o, Category c, STORE s
                            WHERE OFFER_ID = ?
                            and o.category_id = c.category_id
                            and o.store_id = s.store_id";

        try {
            
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($idOffer));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            echo $e->getMessage();
			return -1;
        }
    }

    public static function insert(
        
        $Title,
        $Description,
        $Score,
        $CategoryId,
        $Price,
        $StoreId, 
        $Lat, 
        $Lon, 
        $Picture, 
        $URL, 
        $IsNationalwide,
        $UserId
    )
    {

        $consulta = "SELECT MAX(offer_id)+1 OFFER_ID FROM OFFER";
        $comando = Database::getInstance()->getDb()->query($consulta);
        $result = $comando->fetch(1);
        $NextOfferID = $result[0];
        
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');

        $comando = "INSERT INTO OFFER ( " .
            " OFFER_ID," .
            " TITLE," .
            " DESCRIPTION," .
            " SCORE," .
            " CATEGORY_ID," .
            " PRICE," .
            " STORE_ID," .
            " LAT," .
            " LON," .
            " PICTURE," .
            " URL," .
            " IS_NATIONWIDE," .
            " TIMESTAMP," .
            " USER_ID)" .
            " VALUES( ?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(
            array(
                $NextOfferID,
                $Title,
                $Description,
                $Score,
                $CategoryId,
                $Price,
                $StoreId, 
                $Lat, 
                $Lon, 
                $Picture, 
                $URL, 
                $IsNationalwide,
                $date,
                $UserId
            )
        );

    }
}

?>