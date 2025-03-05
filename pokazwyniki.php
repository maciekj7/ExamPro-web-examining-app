<?php
session_start(); 
if ((!isset($_SESSION['logged'])) || ($_SESSION['logged'] == 0) || ($_SESSION['type']!='teacher')) {
    header("Location: index.php");
    exit();
}
if(isset($_GET['code'])){
    $code = $_GET['code'];
}
else{
    header("Location: sprawdzwyniki.php");
}
$servername = "localhost"; 
$username = "root"; 
$password = NULL ; 
$dbname = "exampro"; 
$conn = new mysqli($servername, $username, $password, $dbname);
$uid = $_SESSION['uid'];
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Wykładowca - PE UŁ</title>
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
            width: 1200px;
            background-color: #d9d9d9bf;
            border-radius: 30px;
            box-shadow: 0px 4px 4px #00000040;
            padding: 20px;
        }
        form {
            text-align: center;
        }
        
        .a-logout {
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
        
        input[type="button"], .divButton {
            width: 360px;
            background-color: red;
            color: white;
            border: none;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        input[type="button"]:hover, .divButton:hover {
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
            text-align: left;
        }
        table, th, tr, td{
            text-align: center;
        }
        th {
            background: linear-gradient(135deg, #e53935, #ff8a80);
            color: white;
            font-weight: bold;
            padding: 12px 15px;
            border-bottom: 2px solid #ddd;
        }
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }
        th:first-child {
            border-top-left-radius: 10px;
        }

        th:last-child {
            border-top-right-radius: 10px;
        }
        tr:last-child td:first-child {
            border-bottom-left-radius: 10px;
        }
        tr:last-child td:last-child {
            border-bottom-right-radius: 10px;
        }
        a {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        input[type="text"], input[type="number"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
            text-align: center;
        }
        td input[type="text"], td input[type="number"], td input[type="email"], td input[type="password"] {
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-align: center;
        }

        input[type="text"]:focus, input[type="number"]:focus, input[type="email"]:focus, input[type="password"]:focus {
            border-color: #e53935;
            outline: none;
            box-shadow: 0 0 5px rgba(229, 57, 53, 0.5);
            text-align: center;
        }
        input[type="submit"] {
            font-family: Tahoma;
            background: none;
            border: none;
            padding: 0;
            font-size: 18px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="top-bar">
        <div id="logo">
            <img src="ExamPro3.png" alt="logo">
        </div>
        <div>
            <h4>Użytkownik <?php echo $_SESSION['email'] ?></h4>
        </div>
        <a href="index.php" class="a-logout">Wyloguj</a>
    </div>
    
    <div id="code-container">
        <div id="center-container">
            <table class="testTable">
                <tr><th>Imię</th><th>Nazwisko</th><th>Numer indeksu</th><th>Wynik</th></tr>
        <?php
        $selectCount = "SELECT * FROM questions WHERE testCode = '$code'";
        $countResult = mysqli_query($conn, $selectCount);
		$countFetch = $countResult->fetch_assoc();
        $count = $countResult->num_rows;
        $selectSql = "SELECT * FROM results WHERE testCode = '$code' ORDER BY userId";
        $result = mysqli_query($conn, $selectSql);
        $row_cnt = $result->num_rows;
        for($i=0;$i<$row_cnt;$i++){
           $rowResults = $result->fetch_assoc();
           $id_ = $rowResults['userId'];
           $selectSql2 = "SELECT * FROM users WHERE id = '$id_'";
           $result2 = mysqli_query($conn, $selectSql2);
           
           $rowUsers = $result2->fetch_assoc();
           $fname = $rowUsers['firstName'];
           $lname = $rowUsers['lastName'];
           $indexNumber = $rowUsers['indexNumber'];
           $points = $rowResults['numberOfGoodAnswers'];
           $percent = $points/$count*100;
           echo "<tr>";
           echo "<td>$fname</td><td>$lname</td><td>$indexNumber</td><td>$points/$count ($percent%)</td>";
           echo "</tr>";
        }
        ?>
            </table>
            <a href="nauczyciel.php"><div class="divButton">
                Wróć do menu
            </div></a>
            <a href="sprawdzwyniki.php"><div class="divButton">
                Wróć do testów
            </div></a>

        </div>
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
