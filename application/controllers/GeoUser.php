<?php

require 'Database.php';

class GeoUser
{
    function __construct()
    {
    }

    public static function getAll()
    {
        $consulta = "SELECT user_id usuarioid, username, email, password, status estado FROM USER";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();

            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function getById($idUser)
    {
        $consulta = "SELECT USER_ID usuarioid, USERNAME username, EMAIL email,
                            PASSWORD password, STATUS estado
                             FROM USER
                             WHERE USER_ID = ?";

        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($idUser));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            return -1;
        }
    }
	
	
	public static function getByLogin($username, $password)
    {
        $consulta = "SELECT USER_ID usuarioid, EMAIL email
                             FROM USER
                             WHERE USERNAME = ?
							 AND PASSWORD = ?";

        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($username, $password));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            return -1;
        }
    }

	public static function checkUsername($username)
    {
        $consulta = "SELECT username
                             FROM USER
                             WHERE USERNAME = ?";

        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($username));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            return -1;
        }
    }

	
    public static function update(
        $idMeta,
        $titulo,
        $descripcion,
        $fechaLim,
        $categoria,
        $prioridad
    )
    {
        $consulta = "UPDATE meta" .
            " SET titulo=?, descripcion=?, fechaLim=?, categoria=?, prioridad=? " .
            "WHERE idMeta=?";

        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        $cmd->execute(array($titulo, $descripcion, $fechaLim, $categoria, $prioridad, $idMeta));

        return $cmd;
    }

    public static function insert(
        //$UserID,
        $Username,
        $Email,
        $Password,
        $State
    )
    {
		
		$consulta = "SELECT MAX(user_id)+1 USER_ID FROM USER";
        $comando = Database::getInstance()->getDb()->query($consulta);
        $result = $comando->fetch(1);
        $NextUserID = $result[0];
		
        $comando = "INSERT INTO USER ( " .
            "USER_ID," .
            " USERNAME," .
            " EMAIL," .
            " PASSWORD," .
            " STATUS)" .
            " VALUES( ?,?,?,?,?)";

        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(
            array(
                $NextUserID,
                $Username,
                $Email,
                $Password,
                $State
            )
        );

    }
}

?>