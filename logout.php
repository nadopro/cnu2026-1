<<<<<<< HEAD
<?php

    $name = $_SESSION["cnuname"];
    session_destroy();

    echo "
    <script>
        alert('$name 님 로그아웃되었습니다.');
        location.href='index.php';
    </script>
    ";
=======
<?php

    $name = $_SESSION["cnuname"];
    session_destroy();

    echo "
    <script>
        alert('$name 님 로그아웃되었습니다.');
        location.href='index.php';
    </script>
    ";
>>>>>>> afc90b617808e6eb78f1559b227daa1be6e27b6f
?>