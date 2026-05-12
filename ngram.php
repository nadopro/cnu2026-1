<?php

$defaultText = "水旱果天數乎。果人事乎。堯湯未免。天數也。休咎有徵。人事也。古之人修人事以應天數。故有九七年之厄而民不病。後之人委天數而廢人事。故一二年之灾。而民已轉于溝壑矣。國家非惟省歲月日。且有儲備。人事可謂修矣。自去年之水旱而民甚病。多方救療之不得其要。何哉。甞聞之父老。曰移民移粟。食飢飮渴。僅足以紓目前之急。若欲因其已然之迹而防 a003_101b其未然之患。盍亦究其原。夫民之寄命者有司。凡有利害。必赴而訴之。若子於父母。然父母之於子。祛其害而已。豈計其利己乎。今之有司則不然。設二人爭訟。甲若有錢。乙便無理。其民安得不死寃。其氣安得不傷和乎。此所由召水旱也。監有司曰監司。凡有貪廉。卽按而誅賞之。監監司曰監察。凡有賢否。卽察而黜陟之。今皆不然。間有志古者。反不見容於時。盖今日之監司。卽前日監察。今日之監察。卽前日有司。相扳援相蔽覆。故如此。苟使今之民。一見古之有司。今之有司。一見古之監司。今之監司。一見古之監察則 a003_101c吾赤子庶免溝壑矣。然則天數也人事也。其要去貪而已。如欲去貪則有成憲具在。擧而行之。在乎宰天下者耳。作原水旱。";

// 영어, 숫자, 밑줄 제거
$defaultText = preg_replace('/[A-Za-z0-9_]/u', '', $defaultText);

$text = $_POST['text'] ?? $defaultText;

$oneGram = [];
$twoGram = [];
$threeGram = [];

if ($text != '') {

    // 한글, 한자만 남기고 제거
    
    $cleanText = preg_replace('/[^\p{Hangul}\p{Han}]/u', '', $text);
    $cleanText = str_replace("。", "", $cleanText);
    // 음절 단위 분리
    preg_match_all('/./u', $cleanText, $matches);
    $chars = $matches[0];

    $count = count($chars);

    for ($i = 0; $i < $count; $i++) {

        // 1-gram
        $g1 = $chars[$i];
        $oneGram[$g1] = ($oneGram[$g1] ?? 0) + 1;

        // 2-gram
        if ($i < $count - 1) {
            $g2 = $chars[$i] . $chars[$i + 1];
            $twoGram[$g2] = ($twoGram[$g2] ?? 0) + 1;
        }

        // 3-gram
        if ($i < $count - 2) {
            $g3 = $chars[$i] . $chars[$i + 1] . $chars[$i + 2];
            $threeGram[$g3] = ($threeGram[$g3] ?? 0) + 1;
        }
    }

    arsort($oneGram);
    arsort($twoGram);
    arsort($threeGram);

    $oneGram = array_slice($oneGram, 0, 30, true);
    $twoGram = array_slice($twoGram, 0, 30, true);
    $threeGram = array_slice($threeGram, 0, 30, true);
}

$oneKeys = array_keys($oneGram);
$twoKeys = array_keys($twoGram);
$threeKeys = array_keys($threeGram);

?>

<h3 class="mb-3">음절 N-gram 분석</h3>

<form method="post" action="index.php?cmd=ngram" class="mb-4">
    <div class="row">
        <div class="col-md-10">
            <textarea name="text" class="form-control" rows="10"><?= htmlspecialchars($text) ?></textarea>
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100 h-100">
                분석
            </button>
        </div>
    </div>
</form>

<h3 class="mb-3">분석 결과</h3>

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>순서</th>

            <th>1음절</th>
            <th>빈도</th>

            <th>2음절</th>
            <th>빈도</th>

            <th>3음절</th>
            <th>빈도</th>
        </tr>
    </thead>

    <tbody>

    <?php for ($i = 0; $i < 30; $i++) { ?>

        <tr>

            <td><?= $i + 1 ?></td>

            <td>
                <?= isset($oneKeys[$i]) ? htmlspecialchars($oneKeys[$i]) : '' ?>
            </td>

            <td>
                <?= isset($oneKeys[$i]) ? $oneGram[$oneKeys[$i]] : '' ?>
            </td>

            <td>
                <?= isset($twoKeys[$i]) ? htmlspecialchars($twoKeys[$i]) : '' ?>
            </td>

            <td>
                <?= isset($twoKeys[$i]) ? $twoGram[$twoKeys[$i]] : '' ?>
            </td>

            <td>
                <?= isset($threeKeys[$i]) ? htmlspecialchars($threeKeys[$i]) : '' ?>
            </td>

            <td>
                <?= isset($threeKeys[$i]) ? $threeGram[$threeKeys[$i]] : '' ?>
            </td>

        </tr>

    <?php } ?>

    </tbody>
</table>