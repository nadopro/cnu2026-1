<?php

$mode = $_POST['mode'] ?? '';
$edit_idx = $_GET['edit_idx'] ?? '';

$name = '';
$id = '';
$birth = '';
$memo = '';

// 등록
if ($mode == 'insert') {
    $name = $_POST['name'];
    $id = $_POST['id'];
    $birth = $_POST['birth'];
    $memo = $_POST['memo'];

    $sql = "INSERT INTO std (name, id, birth, memo, time)
            VALUES ('$name', '$id', '$birth', '$memo', NOW())";

    mysqli_query($conn, $sql);

    echo "<script>location.href='index.php?cmd=dbtest';</script>";
    exit;
}

// 수정 저장
if ($mode == 'update') {
    $idx = $_POST['idx'];
    $name = $_POST['name'];
    $id = $_POST['id'];
    $birth = $_POST['birth'];
    $memo = $_POST['memo'];

    $sql = "UPDATE std
            SET name='$name',
                id='$id',
                birth='$birth',
                memo='$memo'
            WHERE idx=$idx";

    mysqli_query($conn, $sql);

    echo "<script>location.href='index.php?cmd=dbtest';</script>";
    exit;
}

// 삭제
if ($mode == 'delete') {
    $idx = $_POST['idx'];

    $sql = "DELETE FROM std WHERE idx=$idx";
    mysqli_query($conn, $sql);

    echo "<script>location.href='index.php?cmd=dbtest';</script>";
    exit;
}

// 수정할 데이터 불러오기
if ($edit_idx != '') {
    $sql = "SELECT * FROM std WHERE idx=$edit_idx";
    $result = mysqli_query($conn, $sql);
    $edit = mysqli_fetch_array($result);

    $name = $edit['name'];
    $id = $edit['id'];
    $birth = $edit['birth'];
    $memo = $edit['memo'];
}

?>

<h3 class="mb-3">
    <?php if ($edit_idx != '') { ?>
        학생 정보 수정
    <?php } else { ?>
        학생 정보 등록
    <?php } ?>
</h3>

<form method="post" action="index.php?cmd=dbtest" class="mb-4">
    <?php if ($edit_idx != '') { ?>
        <input type="hidden" name="mode" value="update">
        <input type="hidden" name="idx" value="<?= $edit_idx ?>">
    <?php } else { ?>
        <input type="hidden" name="mode" value="insert">
    <?php } ?>

    <div class="row mb-2">
        <div class="col-md-3">
            <input type="text" name="name" class="form-control" placeholder="이름" value="<?= $name ?>" required>
        </div>

        <div class="col-md-3">
            <input type="text" name="id" class="form-control" placeholder="학번" value="<?= $id ?>" required>
        </div>

        <div class="col-md-3">
            <input type="date" name="birth" class="form-control" value="<?= $birth ?>" required>
        </div>

        <div class="col-md-3">
            <?php if ($edit_idx != '') { ?>
                <button type="submit" class="btn btn-primary w-100">수정 저장</button>
            <?php } else { ?>
                <button type="submit" class="btn btn-success w-100">등록</button>
            <?php } ?>
        </div>
    </div>

    <div class="mb-2">
        <textarea name="memo" class="form-control" rows="3" placeholder="메모"><?= $memo ?></textarea>
    </div>

    <?php if ($edit_idx != '') { ?>
        <a href="index.php?cmd=dbtest" class="btn btn-secondary">수정 취소</a>
    <?php } ?>
</form>

<h3 class="mb-3">학생 목록</h3>

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>번호</th>
            <th>이름</th>
            <th>학번</th>
            <th>생년월일</th>
            <th>메모</th>
            <th>등록시간</th>
            <th>비고</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM std ORDER BY name ASC";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_array($result)) {
        ?>
            <tr>
                <td><?= $row['idx'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['id'] ?></td>
                <td><?= $row['birth'] ?></td>
                <td><?= $row['memo'] ?></td>
                <td><?= $row['time'] ?></td>
                <td>
                    <a href="index.php?cmd=dbtest&edit_idx=<?= $row['idx'] ?>" class="btn btn-sm btn-primary">
                        수정
                    </a>

                    <form method="post" action="index.php?cmd=dbtest" style="display:inline;"
                          onsubmit="return confirm('정말 삭제하시겠습니까?');">
                        <input type="hidden" name="mode" value="delete">
                        <input type="hidden" name="idx" value="<?= $row['idx'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger">삭제</button>
                    </form>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>