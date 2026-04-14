<?php
    $sql ="select * from users order by name asc";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($result);

    while($data)
    {
        echo "id : $data[id] , name : $data[name] <br>";
        $data = mysqli_fetch_array($result);
    }
?>