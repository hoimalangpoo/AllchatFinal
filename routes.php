<?php 
// ---------------------------------------------LOGIN-----------------------------------------
$router->get('/', 'controllers/index.php');
$router->get('/login', 'controllers/login/index.php')->only('guest');
$router->post('/login', 'controllers/login/login.php');
$router->get('/register', 'controllers/register/index.php')->only('guest');
$router->post('/register', 'controllers/register/store.php');
$router->get('/logout', 'controllers/logout.php')->only('auth');

// ---------------------------------------------FRIEND-----------------------------------------
$router->get('/addfriend', 'controllers/friends/addfriend.php')->only('auth');
$router->post('/searchfriend', 'controllers/friends/addfriend.php')->only('auth');
$router->get('/faccept', 'controllers/friends/faccept.php')->only('auth');
$router->get('/friend_req', 'controllers/friends/friend_req.php')->only('auth');
$router->get('/chatfriend', 'controllers/friends/chat.php')->only('auth');
$router->post('/getmsg', 'controllers/friends/getmsg.php')->only('auth');
$router->post('/insert_chat', 'controllers/friends/insert_chat.php')->only('auth');

// ---------------------------------------------CHAT LINEOA-----------------------------------------
$router->get('/chat', 'controllers/chats/chat.php')->only('auth');
$router->post('/getlineOAmsg', 'controllers/chats/getmsg.php')->only('auth');
$router->post('/line_oa_chat', 'controllers/chats/insert_announce.php')->only('auth');
$router->post('/reply', 'controllers/chats/reply_insert.php')->only('auth');
$router->post('/getreply', 'controllers/chats/replyget.php')->only('auth');

// ---------------------------------------------ACCOUNT-----------------------------------------
$router->get('/account', 'controllers/account/account.php')->only('auth');
$router->post('/updated_account', 'controllers/account/updated_account.php')->only('auth');
$router->post('/webhookch1', 'controllers/line/messageAPI.CH1.php');
$router->post('/webhookch2', 'controllers/line/messageAPI.CH2.php');

// ---------------------------------------------LINEOA-----------------------------------------
$router->post('/line_chat', 'controllers/line/insert_line_chat.php')->only('auth');
$router->post('/getlinemsg', 'controllers/line/getlinemsg.php')->only('auth');

// ---------------------------------------------SETTING-----------------------------------------
$router->get('/setting', 'controllers/setting/setting.php')->only('auth');
$router->post('/addlineoa', 'controllers/setting/addlineOA.php');

// ---------------------------------------------Q&A-----------------------------------------
$router->get('/delQA', 'controllers/QnA/delete.php')->only('auth');
$router->post('/addQA', 'controllers/QnA/add.php')->only('auth');
$router->post('/filterQA', 'controllers/QnA/filter.php')->only('auth');


// ---------------------------------------------DASHBOARD-----------------------------------------
$router->get('/dashboard', 'controllers/dashboard/show.php')->only('auth');
$router->get('/getdata', 'controllers/dashboard/getdata.php')->only('auth');

// ---------------------------------------------GROUP-----------------------------------------
$router->get('/creategroup', 'controllers/group/creategroup.php')->only('auth');
$router->post('/insertgroup', 'controllers/group/insertgroup.php');
$router->get('/chatgroup', 'controllers/group/chatgroup.php')->only('auth');