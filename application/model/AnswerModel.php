<?php

class AnswerModel
{
    public static function answerIp()
    {
    	$database = DatabaseFactory::getFactory()->getConnection();

    	if ($_SERVER['REMOTE_ADDR'] === "::1") {
    		$ip = "127.0.0.1";//work around for localhost returning ::1
    	}

    	$sql = "SELECT * FROM ip WHERE ip = :ip";
        $query = $database->prepare($sql);
        $query->execute(array(':ip' => $ip));
        $id = $query->fetchColumn();

        if ($query->rowCount() === 0) {

        	$sql = "INSERT INTO ip (ip) VALUES(:ip)";
        	$query = $database->prepare($sql);
       	 	$query->execute(array(':ip' => $ip));
       	 	$id = $database->lastInsertId();
       	 	$type = "insert";
        } else {
        	$type = "update";
        }

        self::answer($id, $ip, $database, $type);
    }

    private static function answer($id, $ip, $database, $type)
    {
    	$answer = request::post('answer');
    	$statements = StatementModel::getAllstatements();

    	if ($type === "insert") {
    		$sql = "INSERT INTO voter_result (ip_id, statement_id, score) 							VALUES(:id, :statement_id, :score)";
    	} else if($type === "update") {
    		$sql = "UPDATE voter_result SET score = :score WHERE ip_id = :id AND statement_id = :statement_id";
    	}

        $query = $database->prepare($sql);

        foreach ($statements as $index => $statement) {
    		$query->execute(array(':id' => $id, ':score' => $answer[$index], ':statement_id' => $statement->id));
        }
    }
}
