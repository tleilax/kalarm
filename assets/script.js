if (weather_data && weather_data.length) {
    $('#chart').show().plot([{
        label: 'Niederschlag',
        data: weather_data
    }, {
        label: 'Delta',
        data: weather_delta
    }], {
        lines: {
            show: true,
            fill: 0.3
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
            ticks: 10,
            minTicksize: 0.5
        }
    });
}
