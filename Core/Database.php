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
            $chats = $db->query("-- กรณีที่มีกลุ่มและเป็นสมาชิกในกลุ่ม
            (SELECT line_chat.*
            FROM line_chat
            JOIN line_oa ON line_chat.recieve_id = line_oa.id 
            JOIN groups ON line_oa.id = groups.for_line
            JOIN group_users ON groups.group_id = group_users.group_id
            WHERE (groups.created_by != :userid AND group_users.user_id = :userid) AND 
            (line_chat.sender_id = :lineuser AND line_chat.recieve_id = :lineId) 
            
            UNION
            
            -- กรณีที่ไม่มีกลุ่มและเป็นคนสร้าง
            SELECT line_chat.*
            FROM line_chat
            JOIN line_oa ON line_chat.recieve_id = line_oa.id
            WHERE line_oa.by_user = :userid AND line_oa.id NOT IN (SELECT for_line FROM groups)
            AND (line_chat.sender_id = :lineuser AND line_chat.recieve_id = :lineId) 
            
            -- กรณีที่มีกลุ่มและเป็นคนสร้าง
            UNION
            
            SELECT line_chat.*
            FROM line_chat
            JOIN line_oa ON line_chat.recieve_id = line_oa.id
            JOIN groups ON line_oa.id = groups.for_line
            WHERE groups.created_by = :userid AND (line_chat.sender_id = :lineuser AND line_chat.recieve_id = :lineId) )
            ORDER BY created_at", [
                "userid" => $userid,
                "lineId" => $lineId,
                "lineuser" => $lineuser
            ])->findAll();

            $chat[] = $chats;
        }
        $announce = $db->query("SELECT CONCAT(id, prefix) as chat_id, messages, sender_id, recieve_id, created_at
        FROM line_announce WHERE to_line = :lineId", [
            "lineId" => $lineId
        ])->findAll();

        $chat[] = $announce;



        // check($chat);
        $all_chat = [];
        foreach ($chat as $innerArray) {
            $all_chat = array_merge($all_chat, $innerArray);
        }

        foreach ($all_chat as $chat) {
            $chat['created_at'] = strtotime($chat['created_at']);
        }

        array_multisort(array_column($all_chat, 'created_at'), SORT_ASC, $all_chat);


        // check($all_chat);
        return $all_chat;
    }

    public function getreply($userid, $chat_id, $linech, $db)
    {
        $reply = $db->query("SELECT line_reply.*
    FROM line_reply
    WHERE 
        (line_reply.sender_id = :userid AND line_reply.chat_id = :chat_id AND line_reply.from_ch = :linech)
        OR
        ((SELECT by_user FROM line_oa WHERE by_user = :userid) 
        AND line_reply.from_ch = :linech AND line_reply.chat_id = :chat_id)", [
            "userid" => $userid,
            "chat_id" => $chat_id,
            "linech" => $linech
        ])->findAll();

        // check($reply);
        return $reply;
    }

    // ////////////////////////////////LINEOACHATROOM///////////////////////////////////////////



}
