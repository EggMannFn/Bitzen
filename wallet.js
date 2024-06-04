
var ctx = document.getElementById('myChartBalance').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['01/01', '01/02', '01/03', '01/04', '01/05', '01/06'],
        datasets: [{
            label: 'Balance',
            data: [800000, 1000000, 650000, 1000000, 1000000, 1002000],
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(9, 175, 143, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});