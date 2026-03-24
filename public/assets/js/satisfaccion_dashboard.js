(function () {
  const source = document.getElementById('satisfaccionDashboardData');
  if (!source) return;

  let data = {};
  try {
    data = JSON.parse(source.textContent || '{}');
  } catch (e) {
    data = {};
  }

  const palette = ['#163b7a', '#1fa7a0', '#c49e4b', '#d85f8f', '#6f7bd1', '#6f7d92'];

  const buildDoughnut = (id, labels, values) => {
    const el = document.getElementById(id);
    if (!el) return;
    const nonZero = values.some((v) => Number(v) > 0);
    const safeLabels = nonZero ? labels : ['Sin datos'];
    const safeValues = nonZero ? values : [1];
    const safeColors = nonZero ? palette.slice(0, safeLabels.length) : ['#d5dbe7'];

    new Chart(el, {
      type: 'doughnut',
      data: {
        labels: safeLabels,
        datasets: [{
          data: safeValues,
          backgroundColor: safeColors,
          borderColor: '#ffffff',
          borderWidth: 2
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              boxWidth: 14,
              color: '#1c2b4b',
              font: { size: 12, family: 'Montserrat' }
            }
          }
        },
        cutout: '58%'
      }
    });
  };

  const fromObj = (obj) => {
    const keys = Object.keys(obj || {});
    const vals = keys.map((k) => Number(obj[k] || 0));
    return { keys, vals };
  };

  const q1 = fromObj(data.q1 || {});
  const q2 = fromObj(data.q2 || {});
  const q3 = fromObj(data.q3 || {});
  const q4 = fromObj(data.q4 || {});
  const q5 = fromObj(data.q5 || {});

  buildDoughnut('satQ1Chart', q1.keys, q1.vals);
  buildDoughnut('satQ2Chart', q2.keys, q2.vals);
  buildDoughnut('satQ3Chart', q3.keys, q3.vals);
  buildDoughnut('satQ4Chart', q4.keys, q4.vals);
  buildDoughnut('satQ5Chart', q5.keys, q5.vals);
})();
