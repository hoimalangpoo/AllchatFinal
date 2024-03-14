<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>รวมแชท</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <?php require base_path('views/navbar/navbar.php'); ?>
</head>

<body>
<h1>Forgot Password</h1>

<form method="post" action="/sendpass-reset">

    <label for="email">email</label>
    <input type="email" name="email" id="email">

    <button>Send</button>

</form>


    <script src="js/bootstrap.esm.min.js"></script>

</body>


<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    body {
        background-image: url(ภาพ/background.jpg);
    }
    h1 {
        text-align: center;
        margin-top: 5rem;
    }
    form {
        text-align: center;
        margin-top: 2rem;
    }
    
</style>

</html>