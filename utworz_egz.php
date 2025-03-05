<?php
session_start(); 
if ((!isset($_SESSION['logged'])) || ($_SESSION['logged'] == 0) || ($_SESSION['type']!='teacher')) {
    header("Location: index.php");
    exit();
}

if(!isset($_SESSION['numerator'])){
    $_SESSION['numerator'] = 1;
}
if(isset($_GET['page'])){
    $_SESSION['numerator']=$_GET['page'];
}

$prev=$_SESSION['numerator']-1;
$next=$_SESSION['numerator']+1;

if(isset($_POST['tresc'])){
    $pytania = $_SESSION['pytania'] ?? NULL;
    $pytania[$_SESSION['numerator']]['tresc'] = $_POST['tresc'];
    $pytania[$_SESSION['numerator']]['prawOdp'] = $_POST['prawOdp'];
    $pytania[$_SESSION['numerator']]['zlaOdp1'] = $_POST['zlaOdp1'];
    $pytania[$_SESSION['numerator']]['zlaOdp2'] = $_POST['zlaOdp2'];
    $pytania[$_SESSION['numerator']]['zlaOdp3'] = $_POST['zlaOdp3'];
    $_SESSION['pytania'] = $pytania;
}
if(isset($_POST['kod'])){
    $kod = $_POST['kod'];
    $_SESSION['kod'] = $kod;
}
if(isset($_SESSION['kod'])){
$kod = $_SESSION['kod'];
}
if(isset($_POST['nazwa'])){
    $nazwa = $_POST['nazwa'];
    $_SESSION['nazwa'] = $nazwa;
}
if(isset($_SESSION['nazwa'])){
$nazwa = $_SESSION['nazwa'];
}

if(isset($_POST['czas'])){
    $czas = $_POST['czas'];
    $_SESSION['czas'] = $czas;
}
if(isset($_SESSION['czas'])){
$czas = $_SESSION['czas'];
}

$pytania = $_SESSION['pytania'] ?? NULL;

if(isset($_GET['del'])){
    $_SESSION['pytania'][$_SESSION['numerator']] = NULL;
    unset($_SESSION['pytania'][$_SESSION['numerator']]);
    $pytania[$_SESSION['numerator']] = NULL;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Utwórz egzamin - PE UŁ</title>
    <meta charset="utf-8">
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
            justify-content: center;
            align-items: center;
        }
        a {
            cursor: pointer;
            text-decoration: none;
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

        .arrow-button {
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
            margin: 5px; 
        }

        .function-button{
            background-color: red;
            border: none;
            color: white;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 15px;
            cursor: pointer;
            border-radius: 5px;
            padding: 10px 15px;
        }
        .buttonForm{
            background-color: red;
            border: none;
            color: white;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 15px;
            cursor: pointer;
            border-radius: 5px;
            margin: 5px; 
        }

        .arrow-button:hover, .function-button:hover {
            background-color: darkred; 
        }

        #left-arrow {
            position: absolute;
            left: 10px; 
            bottom: 20px;
        }

        #right-arrow {
            position: absolute;
            right: 10px; 
            bottom: 20px;
        }

        #jaki-przedmiot {
            margin-bottom: 5px;
            font-family: Tahoma;
            text-align: left;
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
        /*input[type="submit"] {
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
        }*/
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
        <h4>Użytkownik <?php echo $_SESSION['email'] ?></h4>
        </div>
        <a href="index.php" class='a-logout' >Wyloguj</a>
    </div>
    
    <div id="task-container">
        <div style="text-align: center;">
        <form method="POST" action="">
            <h3 style="display: inline-block;">Nowy egzamin</h3>
            <input type="text" <?php 
            if(isset($kod)){echo "value='$kod'";}else echo "placeholder='Kod egzaminu'"; ?> style="width: 25%; display: inline-block; margin-left: 10px;" name='kod' required>
            <input type="text" <?php 
            if(isset($nazwa)){echo "value='$nazwa'";}else echo "placeholder='Nazwa egzaminu'"; ?> style="width: 40%; display: inline-block; margin-left: 10px;" name='nazwa' required>
            <input type="number" <?php 
            if(isset($czas)){echo "value='$czas'";}else echo "placeholder='Czas (min)'"; ?> min='1' max='60' style="width:12%; display: inline-block; margin-left: 10px;" name='czas' required>
        </div>
        <p>Pytanie <?php echo $_SESSION['numerator']?></p>
        
        <input type="text" <?php
            if(isset($pytania[$_SESSION['numerator']])){
                echo "value='";
                echo $pytania[$_SESSION['numerator']]['tresc'];
                echo "'";
            }
            else {
                echo "placeholder='Treść'";
            }
        ?> name="tresc" required>
        <input type="text" <?php
            if(isset($pytania[$_SESSION['numerator']])){
                echo "value='";
                echo $pytania[$_SESSION['numerator']]['prawOdp'];
                echo "'";
            }
            else {
                echo "placeholder='Prawidłowa odpowiedź'";
            }
        ?> name="prawOdp" required>
        <input type="text" <?php
            if(isset($pytania[$_SESSION['numerator']])){
                echo "value='";                
                echo $pytania[$_SESSION['numerator']]['zlaOdp1'];
                echo "'";
            }
            else {
                echo "placeholder='Nieprawidłowa odpowiedź'";
            }
        ?> name="zlaOdp1" required>
        <input type="text" <?php
            if(isset($pytania[$_SESSION['numerator']])){
                echo "value='";
                echo $pytania[$_SESSION['numerator']]['zlaOdp2'];
                echo "'";
            }
            else {
                echo "placeholder='Nieprawidłowa odpowiedź'";
            }
        ?> name="zlaOdp2" required>
        <input type="text" <?php
            if(isset($pytania[$_SESSION['numerator']])){
                echo "value='";
                echo $pytania[$_SESSION['numerator']]['zlaOdp3'];
                echo "'";
            }
            else {
                echo "placeholder='Nieprawidłowa odpowiedź'";
            }
        ?> name="zlaOdp3" required>
        <div style="margin-top: 50px;">
            <a href="nauczyciel.php"><div class="function-button">Wróć do menu</div></a>
            <a href="egzamin_podsumowanie.php"><div class="function-button">Zapisz egzamin</div></a>
            <input type="submit" value="Zapisz pytanie" class="function-button">
            <a href="utworz_egz.php?del=1"><div class="function-button">Usuń pytanie</div></a>
        </form>
        </div>
        <?php
        if($prev>0){
    echo "<a href='?page=$prev'>
        <button class='arrow-button' id='left-arrow'>&#9664;</button>
        </a>";
        }
        echo "<a href='?page=$next'>
        <button class='arrow-button' id='right-arrow'>&#9654;</button>
    </a>";
    ?>
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