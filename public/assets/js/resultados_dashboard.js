(() => {
  const dataEl = document.getElementById('resultsDashboardData');
  if (!dataEl || typeof window.Chart === 'undefined') return;

  let dashboard = {};
  try {
    dashboard = JSON.parse(dataEl.textContent || '{}');
  } catch (err) {
    dashboard = {};
  }

  const colors = ['#1f9b91', '#c1a04f', '#1B446E', '#6F7D8A', '#2F7FB8', '#4CB69F', '#111426', '#AC986A'];

  const toEntries = (map) => Object.entries(map || {}).filter(([, value]) => Number(value || 0) > 0);
  const entriesCurso = toEntries(dashboard.por_curso);
  const entriesDia = toEntries(dashboard.por_dia);

  const normalize = (entries) => {
    if (!entries.length) {
      return { labels: ['Sin datos'], values: [0] };
    }
    return {
      labels: entries.map(([k]) => k),
      values: entries.map(([, v]) => Number(v || 0)),
    };
  };

  const byCourse = normalize(entriesCurso);
  const byDay = normalize(entriesDia);

  const courseCanvas = document.getElementById('resultsByCourseChart');
  if (courseCanvas) {
    new Chart(courseCanvas, {
      type: 'bar',
      data: {
        labels: byCourse.labels,
        datasets: [{
          label: 'Respuestas',
          data: byCourse.values,
          backgroundColor: byCourse.labels.map((_, idx) => colors[idx % colors.length]),
          borderRadius: 6,
          maxBarThickness: 50
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false }
        },
        scales: {
          x: {
            ticks: {
              color: '#5f6b80',
              maxRotation: 0,
            },
            grid: {
              display: false,
            }
          },
          y: {
            beginAtZero: true,
            ticks: {
              precision: 0,
              color: '#5f6b80',
            },
            grid: {
              color: 'rgba(18, 40, 71, 0.12)',
            }
          }
        }
      }
    });
  }

  const dayCanvas = document.getElementById('resultsByDayChart');
  if (dayCanvas) {
    new Chart(dayCanvas, {
      type: 'line',
      data: {
        labels: byDay.labels,
        datasets: [{
          label: 'Respuestas por día',
          data: byDay.values,
          borderColor: '#3c78b1',
          backgroundColor: 'rgba(60, 120, 177, 0.22)',
          pointBackgroundColor: '#1f9b91',
          pointBorderColor: '#1f9b91',
          pointRadius: 4,
          pointHoverRadius: 6,
          fill: true,
          tension: 0.28
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false }
        },
        scales: {
          x: {
            ticks: {
              color: '#5f6b80',
              maxRotation: 0,
            },
            grid: {
              color: 'rgba(18, 40, 71, 0.08)',
            }
          },
          y: {
            beginAtZero: true,
            ticks: {
              precision: 0,
              color: '#5f6b80',
            },
            grid: {
              color: 'rgba(18, 40, 71, 0.12)',
            }
          }
        }
      }
    });
  }
})();
