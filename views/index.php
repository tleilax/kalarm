<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link rel="stylesheet" href="assets/styles.css" type="text/css">
    <title>kalarm</title>
</head>
<body>
    <nav>
        <a href="<?= $_SERVER['PHP_SELF'] ?>?now=<?= strtotime('yesterday', $now) ?>&amp;days=<?= $days ?>">
            &lt; 
        </a>
        <?= date('d.m.Y', $now) ?>
    <? if ($days > 1): ?>
        - <?= date('d.m.Y', strtotime('+' . ($days - 1) . ' days', $now)) ?>
    <? endif; ?>
        <a href="<?= $_SERVER['PHP_SELF'] ?>?now=<?= strtotime('tomorrow', $now) ?>&amp;days=<?= $days ?>">
            &gt;
        </a>
    </nav>
    <div id="chart" data-xmin="<?= $min * 1000 ?>" data-xmax="<?= $max * 1000 ?>" data-ymax="<?= $max_value ?>"></div>
    <noscript>
        <ul>
        <? foreach ($data as $row): ?>
            <li>
                <?= date('d.m.Y H:i:s', $row['timestamp']) ?>,
                <?= $row['precipitation'] ?>
            </li>
        <? endforeach; ?>
        </ul>
    </noscript>
    <footer>
        Last update: <?= date('d.m.Y H:i:s', $last_update) ?> |
        <?= number_format($totals['total'], 0, ',', '.') ?> entries in db |
        <?= date('d.m.Y', $totals['min']) ?> - <?= date('d.m.Y', $totals['max']) ?>
    </footer>
    
    <script>
        var weather_data = [];
    <? // Optimize ?> 
    <? foreach ($data as $row): ?>
        weather_data.push([<?= $row['timestamp'] * 1000 ?>, <?= $row['precipitation'] ?>]);
    <? endforeach; ?>
    </script>
    <script src="assets/application.js"></script>
</body>
</html>