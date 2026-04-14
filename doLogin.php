<?php
    // id, pass
    $id = $_POST["id"];
    $pass = $_POST["pass"];

    $sql = "select * from users where id='$id' and pass='$pass' ";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($result);

    if($data)
    {
        $_SESSION["cnuid"] = $id;
        $_SESSION["cnuname"] = $data["name"];
        $name = $data["name"];
        $_SESSION["cnulevel"] = $data["level"];
        $msg = "$name 님 반갑습니다.";
    } else
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