<?php
session_start(); // セッションを開始

$telops = [];
$backgroundColor = '#000'; // デフォルトの背景色
$fontSize = '30px'; // デフォルトのフォントサイズ
$fontFamily = 'Arial'; // デフォルトのフォントファミリ
$position = 'center'; // デフォルトの表示位置
$offsetX = 0; // デフォルトのXオフセット
$offsetY = 0; // デフォルトのYオフセット
$fontSizeLine2 = '30px'; // デフォルトの2行目フォントサイズ
$fontSizeLine3 = '30px'; // デフォルトの3行目フォントサイズ

if (isset($_POST['submit'])) {
    // CSVファイルのアップロード処理
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $file = $_FILES['csv_file']['tmp_name'];
        $rows = array_map('str_getcsv', file($file));
        
        // 管理番号を付与
        foreach ($rows as $row) {
            // CSVの各行からデータを取得
            if (count($row) >= 4) { // 4つ以上の列がある場合のみ
                $telops[] = [$row[0], $row[1], $row[2], $row[3]]; // 管理番号とテロップ
            }
        }
        
        // CSVデータをセッションに保存
        $_SESSION['telops'] = $telops;
    }
} elseif (isset($_POST['submit_settings'])) {
    // 背景色、フォントサイズ、フォントファミリ、表示位置、オフセットの設定をセッションに保存
    if (isset($_POST['background_color'])) {
        $backgroundColor = $_POST['background_color'];
        $_SESSION['background_color'] = $backgroundColor;
    }
    if (isset($_POST['font_size'])) {
        $fontSize = $_POST['font_size'];
        $_SESSION['font_size'] = $fontSize;
    }
    if (isset($_POST['font_family'])) {
        $fontFamily = $_POST['font_family'];
        $_SESSION['font_family'] = $fontFamily;
    }
    if (isset($_POST['position'])) {
        $position = $_POST['position'];
        $_SESSION['position'] = $position;
    }
    if (isset($_POST['offset_x'])) {
        $offsetX = $_POST['offset_x'];
        $_SESSION['offset_x'] = $offsetX;
    }
    if (isset($_POST['offset_y'])) {
        $offsetY = $_POST['offset_y'];
        $_SESSION['offset_y'] = $offsetY;
    }
    if (isset($_POST['font_size_line2'])) {
        $fontSizeLine2 = $_POST['font_size_line2'];
        $_SESSION['font_size_line2'] = $fontSizeLine2;
    }
    if (isset($_POST['font_size_line3'])) {
        $fontSizeLine3 = $_POST['font_size_line3'];
        $_SESSION['font_size_line3'] = $fontSizeLine3;
    }
}

// セッションから背景色、フォントサイズ、フォントファミリ、表示位置、オフセットを取得
$backgroundColor = $_SESSION['background_color'] ?? $backgroundColor;
$fontSize = $_SESSION['font_size'] ?? $fontSize;
$fontFamily = $_SESSION['font_family'] ?? $fontFamily;
$position = $_SESSION['position'] ?? $position;
$offsetX = $_SESSION['offset_x'] ?? $offsetX;
$offsetY = $_SESSION['offset_y'] ?? $offsetY;
$fontSizeLine2 = $_SESSION['font_size_line2'] ?? $fontSizeLine2;
$fontSizeLine3 = $_SESSION['font_size_line3'] ?? $fontSizeLine3;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>テロップアプリ</title>
</head>
<body>
    <div class="admin-panel">
        <h1>管理画面</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="csv_file" accept=".csv" required>
            <input type="submit" name="submit" value="アップロード">
        </form>
        
        <h2>テロップ設定</h2>
        <form action="" method="post">
            <label for="background_color">背景色:</label>
            <input type="color" id="background_color" name="background_color" value="<?php echo htmlspecialchars($backgroundColor); ?>"><br>

            <label for="font_size">フォントサイズ:</label>
            <input type="text" id="font_size" name="font_size" value="<?php echo htmlspecialchars($fontSize); ?>"><br>

            <label for="font_family">フォントファミリ:</label>
            <select id="font_family" name="font_family">
                <option value="Arial" <?php if ($fontFamily == 'Arial') echo 'selected'; ?>>Arial</option>
                <option value="Verdana" <?php if ($fontFamily == 'Verdana') echo 'selected'; ?>>Verdana</option>
                <option value="Helvetica" <?php if ($fontFamily == 'Helvetica') echo 'selected'; ?>>Helvetica</option>
                <option value="Times New Roman" <?php if ($fontFamily == 'Times New Roman') echo 'selected'; ?>>Times New Roman</option>
                <option value="Georgia" <?php if ($fontFamily == 'Georgia') echo 'selected'; ?>>Georgia</option>
                <option value="Courier New" <?php if ($fontFamily == 'Courier New') echo 'selected'; ?>>Courier New</option>
                <option value="Meiryo" <?php if ($fontFamily == 'Meiryo') echo 'selected'; ?>>メイリオ</option>
                <option value="Yu Gothic" <?php if ($fontFamily == 'Yu Gothic') echo 'selected'; ?>>游ゴシック</option>
                <option value="Noto Sans JP" <?php if ($fontFamily == 'Noto Sans JP') echo 'selected'; ?>>Noto Sans JP</option>
            </select><br>

            <label for="position">表示位置:</label>
            <select id="position" name="position">
                <option value="top-left" <?php if ($position == 'top-left') echo 'selected'; ?>>左上</option>
                <option value="top-center" <?php if ($position == 'top-center') echo 'selected'; ?>>中央上</option>
                <option value="top-right" <?php if ($position == 'top-right') echo 'selected'; ?>>右上</option>
                <option value="center" <?php if ($position == 'center') echo 'selected'; ?>>中央</option>
                <option value="bottom-left" <?php if ($position == 'bottom-left') echo 'selected'; ?>>左下</option>
                <option value="bottom-center" <?php if ($position == 'bottom-center') echo 'selected'; ?>>中央下</option>
                <option value="bottom-right" <?php if ($position == 'bottom-right') echo 'selected'; ?>>右下</option>
            </select><br>

            <label for="offset_x">Xオフセット (%):</label>
            <input type="number" id="offset_x" name="offset_x" value="<?php echo htmlspecialchars($offsetX); ?>" step="1"><br>

            <label for="offset_y">Yオフセット (%):</label>
            <input type="number" id="offset_y" name="offset_y" value="<?php echo htmlspecialchars($offsetY); ?>" step="1"><br>

            <label for="font_size_line2">2行目フォントサイズ:</label>
            <input type="text" id="font_size_line2" name="font_size_line2" value="<?php echo htmlspecialchars($fontSizeLine2); ?>"><br>

            <label for="font_size_line3">3行目フォントサイズ:</label>
            <input type="text" id="font_size_line3" name="font_size_line3" value="<?php echo htmlspecialchars($fontSizeLine3); ?>"><br>

            <input type="submit" name="submit_settings" value="設定を保存">
        </form>

        <h2>テロップ選択</h2>
        <input type="number" id="telopNumber" placeholder="管理番号を入力" min="1">
        <button onclick="openTelopWindow()">テロップ表示</button>
    </div>

    <script>
        function openTelopWindow() {
            const telopNumber = document.getElementById('telopNumber').value;
            if (telopNumber === "") {
                alert("管理番号を入力してください。");
                return;
            }
            // ウィンドウサイズを1920x1080に設定
            const telopWindow = window.open('telop_display.php?number=' + telopNumber, 'TelopWindow', 'width=1920,height=1080');
        }
    </script>
</body>
</html>
