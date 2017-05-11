<?php

class PartyModel
{
    public static function getPartyByName($name)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM parties WHERE name = :name AND active = :active";
        $query = $database->prepare($sql);
        $query->execute(array(':name' => $name, ':active' => '1'));
        $party = $query->fetch(); 
        $party = Filter::XSSFilter($party);
        return $party;
    }

    public static function getAllParties()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM parties WHERE active = :active ORDER by name ASC";
        $query = $database->prepare($sql);
        $query->execute(array(':active' => '1'));

        $parties = $query->fetchAll();
        $parties = Filter::XSSFilter($parties);
        return $parties;
    }

    public static function delete($id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE parties SET active = :active WHERE id = :id";
        $query = $database->prepare($sql);
        $query->execute(array(':active' => '0', ':id' => $id));

        if ($query->rowCount() === 1) {
            return true;
        }
        Session::add('feedback_negative', Text::get('FEEDBACK_UNKNOWN_ERROR'));
        return false;
    }

    public static function edit($id)
    {      
        $statments = statementModel::getAllstatements();
        $opions = request::post('statements');

        if (count($statments) !== count($opions)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_UNKNOWN_ERROR'));
            return false;
            exit;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE opions SET score = :score, active = :active WHERE party_id = :party_id AND statement_id = :statment_id";
        $query = $database->prepare($sql);
        foreach ($statments as $key => $statment) {
            $query->execute(array(':score' => $opions[$key], ':active' => 1, ':party_id' => $id, ':statment_id' => $statment->id) );
        }    
        
        if ($query->rowCount() >= 1) {
            Session::add('feedback_positive', Text::get('SUCCES_EDIT_PARTY_OPIONS'));
            return true;
        }
        Session::add('feedback_negative', Text::get('FEEDBACK_UNKNOWN_ERROR'));
        return false;
    }

    public static function add($name)
    {      
        if (is_Null($name)) {
            Session::add('feedback_negative', Text::get('EMPTY_NAME_PARTY'));
            return false;
        }

        if (self::doesPartyAlreadyExist($name)) {
            Session::add('feedback_negative', Text::get('PARTY_ALREADY_EXSIST'));
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO parties (name) VALUES (:name)";
        $query = $database->prepare($sql);
        $query->execute(array(':name' => $name));

        $id = $database->lastInsertId();
        $statements = StatementModel::getAllstatements();

        if ($query->rowCount() === 1) {
            $statements = StatementModel::getAllstatements();

            $sql = "INSERT INTO opions (statement_id, party_id) VALUES (:statement_id, :party_id)";
            $query = $database->prepare($sql);

            foreach ($statements as $statement) {
                $query->execute(array(':statement_id' => $statement->id, ':party_id' => $id));
            }

            return true;
        }
        Session::add('feedback_negative', Text::get('FEEDBACK_UNKNOWN_ERROR'));
        return false;
    }

    public static function getAllpartiesWithStatments()
    {
        $parties = self::getAllParties();

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT opions.score FROM opions WHERE opions.active = :active AND party_id = :party_id";
        $query = $database->prepare($sql);

        foreach ($parties as $index => $party) {

            $parties[$index]->statements = "";

            $query->execute(array(':active' => 1, ':party_id' => $party->id));

            foreach ($query->fetchAll() as $statement) {
                $parties[$index]->statements .= $statement->score.",";
            }
            
        }

        $parties = Filter::XSSFilter($parties);

        return $parties;
    }

    protected static function doesPartyAlreadyExist($party)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM parties WHERE name = :name AND active = :active";
        $query = $database->prepare($sql);
        $query->execute(array(':name' => $party, ':active' => 1));

        return $query->rowCount() === 1;
    }
}