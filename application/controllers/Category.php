<?php

require 'Database.php';

class Category
{
    function __construct()
    {
    }

    public static function getAll()
    {
        
        $consulta = "SELECT c.CATEGORY_ID categoriaid, c.DESCRIPTION descripcion
                        FROM Category c
                        ORDER by 2";

        try {
            
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();

            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
	
}

?>