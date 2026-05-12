<?php
    /*
    $sql = "select * from std order by name asc";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($result);

    while($data)
    {
       echo "name = $data[name] , id = $data[id]<br>";
       $data = mysqli_fetch_array($result); 
    }
    */
 
    $sql = "SELECT * FROM std ORDER BY name ASC";
    $result = mysqli_query($conn, $sql);
?>

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>번호</th>
            <th>이름</th>
            <th>학번</th>
            <th>생년월일</th>
            <th>메모</th>
            <th>등록시간</th>
        </tr>
    </thead>
    <tbody>

    <?php
    while($row = mysqli_fetch_array($result))
    {
    ?>
        <tr>
            <td><?= $row['idx'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['id'] ?></td>
            <td><?= $row['birth'] ?></td>
            <td><?= $row['memo'] ?></td>
            <td><?= $row['time'] ?></td>
        </tr>
    <?php
    }
    ?>

    </tbody>
</table>
