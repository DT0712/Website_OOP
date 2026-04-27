<?php
class Message {

    public static function save($session, $sender, $message) {
        $conn = Database::connect();

        $stmt = $conn->prepare(
            "INSERT INTO messages(session_id,sender,message) VALUES(?,?,?)"
        );
        $stmt->bind_param("sss",$session,$sender,$message);
        $stmt->execute();
    }

    public static function getBySession($session) {
        $conn = Database::connect();

        $stmt = $conn->prepare(
            "SELECT sender,message FROM messages 
             WHERE session_id=? ORDER BY id ASC LIMIT 10"
        );
        $stmt->bind_param("s",$session);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}