<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $numerator = $_SESSION['numerator'];
        $next = $numerator+1;
        $prev = $numerator-1;

        $_SESSION['checkedAnswers'][$numerator] = $_POST['odpowiedz']; 
        $_SESSION['czasM'] = $_POST['czasM_now'];
        $_SESSION['czasS'] = $_POST['czasS_now'];

        switch ($action) {
            case 'prevPage':
                header("Location: egzamin.php?page=$prev");
                exit();
            case 'nextPage':
                header("Location: egzamin.php?page=$next");
                exit();
            case 'end':
                $code = $_POST['code'];
                header("Location: wynik.php?code=$code");
                exit();
            default:
                break;
        }
    }
    $code = $_POST['code'];
    header("Location: wynik.php?code=$code");
    exit();
}
?>