<section class="container admin-dashboard-modern">
    <?php
      $actividad = $actividadMensual ?? [];
      $actividadJson = json_encode($actividad, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
      $courseStatus = $courseStatus ?? [];
      $courseStatusJson = json_encode($courseStatus, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
      $courseRows = [];
      $totalAprobados = 0;
      $totalReprobados = 0;
      foreach ($courseStatus as $row) {
        $ap = (int)($row['aprobados'] ?? 0);
        $rep = (int)($row['reprobados'] ?? 0);
        $total = $ap + $rep;
        $tasa = $total > 0 ? round(($ap / $total) * 100, 1) : 0.0;
        $courseRows[] = [
          'curso' => (string)($row['curso'] ?? 'Sin curso'),
          'aprobados' => $ap,
          'reprobados' => $rep,
          'total' => $total,
          'tasa' => $tasa,
        ];
        $totalAprobados += $ap;
        $totalReprobados += $rep;
      }
      usort($courseRows, fn($a, $b) => $b['total'] <=> $a['total']);
      $overallTotal = $totalAprobados + $totalReprobados;
      $overallRate = $overallTotal > 0 ? round(($totalAprobados / $overallTotal) * 100, 1) : 0.0;
      $satQ1Json = json_encode($satQ1 ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    ?>

    <div class="dashboard-title-wrap">
        <h2>Tablero</h2>
    </div>

    <div class="dashboard-kpis">
        <article class="kpi-card kpi-gold">
            <div class="kpi-head">
                <span class="kpi-icon">▤</span>
                <span class="kpi-label">Cursos registrados</span>
            </div>
            <strong><?= count($cursos) ?></strong>
            <span class="kpi-line"></span>
        </article>

        <article class="kpi-card kpi-teal">
            <div class="kpi-head">
                <span class="kpi-icon">▣</span>
                <span class="kpi-label">Respuestas totales</span>
            </div>
            <strong><?= (int)$totalRespuestas ?></strong>
            <span class="kpi-line"></span>
        </article>

        <article class="kpi-card kpi-gold">
            <div class="kpi-head">
                <span class="kpi-icon">⋮</span>
                <span class="kpi-label">Promedio de Puntuación</span>
            </div>
            <strong><?= (int)$promedioPuntuacion ?>%</strong>
            <span class="kpi-line"></span>
        </article>

        <article class="kpi-card kpi-teal">
            <div class="kpi-head">
                <span class="kpi-icon">◯</span>
                <span class="kpi-label">Tasa de Finalización</span>
            </div>
            <strong><?= (int)$tasaFinalizacion ?>%</strong>
            <span class="kpi-line"></span>
        </article>
    </div>

    <section class="card dashboard-sat-summary">
        <div class="dashboard-sat-head">
            <h3>Resumen de satisfacci&oacute;n</h3>
            <a class="btn btn-info btn-sm btn-no-icon" href="<?= e(url('/admin/satisfaccion')) ?>">Ver detalle</a>
        </div>
        <div class="dashboard-sat-kpis">
            <article class="dashboard-sat-kpi">
                <span>Encuestas recibidas</span>
                <strong><?= (int)($satTotal ?? 0) ?></strong>
            </article>
            <article class="dashboard-sat-kpi">
                <span>Promedio satisfacci&oacute;n (1-4)</span>
                <strong><?= e(number_format((float)($satPromedio ?? 0), 2)) ?></strong>
            </article>
            <article class="dashboard-sat-kpi">
                <span>Recomendar&iacute;an el curso</span>
                <strong><?= e(number_format((float)($satRecomendacion ?? 0), 1)) ?>%</strong>
            </article>
            <article class="dashboard-sat-kpi">
                <span>Con comentarios</span>
                <strong><?= (int)($satComentarios ?? 0) ?></strong>
            </article>
        </div>
        <div class="dashboard-sat-chart-wrap">
            <canvas id="dashboardSatQ1Chart" height="120"></canvas>
        </div>
    </section>

    <div class="dashboard-main-grid">
        <section class="card dashboard-list-card">
            <h3>Últimas evaluaciones</h3>
            <table class="table dashboard-table-modern">
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Curso</th>
                        <th>Estatus</th>
                        <th>Participante</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ultimos as $item): ?>
                    <tr>
                        <td><?= e($item['folio']) ?></td>
                        <td><?= e($item['curso_nombre']) ?></td>
                        <td>
                            <span class="result-badge <?= e($item['estatus_key']) ?>"><?= e($item['estatus']) ?></span>
                        </td>
                        <td><?= e($item['nombre_completo']) ?></td>
                        <td><?= e($item['created_at']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($ultimos)): ?>
                    <tr>
                        <td colspan="5">Sin registros.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <aside class="card dashboard-insights-card">
            <h3>Resumen rápido</h3>
            <h4>Actividad Mensual</h4>
            <canvas id="dashboardActivityChart" height="250"></canvas>
        </aside>
    </div>

    <section class="card dashboard-course-status-card">
        <div class="dashboard-course-status-head">
            <div>
                <h3>Aprobados y reprobados por curso</h3>
                <p>Desempeño por curso con umbral de aprobación del 70%.</p>
            </div>
            <div class="dashboard-course-status-legend">
                <span><i class="dot approved"></i>Aprobados</span>
                <span><i class="dot failed"></i>Reprobados</span>
            </div>
        </div>

        <div class="dashboard-course-status-kpis">
            <article>
                <span>Total evaluados</span>
                <strong><?= (int)$overallTotal ?></strong>
            </article>
            <article>
                <span>Aprobación global</span>
                <strong><?= e(number_format($overallRate, 1)) ?>%</strong>
            </article>
            <article>
                <span>En proceso / No aprobados</span>
                <strong><?= (int)$totalReprobados ?></strong>
            </article>
        </div>

        <div class="dashboard-course-status-chart-wrap">
            <canvas id="dashboardCourseStatusChart" height="320"></canvas>
        </div>

        <div class="dashboard-course-status-table-wrap">
            <h4>Detalle de resultados</h4>
            <table class="table dashboard-course-status-table">
                <thead>
                    <tr>
                        <th>Nombre del curso</th>
                        <th>Aprobados</th>
                        <th>Reprobados</th>
                        <th>Total</th>
                        <th>Tasa de aprobación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($courseRows as $row): ?>
                    <tr>
                        <td><?= e($row['curso']) ?></td>
                        <td class="num ok"><?= (int)$row['aprobados'] ?></td>
                        <td class="num bad"><?= (int)$row['reprobados'] ?></td>
                        <td class="num"><?= (int)$row['total'] ?></td>
                        <td>
                            <div class="approval-rate-cell">
                                <div class="approval-rate-track">
                                    <span style="width: <?= e((string)$row['tasa']) ?>%"></span>
                                </div>
                                <strong><?= e(number_format((float)$row['tasa'], 1)) ?>%</strong>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($courseRows)): ?>
                    <tr>
                        <td colspan="5">Sin datos de cursos para mostrar.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</section>

<script id="dashboardActivityData" type="application/json"><?= $actividadJson ?: '[]' ?></script>
<script id="dashboardCourseStatusData" type="application/json"><?= $courseStatusJson ?: '[]' ?></script>
<script id="dashboardSatQ1Data" type="application/json"><?= $satQ1Json ?: '{}' ?></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(() => {
  const node = document.getElementById('dashboardActivityData');
  const canvas = document.getElementById('dashboardActivityChart');
  const courseStatusNode = document.getElementById('dashboardCourseStatusData');
  const courseStatusCanvas = document.getElementById('dashboardCourseStatusChart');
  const satNode = document.getElementById('dashboardSatQ1Data');
  const satCanvas = document.getElementById('dashboardSatQ1Chart');
  if (!node || !canvas || !window.Chart) return;

  let data = [];
  try {
    data = JSON.parse(node.textContent || '[]');
  } catch (e) {
    data = [];
  }

  const labels = data.map(item => item.label || '');
  const totals = data.map(item => Number(item.totales || 0));
  const approved = data.map(item => Number(item.aprobados || 0));

  new Chart(canvas.getContext('2d'), {
    type: 'bar',
    data: {
      labels,
      datasets: [
        {
          label: 'Total',
          data: totals,
          backgroundColor: '#1f998e',
          borderRadius: 6,
          barThickness: 16,
        },
        {
          label: 'Aprobados',
          data: approved,
          backgroundColor: '#c1a04f',
          borderRadius: 6,
          barThickness: 16,
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        x: {
          grid: {
            display: false
          },
          ticks: {
            color: '#6d7687'
          }
        },
        y: {
          beginAtZero: true,
          ticks: {
            precision: 0,
            color: '#6d7687'
          },
          grid: {
            color: 'rgba(21, 36, 63, 0.10)'
          }
        }
      }
    }
  });

  if (courseStatusNode && courseStatusCanvas) {
    let courseData = [];
    try {
      courseData = JSON.parse(courseStatusNode.textContent || '[]');
    } catch (e) {
      courseData = [];
    }

    const labels = courseData.map((item) => item.curso || 'Sin curso');
    const aprobados = courseData.map((item) => Number(item.aprobados || 0));
    const reprobados = courseData.map((item) => Number(item.reprobados || 0));
    const totalsByCourse = courseData.map((item) => Number(item.aprobados || 0) + Number(item.reprobados || 0));

    const valueLabelPlugin = {
      id: 'valueLabelPlugin',
      afterDatasetsDraw(chart) {
        const { ctx } = chart;
        ctx.save();
        ctx.font = '600 12px Montserrat, sans-serif';
        ctx.fillStyle = '#34435c';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'bottom';
        chart.data.datasets.forEach((dataset, datasetIndex) => {
          const meta = chart.getDatasetMeta(datasetIndex);
          meta.data.forEach((bar, index) => {
            const value = Number(dataset.data[index] || 0);
            if (value <= 0) return;
            ctx.fillText(String(value), bar.x, bar.y - 6);
          });
        });
        ctx.restore();
      }
    };

    new Chart(courseStatusCanvas.getContext('2d'), {
      type: 'bar',
      data: {
        labels,
        datasets: [
          {
            label: 'Aprobados',
            data: aprobados,
            backgroundColor: '#26a69a',
            hoverBackgroundColor: '#1f8f85',
            borderRadius: 4,
            borderSkipped: false,
            barThickness: 18,
            categoryPercentage: 0.62,
            barPercentage: 0.86,
          },
          {
            label: 'Reprobados',
            data: reprobados,
            backgroundColor: '#c8745a',
            hoverBackgroundColor: '#b0624a',
            borderRadius: 4,
            borderSkipped: false,
            barThickness: 18,
            categoryPercentage: 0.62,
            barPercentage: 0.86,
          }
        ]
      },
      plugins: [valueLabelPlugin],
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            backgroundColor: 'rgba(14, 34, 64, 0.96)',
            borderColor: 'rgba(207, 220, 236, 0.35)',
            borderWidth: 1,
            titleColor: '#ffffff',
            bodyColor: '#e8eef8',
            displayColors: true,
            boxPadding: 6,
            padding: 12,
            cornerRadius: 10,
            caretSize: 7,
            callbacks: {
              title(items) {
                const i = items?.[0]?.dataIndex ?? 0;
                return labels[i] || '';
              },
              label(context) {
                const value = Number(context.raw || 0);
                const index = context.dataIndex ?? 0;
                const total = Number(totalsByCourse[index] || 0);
                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : '0.0';
                return `${context.dataset.label}: ${value} (${percentage}%)`;
              }
            }
          },
        },
        scales: {
          x: {
            grid: {
              display: false
            },
            ticks: {
              color: '#66758f',
              maxRotation: 0,
              callback(value, index) {
                const label = labels[index] || '';
                return label.length > 70 ? `${label.slice(0, 70)}...` : label;
              }
            }
          },
          y: {
            beginAtZero: true,
            ticks: {
              precision: 0,
              color: '#6d7687',
              stepSize: 5
            },
            grid: {
              color: 'rgba(21, 36, 63, 0.10)'
            }
          }
        }
      }
    });
  }

  if (satNode && satCanvas) {
    let satData = {};
    try {
      satData = JSON.parse(satNode.textContent || '{}');
    } catch (e) {
      satData = {};
    }

    const labels = Object.keys(satData);
    const values = labels.map((k) => Number(satData[k] || 0));
    const hasData = values.some((v) => v > 0);

    new Chart(satCanvas.getContext('2d'), {
      type: 'doughnut',
      data: {
        labels: hasData ? labels : ['Sin datos'],
        datasets: [{
          data: hasData ? values : [1],
          backgroundColor: hasData ? ['#163b7a', '#1fa7a0', '#c49e4b', '#6f7d92'] : ['#d5dbe7'],
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
              boxWidth: 12,
              color: '#223251'
            }
          }
        },
        cutout: '58%'
      }
    });
  }
})();
</script>
