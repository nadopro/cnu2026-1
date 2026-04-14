<?php
    // id, pass
    $id = $_POST["id"];
    $pass = $_POST["pass"];

    if($id == "admin" and $pass=="1111")
    {
        $_SESSION["cnuid"] = $id;
        $_SESSION["cnuname"] = "관리자";
        $_SESSION["cnulevel"] = 9;
        $msg = "관리자님 반갑습니다.";
    } else if($id == "test" and $pass=="1111")
    {
        $_SESSION["cnuid"] = $id;
        $_SESSION["cnuname"] = "홍길동";
        $_SESSION["cnulevel"] = 1;
        $msg = "홍길동님 반갑습니다.";
    }else
    {
        $msg = "아이디와 비밀번호를 확인하세요";
    }

    echo "
    <script>
        alert('$msg');
        location.href='index.php';
    </script>
    ";
?>