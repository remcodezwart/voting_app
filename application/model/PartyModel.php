<?php

class PartyModel
{
    public static function getPartyByName($name)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM parties WHERE name = :name AND active = :active";
        $query = $database->prepare($sql);
        $query->execute(array('name' => $name, 'active' => '1'));

        return $query->fetch();    
    }

    public static function getAllParties()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM parties WHERE active = :active";
        $query = $database->prepare($sql);
        $query->execute(array('active' => '1'));

        return $query->fetchAll();    
    }

}