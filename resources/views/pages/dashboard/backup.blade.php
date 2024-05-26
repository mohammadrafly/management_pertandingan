const ctx = document.getElementById('myDonat');

new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ,
        datasets: [{
            label: '# of Atlet Per Kelas',
            data: ,
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Total Atlet Per Kelas'
            }
        }
    },
});

const ctxBar = document.getElementById('myBar');

const tournamentData = ;

const tournamentNames = Object.keys(tournamentData);
const totalAthletes = Object.values(tournamentData);

console.log(tournamentNames)

new Chart(ctxBar, {
    type: 'bar',
    data: {
        labels: tournamentNames,
        datasets: [{
            label: '# of Atlet',
            data: totalAthletes,
            backgroundColor: 'rgba(75, 192, 192, 0.5)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Total Atlet in Pertandingan'
            }
        }
    },
});
