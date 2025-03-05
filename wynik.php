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
$code = $_GET['code'];
$userId = $_SESSION['uid'];

$selectSql = "SELECT * FROM `questions` WHERE testCode = '$code'";
$result = mysqli_query($conn, $selectSql);
$row_cnt = $result->num_rows;
for($i=0;$i<$row_cnt;$i++){
    $resultTab[$i] = $result->fetch_assoc();
}



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
        .code-container {
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
        .center-container {
            width: 80%;
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
        table {
            width: 80%;
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
        .correctAnswer{
            color: green;
        }
        .wrongAnswer{
            color: red;
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
        .a-back{
            width: 0;
            padding: 30px;
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
        <a class="a-logout" href="index.php" >Wyloguj</a>
    </div>
    
    <div class="code-container">
    <table>
        <thead>
            <tr>
                <th>Pytanie</th>
                <th>Twoja odpowiedź</th>
                <th>Prawidłowa odpowiedź</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $correct_cnt = 0;
            for($i=0;$i<$row_cnt;$i++){
                $question = $resultTab[$i]['question'];
                $correctAns = $resultTab[$i]['correctAnswer'];
                if(isset($_SESSION['checkedAnswers'][$i+1])){
                    $yourAns = $_SESSION['randomizedAnswers'][$i][$_SESSION['checkedAnswers'][$i+1]];
                }
                else{
                    $yourAns = "";
                }
                if($correctAns == $yourAns){
                    $isCorrect = true;
                    $correct_cnt += 1;
                }
                else{
                    $isCorrect = false;
                }
                if($isCorrect){
                echo "<tr class='correctAnswer'>";
                echo "<td>$question</td><td>$yourAns</td><td>$correctAns</td>";
                }
                else{
                echo "<tr class='wrongAnswer'>";
                echo "<td>$question</td><td>$yourAns</td><td>$correctAns</td>"; 
                }
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>
    </div>
    <div class="code-container">
            <h2>Twój wynik to 
                <?php
                    $correctPercent = round($correct_cnt/$row_cnt*100);
                    echo "$correct_cnt/$row_cnt ($correctPercent%)";
                ?>
            </h2>
            <a class="a-back" href="student.php"><div class="divButton">
                Wróć do menu
            </div></a>
    </div>

    <div id="bottom-bar">
        <div id="zdjul">
            <img src="ul_logo_new2.png" alt="logo UL">
        </div>
        <div id="napis">
            <p>Platforma egzaminacyjna Uniwersytetu Łódzkiego © 2024 3D PROJECT BLUE</p>
        </div>
    </div>

<?php
$selectQuery = "SELECT * FROM `results` WHERE `testCode`='$code' AND `userId`='$userId'";
$result = mysqli_query($conn, $selectQuery);
if ($result->num_rows == 0) {
    $insertQuery = "INSERT INTO `results` (`testCode`, `userId`, `numberOfGoodAnswers`) VALUES ('$code', '$userId', '$correct_cnt');";
    mysqli_query($conn,$insertQuery);
}

?>
</body>
</html>
