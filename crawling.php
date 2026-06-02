<?php

$rawResult = '';
$outputText = '';
$startUrl = '';
$collectedCount = 0;

function fetchHtml($url)
{
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
        $html = false;
    }

    curl_close($ch);

    return $html;
}

function extractTitleAndContent($html)
{
    $title = '';
    $content = '';

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

        $bodyHtml = preg_replace('/<br[^>]*>/i', "\n", $bodyHtml);
        $bodyHtml = preg_replace('/<img[^>]*>/i', '', $bodyHtml);

        $content = strip_tags($bodyHtml);
        $content = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $lines = explode("\n", $content);
        $lines = array_map('trim', $lines);
        $lines = array_filter($lines, function ($line) {
            return $line !== '';
        });

        $content = implode("\n", $lines);
    }

    libxml_clear_errors();

    return [
        'title' => $title,
        'content' => $content
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $bookid = trim($_POST['bookid'] ?? '');
    $volume = trim($_POST['volume'] ?? '');
    $group  = trim($_POST['group'] ?? '');
    $no     = trim($_POST['no'] ?? '');

    $volumeNum = (int)$volume;
    $groupNum  = (int)$group;
    $noNum     = (int)$no;

    $volumeText = str_pad($volumeNum, 4, '0', STR_PAD_LEFT);
    $groupText  = str_pad($groupNum, 3, '0', STR_PAD_LEFT);

    $maxLoop = 300;

    for ($i = 0; $i < $maxLoop; $i++) {

        $currentNo = $noNum + ($i * 10);
        $noText = str_pad($currentNo, 4, '0', STR_PAD_LEFT);

        $dataId = "{$bookid}_{$volumeText}_{$groupText}_{$noText}";
        $url = "https://db.itkc.or.kr/dir/node?dataId={$dataId}";

        if ($i === 0) {
            $startUrl = $url;
        }

        $html = fetchHtml($url);

        if ($html === false || trim($html) === '') {
            break;
        }

        if ($i === 0) {
            $rawResult = $html;
        }

        $extracted = extractTitleAndContent($html);

        $title = $extracted['title'];
        $content = $extracted['content'];

        // 제목과 내용이 모두 없으면 결과 없음으로 판단하고 종료
        if ($title === '' && $content === '') {
            break;
        }

        $outputText .= "URL : {$url}\n";
        $outputText .= "제목 : {$title}\n";
        $outputText .= "내용 : \n{$content}\n\n";
        $outputText .= "------------------------------------------------------------\n\n";

        $collectedCount++;
    }
}
?>

<div class="container-fluid">

    <div class="card shadow-sm mb-3">
        <div class="card-header">
            한국고전종합DB 반복 크롤링
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
                            반복 크롤링
                        </button>
                    </div>

                </div>

            </form>
        </div>
    </div>

    <?php if ($startUrl): ?>

        <div class="alert alert-light border">
            <strong>시작 URL</strong><br>
            <?= htmlspecialchars($startUrl, ENT_QUOTES, 'UTF-8') ?>
            <br>
            <strong>수집 건수</strong> :
            <?= number_format($collectedCount) ?>건
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-header">
                수집 결과
            </div>

            <div class="card-body">
                <textarea
                    class="form-control w-100"
                    style="width:100%; min-height:700px; white-space:pre-wrap;"
                    rows="30"><?= htmlspecialchars($outputText, ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-header">
                첫 번째 크롤링 원본 HTML
            </div>

            <div class="card-body">
                <textarea
                    class="form-control w-100"
                    style="width:100%; min-height:400px;"
                    rows="20"><?= htmlspecialchars($rawResult, ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>
        </div>

    <?php endif; ?>

</div>