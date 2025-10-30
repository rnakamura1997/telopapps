<?php
session_start(); // セッションを開始
$telops = $_SESSION['telops'] ?? []; // セッションからテロップを取得
$selectedNumber = isset($_GET['number']) ? intval($_GET['number']) : null; // URLから管理番号を取得
$selectedTelop = null;

// 管理番号に基づいてテロップを取得
if ($selectedNumber !== null) {
    foreach ($telops as $telop) {
        if ($telop[0] == $selectedNumber) {
            $selectedTelop = $telop;
            break;
        }
    }
}

// セッションから背景色、フォントサイズ、フォントファミリ、表示位置、オフセットを取得
$backgroundColor = $_SESSION['background_color'] ?? '#000';
$fontSize = $_SESSION['font_size'] ?? '30px';
$fontFamily = $_SESSION['font_family'] ?? 'Arial';
$position = $_SESSION['position'] ?? 'center';
$offsetX = $_SESSION['offset_x'] ?? 0; // Xオフセット
$offsetY = $_SESSION['offset_y'] ?? 0; // Yオフセット

// 2行目と3行目のフォントサイズを取得
$fontSizeLine2 = $_SESSION['font_size_line2'] ?? '30px'; // デフォルト値
$fontSizeLine3 = $_SESSION['font_size_line3'] ?? '30px'; // デフォルト値
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>テロップ表示</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            background-color: <?php echo htmlspecialchars($backgroundColor); ?>; /* セッションから背景色を取得 */
            color: #fff; /* テキストの色を白に設定 */
            font-size: <?php echo htmlspecialchars($fontSize); ?>; /* セッションからフォントサイズを取得 */
            font-family: <?php echo htmlspecialchars($fontFamily); ?>; /* セッションからフォントファミリを取得 */
            position: relative; /* 親要素に相対位置を設定 */
        }
        #telopDisplay {
            position: absolute; /* 絶対位置で配置 */
            <?php
            // 表示位置に応じたCSSを設定
            switch ($position) {
                case 'top-left':
                    echo 'top: calc(0% + ' . $offsetY . '%); left: calc(0% + ' . $offsetX . '%);';
                    break;
                case 'top-center':
                    echo 'top: calc(0% + ' . $offsetY . '%); left: calc(50% + ' . $offsetX . '%); transform: translate(-50%, 0);';
                    break;
                case 'top-right':
                    echo 'top: calc(0% + ' . $offsetY . '%); right: calc(0% + ' . $offsetX . '%);';
                    break;
                case 'center':
                    echo 'top: calc(50% + ' . $offsetY . '%); left: calc(50% + ' . $offsetX . '%); transform: translate(-50%, -50%);';
                    break;
                case 'bottom-left':
                    echo 'bottom: calc(0% + ' . $offsetY . '%); left: calc(0% + ' . $offsetX . '%);';
                    break;
                case 'bottom-center':
                    echo 'bottom: calc(0% + ' . $offsetY . '%); left: calc(50% + ' . $offsetX . '%); transform: translate(-50%, 0);';
                    break;
                case 'bottom-right':
                    echo 'bottom: calc(0% + ' . $offsetY . '%); right: calc(0% + ' . $offsetX . '%);';
                    break;
            }
            ?>
            text-align: center; /* テロップを中央揃え */
        }
        .line2 {
            font-size: <?php echo htmlspecialchars($fontSizeLine2); ?>; /* 2行目のフォントサイズ */
        }
        .line3 {
            font-size: <?php echo htmlspecialchars($fontSizeLine3); ?>; /* 3行目のフォントサイズ */
        }
    </style>
</head>
<body>
    <div id="telopDisplay">
        <?php if ($selectedTelop): ?>
            <div><?php echo htmlspecialchars($selectedTelop[1]); ?></div> <!-- 1行目 -->
            <div class="line2"><?php echo htmlspecialchars($selectedTelop[2]); ?></div> <!-- 2行目 -->
            <div class="line3"><?php echo htmlspecialchars($selectedTelop[3]); ?></div> <!-- 3行目 -->
        <?php else: ?>
            <div>選択されたテロップはありません。</div>
        <?php endif; ?>
    </div>
</body>
</html>
