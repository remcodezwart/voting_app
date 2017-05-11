<?php

class StatementModel
{
    public static function getAllstatements()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM statements WHERE active = :active";
        $query = $database->prepare($sql);
        $query->execute(array(':active' => '1'));

        $statements = $query->fetchAll();   
        $statements = Filter::XSSFilter($statements);

        return $statements;  
    }

    public static function addStatement($statement)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        if (is_Null($statement)) {
            Session::add('feedback_negative', Text::get('EMPTY_NAME_STATEMENT'));
            return false;
        }

        if (self::doesStatementAlreadyExist($statement)) {
            Session::add('feedback_negative', Text::get('STATEMENT_ALREADY_EXSIST'));
            return false;
        }

        $sql = "INSERT INTO statements (description) VALUES (:statement)";
        $query = $database->prepare($sql);
        $query->execute(array(':statement' => $statement));

        if ($query->rowCount() === 1) {

            $id = $database->lastInsertId();
            $parties = PartyModel::getAllParties();

            $sql = "INSERT INTO opions (statement_id, party_id) VALUES (:statement_id, :party_id)";
            $query = $database->prepare($sql);

            foreach ($parties as $party) {
                $query->execute(array(':statement_id' => $id, ':party_id' => $party->id));
            }

            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_UNKNOWN_ERROR'));
        return false;
    }

    public static function editStatement($id, $statement, $active)
    {
        if (is_Null($statement)) {
            Session::add('feedback_negative', Text::get('EMPTY_NAME_STATEMENT'));
            return false;
        }

        if ($active === "on") {
            $active = "0";
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE statements SET description = :description, active = :active WHERE id = :id";
        $query = $database->prepare($sql);
        $query->execute(array(':description' => $statement, ':id' => $id, ':active' => $active));

        if ($query->rowCount() === 1) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_UNKNOWN_ERROR'));
        return false;
    }

    public static function getStatmentsByParty($party)
    {   
        if (is_Null($party)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_UNKNOWN_ERROR'));
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM opions WHERE party_id = :id AND active = :active";
        $query = $database->prepare($sql);
        $query->execute(array(':id' => $party->id, ':active' => '1'));

        if ($query->rowCount() >= 1) {
            
            $sql = "SELECT * FROM opions INNER JOIN parties ON party_id = parties.id INNER JOIN statements ON statement_id = statements.id WHERE parties.active = :active AND statements.active = :active AND parties.name = :name";
            $query = $database->prepare($sql);
            $query->execute(array(':name' => $party->name, ':active' => '1'));

        } else {

            $sql = "SELECT * FROM statements WHERE active = :active";
            $query = $database->prepare($sql);
            $query->execute(array(':active' => '1'));

        }

        $statements = $query->fetchAll();   
        $statements = Filter::XSSFilter($statements);

        return $statements;
    }

    protected static function doesStatementAlreadyExist($statement)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM statements WHERE description = :statement AND active = :active";
        $query = $database->prepare($sql);
        $query->execute(array(':statement' => $statement, ':active' => 1));

        return $query->rowCount() === 1;
    }

}
