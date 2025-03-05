<?php
session_start();

if ((!isset($_SESSION['logged'])) || ($_SESSION['logged'] == 0) || ($_SESSION['type']!='student')) {
    header("Location: index.php");
    exit();
}

$servername = "localhost"; 
$username = "root"; 
$password = NULL ; 
$dbname = "exampro"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Code = $_POST['Code'];

    $stmt = $conn->prepare("SELECT code FROM tests WHERE code = ?");
    $stmt->bind_param("s", $Code);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['code'] = $Code; 
        $stmt->close();
        $conn->close();
        header("Location: egzamin.php");
        exit();
    } else {
        $stmt->close();
        $conn->close();
        header("Location: student.php");
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>

    <title>Student - PE UŁ</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Tahoma;
            background-image: url("rektorat2.png"); 
            background-size: cover; 
            display: flex;
            flex-direction: column;
            min-height: 99.8vh; 
        }
        #top-bar {
            height: 80px;
            background-color: red;
            display: flex;
            align-items: center;
            padding: 0 20px;
        }
        #code-container {
            flex: 1; 
            display: flex;
            justify-content: center;
            align-items: center;
        }
        #bottom-bar {
            height: 40px;
            background-color: #d9d9d9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }
        #center-container {
            width: 400px;
            background-color: #d9d9d9bf;
            border-radius: 30px;
            box-shadow: 0px 4px 4px #00000040;
            padding: 20px;
        }
        form {
            text-align: center;
        }
        
        a {
            color: black;
            text-decoration: none;
            padding: 10px 10px;
            cursor: pointer;
            font-family: Tahoma;
            font-weight: 300;
            font-size: medium;
            border-radius: 10px; 
            background-color: white; 
            position: absolute;
            right: 20px;
        }
        
        a:hover {
            background-color: #f1f1f1; 
        }
        
        #zdjul {
            padding-left: 20px;
        }
        
        h2 {
            margin-bottom: 20px;
            font-family: Tahoma;
            font-weight: 100;
        }

        h4 {
            font-family: Tahoma;
            font-weight: 100;
            color: white;
            text-align: right;
            position: absolute;
            top: 10px;
            right: 120px;
        }
        
        input[type="text"] {
            width: calc(100% - 40px); 
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 10px;
            box-sizing: border-box;
            outline: none; 
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
        #napis {
            font-family: Tahoma;
            font-size: 9px;
            color: white;
             margin-left: 20px; 
             margin-right: 20px; 
             flex: 1; 
             text-align: right;
        }
        
    </style>
</head>
<body>
    <div id="top-bar">
        <div id="logo">
            <img src="ExamPro3.png" alt="logo">
        </div>
        <div>  
            <h4> Użytkownik <?php echo $_SESSION['email'] ?> </h4>  
        </div>
        <a href="index.php" >Wyloguj</a>
    </div>
    
    <div id="code-container">
        <form method="post" id="center-container">
            <h2>Wpisz kod egzaminu</h2>
            <input type="text" id="Code" name="Code" placeholder="Kod" required><br>
            <input type="submit" value="➝">
        </form>
    </div>

    <div id="bottom-bar">
        <div id="zdjul">
            <img src="ul_logo_new2.png" alt="logo UL">
        </div>
        <div id="napis">
            <p>Platforma egzaminacyjna Uniwersytetu Łódzkiego © 2024 3D PROJECT BLUE</p>
        </div>
    </div>


</body>
</html>
