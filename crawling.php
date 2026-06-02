<?php

$title = '';
$content = '';
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
    $url = "https://db.itkc.or.kr/dir/node?dataId={$dataId}";

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERAGENT => 'Mozilla/5.0',
        CURLOPT_TIMEOUT => 30
    ]);

    $html = curl_exec($ch);

    if (curl_errno($ch)) {
        $result = '크롤링 오류: ' . curl_error($ch);
    } else {
        $result = $html;

        libxml_use_internal_errors(true);

        $dom = new DOMDocument();
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);

        $xpath = new DOMXPath($dom);

        // 제목 추출
        $titleNode = $xpath->query(
            "//div[contains(concat(' ', normalize-space(@class), ' '), ' text_body_tit ')]//h4"
        );

        if ($titleNode->length > 0) {
            $title = trim($titleNode->item(0)->textContent);
            $title = preg_replace('/\s+/', ' ', $title);
        }

        // 내용 추출
        $bodyNode = $xpath->query(
            "//div[contains(concat(' ', normalize-space(@class), ' '), ' text_body ') 
              and contains(concat(' ', normalize-space(@class), ' '), ' ori ')]"
        );

        if ($bodyNode->length > 0) {

            $bodyHtml = '';

            foreach ($bodyNode->item(0)->childNodes as $child) {
                $bodyHtml .= $dom->saveHTML($child);
            }

            // br 태그를 줄바꿈으로 변환
            $bodyHtml = preg_replace('/<br[^>]*>/i', "\n", $bodyHtml);

            // img 태그 제거
            $bodyHtml = preg_replace('/<img[^>]*>/i', '', $bodyHtml);

            // 나머지 HTML 태그 제거
            $content = strip_tags($bodyHtml);

            // HTML 엔티티 변환
            $content = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');

            // 줄 단위 공백 정리
            $lines = explode("\n", $content);
            $lines = array_map('trim', $lines);
            $lines = array_filter($lines, function ($line) {
                return $line !== '';
            });

            $content = implode("\n", $lines);
        }

        libxml_clear_errors();
    }

    curl_close($ch);
}
?>

<div class="container-fluid">

    <div class="card shadow-sm mb-3">
        <div class="card-header">
            한국고전종합DB 크롤링
        </div>

        <div class="card-body">
            <form method="post" action="index.php?cmd=crawling">

                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">bookid</label>
                        <input
                            type="text"
                            name="bookid"
                            class="form-control"
                            placeholder="ITKC_MO_1116A"
                            value="<?= htmlspecialchars($_POST['bookid'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">volume</label>
                        <input
                            type="text"
                            name="volume"
                            class="form-control"
                            placeholder="10"
                            value="<?= htmlspecialchars($_POST['volume'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">group</label>
                        <input
                            type="text"
                            name="group"
                            class="form-control"
                            placeholder="20"
                            value="<?= htmlspecialchars($_POST['group'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">no</label>
                        <input
                            type="text"
                            name="no"
                            class="form-control"
                            placeholder="30"
                            value="<?= htmlspecialchars($_POST['no'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            크롤링 실행
                        </button>
                    </div>

                </div>

            </form>
        </div>
    </div>

    <?php if ($url): ?>

        <div class="alert alert-light border">
            <strong>크롤링 주소</strong><br>
            <?= htmlspecialchars($url, ENT_QUOTES, 'UTF-8') ?>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-header">
                크롤링 원본 전체
            </div>

            <div class="card-body">
                <textarea class="form-control" rows="15"><?= htmlspecialchars($result, ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-header">
                추출 결과
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label fw-bold">제목</label>
                    <input
                        type="text"
                        class="form-control"
                        value="<?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>"
                        readonly>
                </div>

                <div>
                    <label class="form-label fw-bold">내용</label>
                    <textarea class="form-control" rows="18" readonly><?= htmlspecialchars($content, ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>

            </div>
        </div>

    <?php endif; ?>

</div>