<?php

class StatementModel
{
    public static function getAllstatements()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM statements WHERE active = :active";
        $query = $database->prepare($sql);
        $query->execute(array(':active' => '1'));

        return $query->fetchAll();   
    }

    public static function addStatement($statement)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO statements (description) VALUES (:statement)";
        $query = $database->prepare($sql);
        $query->execute(array(':statement' => $statement));
      
        if ($query->rowCount() === 1) {
            return true;
        }


        return false;
    }

    public static function editStatement($id, $statement, $active)
    {
        if ($active === "on") {
            $active = "0";
        } else {
            $active = "1";
        } 

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE statements SET description = :description, active = :active WHERE id = :id";
        $query = $database->prepare($sql);
        $query->execute(array(':description' => $statement, ':id' => $id, ':active' => $active));

        if ($query->rowCount() === 1) {
            return true;
        }


        return false;
    }

}