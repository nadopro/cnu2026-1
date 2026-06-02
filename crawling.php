<?php
$result = '';
$url = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookid = trim($_POST['bookid'] ?? '');
    $volume = trim($_POST['volume'] ?? '');
    $group  = trim($_POST['group'] ?? '');
    $no     = trim($_POST['no'] ?? '');

    $volume = str_pad($volume, 4, '0', STR_PAD_LEFT);
    $group  = str_pad($group, 3, '0', STR_PAD_LEFT);
    $no     = str_pad($no, 4, '0', STR_PAD_LEFT);

    $dataId = "{$bookid}_{$volume}_{$group}_{$no}";
    $url = "https://db.itkc.or.kr/dir/node?dataId=" . urlencode($dataId);

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERAGENT => 'Mozilla/5.0',
        CURLOPT_TIMEOUT => 20
    ]);

    $html = curl_exec($ch);

    if (curl_errno($ch)) {
        $result = '크롤링 오류: ' . curl_error($ch);
    } else {
        $result = $html;
    }

    curl_close($ch);
}
?>

<form method="post" action="index.php?cmd=crawling">
    <p>
        bookid :
        <input type="text" name="bookid" placeholder="ITKC_MO_1116A"
               value="<?= htmlspecialchars($_POST['bookid'] ?? '') ?>">
    </p>

    <p>
        volume :
        <input type="text" name="volume" placeholder="10"
               value="<?= htmlspecialchars($_POST['volume'] ?? '') ?>">
    </p>

    <p>
        group :
        <input type="text" name="group" placeholder="20"
               value="<?= htmlspecialchars($_POST['group'] ?? '') ?>">
    </p>

    <p>
        no :
        <input type="text" name="no" placeholder="30"
               value="<?= htmlspecialchars($_POST['no'] ?? '') ?>">
    </p>

    <button type="submit">크롤링 실행</button>
</form>

<?php if ($url): ?>
    <p>크롤링 주소: <?= htmlspecialchars($url) ?></p>
<?php endif; ?>

<textarea style="width:100%; height:500px;">
<?= htmlspecialchars($result) ?>
</textarea>