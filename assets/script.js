if (weather_data && weather_data.length) {
    $('#chart').show().plot([{
        label: 'foo',
        data: weather_data
    }], {
        lines: {
            show: true,
            fill: true
        },
        grid: {
            hoverable: true
        },
        points: {
            show: true,
            radius: 2
        },
        xaxis: {
            min: $('#chart').data().xmin,
            max: $('#chart').data().xmax,
            mode: 'time',
            timezone: 'browser'
        },
        yaxis: {
            min: 0,
            max: $('#chart').data().ymax
        }
    });
}
