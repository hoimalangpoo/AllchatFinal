<?php

namespace Core;

use PDO;

class Database
{
    public $conn;

    public $statement;

    public function __construct($config)
    {

        $dsn = "mysql:" . http_build_query($config, '', ';');

        $this->conn = new PDO($dsn, "root", "", [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }
    public function query($query, $params = [])
    {

        $this->statement = $this->conn->prepare($query);
        $this->statement->execute($params);

        return $this;
    }


    public function findAll()
    {
        return $this->statement->fetchAll();
    }

    public function lastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    public function fetchColumn()
    {
        return $this->statement->fetchColumn();
    }


    public function find()
    {
        return $this->statement->fetch();
    }

    public function findorfail()
    {
        $result = $this->find();

        if (!$result) {
            require "views/auth.view.php";
        }
    }

    // ////////////////////////////////CHATROOM///////////////////////////////////////////
    public function getchats($id1, $id2, $db)
    {
        $chat = $db->query("SELECT * FROM chat WHERE (sender_id = :sender_id AND recieve_id = :recieve_id)
                                                OR  (sender_id = :recieve_id AND recieve_id = :sender_id)
                                                ORDER BY chat_id ASC", [
            "sender_id" => $id1,
            "recieve_id" => $id2
        ])->findAll();

        return $chat;
    }

    public function opened($id_1, $db, $chats)
    {
        foreach ($chats as $chat) {
            if ($chat['opened'] == 0) {
                $opened = 1;
                $chat_id = $chat['chat_id'];
                $db->query("UPDATE chat SET opened = :opened WHERE sender_id = :sender_id AND chat_id = :chat_id", [
                    "opened" => $opened,
                    "sender_id" => $id_1,
                    "chat_id" => $chat_id
                ]);
            }
        }
    }
    // ////////////////////////////////CHATROOM///////////////////////////////////////////

    // ////////////////////////////////LINEOACHATROOM///////////////////////////////////////////

    public function getAllid($lineOAid, $db)
    {
        $line_id = $db->query("SELECT line_contact.id FROM line_contact JOIN line_oa 
        ON line_contact.lineOAid = line_oa.id
        WHERE line_oa.lineOAid = :lineOAid", [
            "lineOAid" => $lineOAid,
        ])->findAll();

        return $line_id;
    }
    public function lineOAgetchats($userid, $lineId, $getalluser, $db)
    {
        $chat = [];

        foreach ($getalluser as $user) {
            $lineuser = $user['id'];
            $chats = $db->query("SELECT DISTINCT chat_id, messages, created_at, sender_id, recieve_id, reply
            FROM (
              SELECT line_chat.chat_id, line_chat.messages, line_chat.created_at, line_chat.sender_id, line_chat.recieve_id, line_chat.reply
              FROM line_chat
              JOIN groups ON line_chat.recieve_id = groups.for_line
              JOIN group_users ON groups.group_id = group_users.group_id
              WHERE (sender_id = 1 AND recieve_id = 1)
              OR  (sender_id = 1 AND recieve_id = 1)
              OR  (group_users.user_id = 46)
              UNION ALL
              SELECT CONCAT(id, prefix), messages, created_at, sender_id, recieve_id, NULL
              FROM line_announce
            ) AS combined_data
            ORDER BY created_at;", [
                "userid" => $userid,
                "lineId" => $lineId,
                "lineuser" => $lineuser
            ])->findAll();

            $chat[] = $chats;
       
        }
        

        $all_chat = [];
        foreach ($chat as $innerArray) {
            $all_chat = array_merge($all_chat, $innerArray);
        }


        $sort_id = [];
        foreach ($all_chat as $chat) {
            $sort_id[] = $chat['chat_id'];
        }
        array_multisort($sort_id, SORT_ASC, $all_chat);
        // check($all_chat);
        return $all_chat;
    }

    // ////////////////////////////////LINEOACHATROOM///////////////////////////////////////////


}
