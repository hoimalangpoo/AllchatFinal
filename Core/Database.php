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

    public function getgroupchats($user_id, $group_id, $db)
    {
        $groupchat = $db->query("SELECT group_messages.*, users.name as name_user FROM group_messages JOIN users ON group_messages.user_id = users._id
        WHERE (group_messages.user_id != :user_id AND group_messages.group_id = :group_id)
        OR  (group_messages.user_id = :user_id AND group_messages.group_id = :group_id)
        ORDER BY group_messages.group_msg_id ASC", [
            "group_id" => $group_id,
            "user_id" => $user_id
        ])->findAll();

        return $groupchat;
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
    public function openedgroup($user_id, $db, $groupchat)
    {
        foreach ($groupchat as $chat) {
            if ($chat['opened'] == 0) {
                $opened = 1;
                $group_msg_id = $chat['group_msg_id'];
                $db->query("UPDATE group_messages SET opened = :opened WHERE user_id != :user_id AND group_msg_id = :group_msg_id", [
                    "opened" => $opened,
                    "sender_id" => $user_id,
                    "group_msg_id" => $group_msg_id
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

    public function getlastchatsNotans($chats, $lineid, $db)
    {
        foreach ($chats as $chat) {
            $lastchat = $db->query("SELECT * FROM line_chat WHERE reply = 0 AND recieve_id = :lineid ORDER BY created_at DESC LIMIT 1", [
                "lineid" => $lineid
            ])->findAll();
        }

        return $lastchat;
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

    public function getMembersByGroupId($groupid, $db)
    {
        $members = $db->query("SELECT users.name, users._id, group_users.role, group_users.group_id, users.profile FROM users JOIN group_users 
        ON users._id = group_users.user_id WHERE group_id = :groupid AND group_users.deleted_at IS NULL;", [
            "groupid" => $groupid
        ])->findAll();

        return $members;
    }


    public function getFriends($userid, $groupid, $db)
    {
        $friends = $db->query("SELECT users.name, users._id FROM users 
        LEFT JOIN group_users ON users._id = group_users.user_id AND group_users.group_id = :groupid
        JOIN friend ON users._id = friend._from 
        WHERE friend.status = 'F' AND friend._to = :userid 
        AND users._id != :userid 
       	AND (group_users.user_id IS NULL OR group_users.deleted_at IS NOT NULL);", [
            "userid" => $userid,
            "groupid" => $groupid
        ])->findAll();

        return $friends;
    }

    public function checkrole($user_id, $group_id, $db)
    {
        $role = $db->query("SELECT group_users.role FROM users JOIN group_users 
        ON users._id = group_users.user_id WHERE user_id = :user_id AND group_id = :group_id;", [
            "user_id" => $user_id,
            "group_id" => $group_id

        ])->findAll();

        return $role;
    }
}