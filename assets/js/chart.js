import Chart from 'chart.js/auto';
import ColorHash from 'color-hash'

jQuery(document).ready(function () {
    getChartData();
});

function getChartData() {
    jQuery.ajax({
        url: route,
        success: function (chartAllData) {
            let data = JSON.parse(chartAllData)
            buildChart(data.byDate);
            buildDoughnutBrowser(data.byBrowser);
            buildDoughnutPlatform(data.byPlatform)
        },
        error: function () {
            alert('Произошла ошибка!');
        }
    });
}

function buildChart(data) {
    let chart = document.getElementById('chart');
    if (chart && data) {
        new Chart(
            chart.getContext('2d'),
            prepareChartConfig(data)
        );
    }
}

function buildDoughnutBrowser(data) {
    let chart = document.getElementById('browser');
    if (chart && data) {
        new Chart(
            chart.getContext('2d'),
            prepareDoughnutConfig(data)
        );
    }
}

function buildDoughnutPlatform(data) {
    let chart = document.getElementById('platform');
    if (chart && data) {
        new Chart(
            chart.getContext('2d'),
            prepareDoughnutConfig(data)
        );
    }
}

const colorHash = new ColorHash({hue: [{min: 30, max: 285}, {min: 0, max: 210}, {min: 0, max: 285}]})
function prepareDoughnutConfig(chartData) {
    let data = {
        labels: Object.keys(chartData),
        datasets: [{
            backgroundColor: Object.keys(chartData).map(name => colorHash.hex(name)),
            data: Object.values(chartData),
        }]
    };

    return {
        type: 'doughnut',
        data: data,
        options: {
            responsive: true,
        }
    };
}

function prepareChartConfig(chartData) {
    let data = {
        labels: Object.keys(chartData),
        datasets: [{
            label: 'Переходи',
            backgroundColor: 'rgb(99,161,255)',
            borderColor: 'rgb(99,161,255)',
            data: Object.values(chartData),
        }]
    };

    return {
        type: 'bar',
        data: data,
        options: {
            responsive: false,
        }
    };
}
