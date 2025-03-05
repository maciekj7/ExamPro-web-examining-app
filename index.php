<?php
$servername = "localhost"; 
$username = "root"; 
$password = NULL ; 
$dbname = "exampro"; 
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start(); 
$_SESSION['logged']=false;
$_SESSION['email'] = NULL;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];


    $sql = "SELECT * FROM users WHERE email = '$login' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['logged'] = true; 
        $_SESSION['email'] = $login;
        $_SESSION['uid'] = $row['id'];

        if ($row['type'] == 'student') {
            $_SESSION['type'] = 'student';
            header("Location: student.php"); 
        } elseif ($row['type'] == 'teacher') {
            $_SESSION['type'] = 'teacher';
            header("Location: nauczyciel.php"); 
        } else {
            header("Location: index.php");
        }
    } else {
        
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Zaloguj - PE UŁ</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Tahoma;
            background-image: url("rektorat.png"); 
            background-size: cover;
            display: flex;
            flex-direction: column;
            min-height: 100vh; 
        }
        #top-bar {
            height: 100px;
            background-color: red;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }
        #login-container {
            flex: 1; 
            display: flex;
            justify-content: center;
            align-items: center;
        }
        #bottom-bar {
            height: 80px;
            background-color: #d9d9d9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
        }
        #loginForm {
            width: 400px;
            background-color: #d9d9d9bf;
            border-radius: 30px;
            box-shadow: 0px 4px 4px #00000040;
            padding: 20px;
        }
        form {
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            font-family: Tahoma;
            font-weight: 100; 
        }
        input[type="submit"] {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 26px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        input[type="submit"]:hover {
            background-color: darkred;
        }
        input[type="text"],
        input[type="password"] {
            width: calc(100% - 40px);
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 10px;
            box-sizing: border-box;
            outline: none; 
        }
        #napis {
            font-family: Tahoma;
            font-size: 12px;
            color: white;
        }
    </style>
</head>
<body>
    <div id="top-bar">
        <div id="logo">
            <img src="ExamPro2.png" alt="logo">
        </div>
        <div id="language-dropdown">
            <select>
                <option value="pl">Polski</option>
                <option value="en">English</option>
            </select>
        </div>
    </div>

    <div id="login-container">
        <form id='loginForm' method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <h2>Login:</h2> 
            <input type="text" id="login" name="login" placeholder="Email" required><br>
            <input type="password" id="password" name="password" placeholder="Hasło" required><br>
            <input type="submit" value="➝">
        </form>
    </div>

    <div id="bottom-bar">
        <div id="zdjul">
            <img src="ul_logo_new.png" alt="logo UL">
        </div>
        <div id="napis">
            <p>Platforma egzaminacyjna Uniwersytetu Łódzkiego © 2024 3D PROJECT BLUE</p>
        </div>
    </div>


</body>
</html>
