<?php

    $name = $_SESSION["cnuname"];
    session_destroy();

    echo "
    <script>
        alert('$name 님 로그아웃되었습니다.');
        location.href='index.php';
    </script>
    ";


    $name = $_SESSION["cnuname"];
    session_destroy();

    echo "
    <script>
        alert('$name 님 로그아웃되었습니다.');
        location.href='index.php';
    </script>
    ";

?>