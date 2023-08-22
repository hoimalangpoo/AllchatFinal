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

    // ////////////////////////////////LINECHATROOM///////////////////////////////////////////
    public function linegetchats($id1, $id2, $db)
    {
        $line_id = $db->query("SELECT * FROM line_contact WHERE user_id = :user_id", [
            "user_id" => $id2,
        ])->find();
        $recieve_id = $line_id['id'];

        $chat = $db->query("SELECT * FROM line_chat WHERE (sender_id = :sender_id AND recieve_id = :recieve_id)
                                                OR  (sender_id = :recieve_id AND recieve_id = :sender_id)
                                                ORDER BY chat_id ASC", [
            "sender_id" => $id1,
            "recieve_id" => $recieve_id
        ])->findAll();

        return $chat;
    }

    public function lineopened($id_1, $db, $chats)
    {
        foreach ($chats as $chat) {
            if ($chat['opened'] == 0) {
                $opened = 1;
                $chat_id = $chat['chat_id'];
                $db->query("UPDATE line_chat SET opened = :opened WHERE sender_id = :sender_id AND chat_id = :chat_id", [
                    "opened" => $opened,
                    "sender_id" => $id_1,
                    "chat_id" => $chat_id
                ]);
            }
        }
    }
    // ////////////////////////////////LINECHATROOM///////////////////////////////////////////

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
    public function lineOAgetchats($userid, $getalluser, $db)
    {  
        $chat = [];

        foreach ($getalluser as $user) {
            $recieve_id = $user['id'];
            $chats = $db->query("SELECT * FROM line_chat WHERE (sender_id = :sender_id AND recieve_id = :recieve_id)
                                                OR  (sender_id = :recieve_id AND recieve_id = :sender_id)
                                                ORDER BY chat_id ASC", [
                "sender_id" => $userid,
                "recieve_id" => $recieve_id
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
