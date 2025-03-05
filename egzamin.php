<?php
session_start();
if ((!isset($_SESSION['logged'])) || ($_SESSION['logged'] == 0) || ($_SESSION['type']!='student')) {
    header("Location: index.php");
    exit();
}
$code = $_SESSION['code'];

$selectTime = "SELECT time FROM tests WHERE code='$code'";

if(isset($_GET['page'])){
    $_SESSION['numerator']=$_GET['page'];
}
else{
    $_SESSION['numerator'] = 1;
    $_SESSION['checkedAnswers'] = NULL;
    $_SESSION['randomizedAnswers'] = NULL;
    unset($_SESSION['randomizedAnswers']);
    $_SESSION['czasM'] = NULL;
    $_SESSION['czasS'] = NULL;
    unset($_SESSION['czasM']);
    unset($_SESSION['czasS']);
}   
$numerator=$_SESSION['numerator'];
$prev=$_SESSION['numerator']-1;
$next=$_SESSION['numerator']+1;

$checkedOnThisPage = $_SESSION['checkedAnswers'][$numerator] ?? NULL;

$servername = "localhost"; 
$username = "root"; 
$password = NULL ; 
$dbname = "exampro"; 
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$resultTime = mysqli_query($conn, $selectTime);
$rowTime = $resultTime->fetch_assoc();
$timeM = $rowTime['time'];
$timeS = 0;

if(isset($_POST['czasM'])){
    $_SESSION['czasM'] = $_POST['czasM'];
    $_SESSION['czasS'] = $_POST['czasS'];
    $timeM = $_POST['czasM'];
    $timeS = $_POST['czasS'];
}

if(isset($_SESSION['czasM'])){
    $timeM = $_SESSION['czasM'];
    $timeS = $_SESSION['czasS'];
}

$userId = $_SESSION['uid'];
$selectQuery = "SELECT * FROM `results` WHERE `testCode`='$code' AND `userId`='$userId'";
$result = mysqli_query($conn, $selectQuery);
if ($result->num_rows > 0) {
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
        a {
            color: black;
            text-decoration: none;
            cursor: pointer;
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
    
    <div id="code-container">
        <div>
            <h2>Już rozwiązywałeś ten test</h2>
        </div>
    </div>
    <div id="code-container">
            <a href="student.php"><div class="divButton">
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
</body>
</html>
<?php
}
else{


$selectSql = "SELECT * FROM `questions` WHERE testCode = '$code'";
$result = mysqli_query($conn, $selectSql);
$row_cnt = $result->num_rows;
for($i=0;$i<$row_cnt;$i++){
    $resultTab[$i] = $result->fetch_assoc();
}

if(!isset($_SESSION['randomizedAnswers'])){
    for($j=0;$j<$row_cnt;$j++){
        $index = NULL;
        $checked = [];
        for ($i=0; $i<4; $i++) {
            $index = rand(1, 4);
            while(in_array($index, $checked)){
                $index = rand(1, 4);
            }
            $checked[] = $index;
            $indexes[$j][$i] = $index;
        }
    }
    
    for($i=0;$i<$row_cnt;$i++){
        $answers[$i][$indexes[$i][0]] = $resultTab[$i]['correctAnswer'];
        $answers[$i][$indexes[$i][1]] = $resultTab[$i]['wrongAnswer1'];
        $answers[$i][$indexes[$i][2]] = $resultTab[$i]['wrongAnswer2'];
        $answers[$i][$indexes[$i][3]] = $resultTab[$i]['wrongAnswer3'];    
    }
    $_SESSION['randomizedAnswers'] = $answers;

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
        
        #bottom-bar {
            height: 40px;
            background-color: #d9d9d9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: relative;
        }
        
        form {
            text-align: center;
        }

        #task-container {
            background-color: rgba(245, 245, 245);
            box-shadow: 0px 4px 4px #00000040;
            padding: 20px;
            border-radius: 10px;
            margin: 20px auto; 
            width: 60%; 
            position: relative; 
            text-align: center; 
            flex: 1; 
            display: flex;
            flex-direction: column;
        }

        .answer-button {
            background-color: red;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: block; 
            font-size: 16px;
            margin: 5px auto; 
            cursor: pointer;
            border-radius: 8px;
            width: 70%; 
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

        .arrow-button, .end-exam-button {
            background-color: red;
            border: none;
            color: white;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 20px;
            cursor: pointer;
            border-radius: 5px;
            padding: 10px 15px;
            position: absolute; 
            bottom: 20px; 
        }

        .arrow-button:hover, .answer-button:hover, .end-exam-button:hover, .answer-button-checked {
            background-color: darkred; 
        }

        #left-arrow {
            left: 10px; 
        }

        #right-arrow {
            right: 10px; 
        }

        #end-exam {
            left: 50%;
            transform: translateX(-50%);
        }

        #jaki-przedmiot {
            margin-bottom: 5px;
            font-family: Tahoma;
            text-align: center;
        }

        #czas {
            margin-bottom: 10px;
            font-family: Tahoma;
            font-weight: 100;
            text-align: right;
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
    <script> 
        function startTimer(duration, display) {
            var timer = duration, minutes, seconds;
            setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;
                document.getElementById('czasM_now').value = minutes;
                document.getElementById('czasS_now').value = seconds;
                if(minutes == 0 && seconds == 0){
                    document.getElementById("theForm").submit();
                }

                if (--timer < 0) {
                    timer = duration;
                }
            }, 1000);
        }

        window.onload = function () {
            var czas = parseInt(document.getElementById('czasM').value) * 60 + parseInt(document.getElementById('czasS').value), 
                display = document.querySelector('#timer');
            startTimer(czas, display);
        };
    </script>
</head>
<body>
    <input type='hidden' id='getCheckedValue' value=<?php echo $checkedOnThisPage ?> >
    <input type='hidden' id='czasM' value="<?php echo $timeM; ?>" id="czasM">
    <input type='hidden' id='czasS' value="<?php echo $timeS; ?>" id="czasS">
    <div id="top-bar">
        <div id="logo">
            <img src="ExamPro3.png" alt="logo">
        </div>
        <div>
            <h4>Użytkownik <?php echo $_SESSION['email'] ?></h4>
        </div>
        <a href="index.php" class="a-logout" >Wyloguj</a>
    </div>
    
    <div id="task-container">
        <h3 id="jaki-przedmiot">Egzamin</h3>
        <h5 id="czas">Pozostały czas <span id="timer"></span>  </h5>
        <p><?php echo $resultTab[$_SESSION['numerator']-1]['question']?></p>
        <button class="answer-button" onclick="buttonClicked(1)"><?php echo $_SESSION['randomizedAnswers'][$numerator-1][1]; ?></button>
        <button class="answer-button" onclick="buttonClicked(2)"><?php echo $_SESSION['randomizedAnswers'][$numerator-1][2]; ?></button>
        <button class="answer-button" onclick="buttonClicked(3)"><?php echo $_SESSION['randomizedAnswers'][$numerator-1][3]; ?></button>
        <button class="answer-button" onclick="buttonClicked(4)"><?php echo $_SESSION['randomizedAnswers'][$numerator-1][4]; ?></button>
        <div style="margin-top: 50px;"> 
            <form method="POST" action="pageProcess.php" id="theForm">
                <input type='hidden' value=<?php echo $code; ?> name='code'>
                <button class="end-exam-button" id="end-exam" name='action' value='end'>Zakończ egzamin</button>
        </div>
        <input type="hidden" name="odpowiedz" id="odp" value=<?php echo $checkedOnThisPage; ?>>
        <input type="hidden" name="czasM_now" id="czasM_now">
        <input type="hidden" name="czasS_now" id="czasS_now">
        <?php
        if($prev>0){
    echo "<button class='arrow-button' id='left-arrow' name='action' value='prevPage'>&#9664;</button>";
        }
        if($next<=$row_cnt){
        echo "<a href='?page=$next'>
        <button class='arrow-button' id='right-arrow' name='action' value='nextPage'>&#9654;</button>
    </a>";
    }
    ?>
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
    <script>
        var allButtons = document.querySelectorAll("button");
        var checked = document.getElementById("getCheckedValue").value-1;
        for(let i=0; i<4; i++){
            if(i==checked){
                allButtons[i].classList.add('answer-button-checked');
            }
        }
        function buttonClicked(which){
            const buttons = document.querySelectorAll("button");
            for(let i=0; i<4; i++){
                buttons[i].classList.remove('answer-button-checked');
            }
            buttons[which-1].classList.add('answer-button-checked');
            const odpowiedz = document.getElementById('odp');
            odpowiedz.value = which;
        }

    </script>
    <?php
    }
?>
</body>
</html>

