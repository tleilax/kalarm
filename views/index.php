<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link rel="stylesheet" href="assets/styles.css" type="text/css">
    <title>kalarm</title>
</head>
<body>
    <nav>
        <a href="<?= $_SERVER['PHP_SELF'] ?>?from=<?= $min->format('Ymd') ?>&amp;yesterday&amp;days=<?= $days ?>">
            &lt; 
        </a>
        <?= $min->format('d.m.Y') ?>
    <? if ($days > 1): ?>
        - <?= $max->format('d.m.Y') ?>
    <? endif; ?>
        <a href="<?= $_SERVER['PHP_SELF'] ?>?from=<?= $min->format('Ymd') ?>&amp;tomorrow&amp;days=<?= $days ?>">
            &gt;
        </a>
    </nav>
    <div id="chart" data-xmin="<?= $min->getTimestamp() * 1000 ?>" data-xmax="<?= $max->getTimestamp() * 1000 ?>"></div>
    <noscript>no js, no gfx</noscript>
    <footer>
        Last update: <?= date('d.m.Y H:i:s', $last_update) ?> |
        <?= number_format($totals['total'], 0, ',', '.') ?> entries in db |
        <?= date('d.m.Y', $totals['min']) ?> - <?= date('d.m.Y', $totals['max']) ?>
    </footer>
    
    <script>
        var weather_data  = <?= $data->toJSON('precipitation') ?>.map(function (a) { a[0] *= 1000; return a; });
        var weather_delta = <?= $data->toJSON('delta') ?>.map(function (a) { a[0] *= 1000; return a; });
    </script>
    <script src="assets/application.js"></script>
</body>
</html>