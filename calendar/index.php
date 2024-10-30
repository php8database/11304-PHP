<?php
// 取得當前年份
$currentYear = date("Y");
$selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : $currentYear;

// 農曆節日與紀念日
$holidays = [
    '1-1' => '元旦',
    '2-14' => '情人節',
    '3-8' => '婦女節',
    '4-4' => '兒童節',
    '5-1' => '勞動節',
    '10-10' => '國慶日',
    '12-25' => '聖誕節',
];

function renderCalendar($year, $holidays) {
    echo "<h2>{$year} 年萬年曆</h2>";
    for ($month = 1; $month <= 12; $month++) {
        echo "<h3>" . date("F", mktime(0, 0, 0, $month, 1)) . "</h3>";
        echo "<table>";
        echo "<tr><th>日</th><th>一</th><th>二</th><th>三</th><th>四</th><th>五</th><th>六</th></tr>";
        
        // 取得每月的第一天是星期幾
        $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
        $daysInMonth = date("t", $firstDayOfMonth);
        $startDayOfWeek = date("w", $firstDayOfMonth);
        
        echo "<tr>";
        for ($i = 0; $i < $startDayOfWeek; $i++) {
            echo "<td></td>"; // 空白單元格
        }
        
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dateKey = "{$month}-{$day}";
            $isToday = ($year == date("Y") && $month == date("n") && $day == date("j"));
            $cellStyle = $isToday ? 'class="today"' : '';

            echo "<td {$cellStyle}>{$day}";
            if (isset($holidays[$dateKey])) {
                echo "<br><small>{$holidays[$dateKey]}</small>";
            }
            echo "</td>";
            
            if (($startDayOfWeek + $day) % 7 == 0) {
                echo "</tr><tr>";
            }
        }
        
        echo "</tr></table>";
    }
}

?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>萬年曆</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>萬年曆</h1>
        <form method="get" action="">
            <select name="year">
                <?php for ($i = 2000; $i <= 2100; $i++): ?>
                    <option value="<?= $i ?>" <?= $i == $selectedYear ? 'selected' : '' ?>><?= $i ?></option>
                <?php endfor; ?>
            </select>
            <button type="submit">切換年份</button>
            <a href="index.php">回到今年</a>
        </form>
        <?php renderCalendar($selectedYear, $holidays); ?>
    </div>
</body>
</html>
