(() => {
  const dataEl = document.getElementById('inscripcionesDashboardData');
  if (!dataEl || typeof window.Chart === 'undefined') return;
  const exportRowsEl = document.getElementById('inscripcionesExportRows');

  const raw = dataEl.textContent || '{}';
  let stats = {};
  let exportRows = [];
  try {
    stats = JSON.parse(raw);
  } catch (err) {
    stats = {};
  }
  try {
    exportRows = JSON.parse(exportRowsEl?.textContent || '[]');
  } catch (err) {
    exportRows = [];
  }

  const colorSet = ['#0b2f72', '#0f9f9b', '#1f4f8a', '#c320ad', '#8d2ba4', '#ac986a'];
  const charts = {};

  const normalizeDataset = (source) => {
    const labels = [];
    const values = [];
    Object.entries(source || {}).forEach(([label, value]) => {
      const n = Number(value || 0);
      if (n > 0) {
        labels.push(label);
        values.push(n);
      }
    });
    if (labels.length === 0) {
      return { labels: ['Sin datos'], values: [1] };
    }
    return { labels, values };
  };

  const createPieChart = (canvasId, source, title) => {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return null;
    const data = normalizeDataset(source);
    return new Chart(canvas, {
      type: 'doughnut',
      data: {
        labels: data.labels,
        datasets: [{
          data: data.values,
          backgroundColor: colorSet.slice(0, data.labels.length),
          borderColor: '#ffffff',
          borderWidth: 2
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '52%',
        plugins: {
          title: {
            display: true,
            text: title,
            color: '#111426',
            font: { size: 15, weight: '600' },
            padding: { top: 6, bottom: 8 }
          },
          legend: {
            position: 'bottom',
            labels: {
              color: '#2f3f57',
              font: { size: 12, weight: '600' },
              boxWidth: 12,
              boxHeight: 12,
              padding: 10
            }
          }
        }
      }
    });
  };

  const createBarChart = (canvasId, source, title) => {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return null;
    const data = normalizeDataset(source);
    return new Chart(canvas, {
      type: 'bar',
      data: {
        labels: data.labels,
        datasets: [{
          data: data.values,
          backgroundColor: data.labels.map((_, idx) => colorSet[idx % colorSet.length]),
          borderRadius: 8,
          maxBarThickness: 34
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        indexAxis: 'y',
        plugins: {
          title: {
            display: true,
            text: title,
            color: '#111426',
            font: { size: 15, weight: '600' },
            padding: { top: 6, bottom: 8 }
          },
          legend: {
            display: false
          }
        },
        scales: {
          x: {
            beginAtZero: true,
            ticks: {
              precision: 0,
              color: '#2f3f57'
            },
            grid: {
              color: 'rgba(143, 156, 178, 0.2)'
            }
          },
          y: {
            ticks: {
              color: '#2f3f57',
              font: { size: 11, weight: '600' }
            },
            grid: {
              display: false
            }
          }
        }
      }
    });
  };

  const buildHighResChartImage = async (source) => {
    const data = normalizeDataset(source);
    const canvas = document.createElement('canvas');
    canvas.width = 1500;
    canvas.height = 900;

    const valueLabelsPlugin = {
      id: 'valueLabelsPlugin',
      afterDatasetsDraw(chart) {
        const ctx = chart.ctx;
        const dataset = chart.data.datasets[0];
        const meta = chart.getDatasetMeta(0);
        ctx.save();
        ctx.font = '600 28px Montserrat';
        ctx.fillStyle = '#1c2230';
        ctx.strokeStyle = '#8ea0b9';
        ctx.lineWidth = 2;

        meta.data.forEach((arc, idx) => {
          const value = Number(dataset.data[idx] || 0);
          if (value <= 0) return;

          const angle = (arc.startAngle + arc.endAngle) / 2;
          const r = arc.outerRadius;
          const x1 = arc.x + Math.cos(angle) * (r + 4);
          const y1 = arc.y + Math.sin(angle) * (r + 4);
          const x2 = arc.x + Math.cos(angle) * (r + 28);
          const y2 = arc.y + Math.sin(angle) * (r + 28);
          const alignRight = Math.cos(angle) >= 0;
          const x3 = x2 + (alignRight ? 18 : -18);

          ctx.beginPath();
          ctx.moveTo(x1, y1);
          ctx.lineTo(x2, y2);
          ctx.lineTo(x3, y2);
          ctx.stroke();

          ctx.textAlign = alignRight ? 'left' : 'right';
          ctx.textBaseline = 'middle';
          ctx.fillText(String(value), x3 + (alignRight ? 6 : -6), y2);
        });

        ctx.restore();
      }
    };

    const chart = new Chart(canvas, {
      type: 'doughnut',
      data: {
        labels: data.labels,
        datasets: [{
          data: data.values,
          backgroundColor: colorSet.slice(0, data.labels.length),
          borderColor: '#ffffff',
          borderWidth: 4
        }]
      },
      options: {
        responsive: false,
        animation: false,
        cutout: '48%',
        layout: {
          padding: { top: 30, right: 40, bottom: 20, left: 40 }
        },
        plugins: {
          legend: {
            position: 'right',
            labels: {
              color: '#1c2230',
              font: { size: 30, weight: '600' },
              boxWidth: 24,
              boxHeight: 24,
              padding: 14
            }
          }
        }
      },
      plugins: [valueLabelsPlugin]
    });

    await new Promise(resolve => setTimeout(resolve, 0));
    const img = chart.toBase64Image('image/png', 1.0);
    chart.destroy();
    return img;
  };

  const orderedCountMap = (source, orderedKeys) => {
    const map = source || {};
    return orderedKeys.map((key) => ({
      key,
      value: Number(map[key] || 0),
    }));
  };

  const orderedMapEntries = (source) => {
    const map = source || {};
    return Object.entries(map).map(([key, value]) => ({
      key,
      value: Number(value || 0),
    }));
  };

  const setPdfLoader = (active, message = '') => {
    const loader = document.getElementById('page-loader');
    if (!loader) return;
    let text = loader.querySelector('.loader-text');
    if (!text) {
      text = document.createElement('div');
      text.className = 'loader-text';
      loader.appendChild(text);
    }
    text.textContent = message;
    if (active) {
      loader.classList.add('show');
    } else {
      loader.classList.remove('show');
      text.textContent = '';
    }
  };

  const sanitizeText = (value) => String(value ?? '').replace(/\s+/g, ' ').trim();

  const cleanCourseLabel = (value) => sanitizeText(value).replace(/^["']+|["']+$/g, '');

  const slugify = (value) => sanitizeText(value)
    .toLowerCase()
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/^-+|-+$/g, '');

  const loadImageAsDataUrl = (url) => new Promise((resolve) => {
    if (!url) {
      resolve(null);
      return;
    }
    const img = new Image();
    img.crossOrigin = 'anonymous';
    img.onload = () => {
      try {
        const canvas = document.createElement('canvas');
        canvas.width = img.naturalWidth || img.width;
        canvas.height = img.naturalHeight || img.height;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(img, 0, 0);
        resolve(canvas.toDataURL('image/png'));
      } catch (err) {
        resolve(null);
      }
    };
    img.onerror = () => resolve(null);
    img.src = url;
  });

  const exportListToCsv = () => {
    const rows = Array.isArray(exportRows) ? exportRows : [];
    const header = ['Fecha', 'Curso', 'Nombre', 'Institucion', 'Correo', 'Telefono', 'Edad', 'Genero', 'Cargo/Puesto'];
    const csvRows = [header];

    rows.forEach((row) => {
      csvRows.push([
        sanitizeText(row.created_at),
        sanitizeText(row.curso_nombre),
        sanitizeText(row.nombre_completo),
        sanitizeText(row.institucion),
        sanitizeText(row.correo),
        sanitizeText(row.telefono),
        sanitizeText(row.edad),
        sanitizeText(row.genero),
        sanitizeText(row.cargo_puesto)
      ]);
    });

    const csvContent = '\uFEFF' + csvRows.map((line) => line
      .map((cell) => `"${String(cell).replace(/"/g, '""')}"`)
      .join(',')
    ).join('\r\n');

    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = 'inscritos-curso.csv';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
  };

  const exportListToPdf = () => {
    if (!window.jspdf || !window.jspdf.jsPDF) {
      alert('No se pudo cargar el generador de PDF.');
      return;
    }

    const rows = Array.isArray(exportRows) ? exportRows : [];
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ orientation: 'landscape', unit: 'pt', format: 'a4' });
    const pageWidth = doc.internal.pageSize.getWidth();
    const pageHeight = doc.internal.pageSize.getHeight();
    const margin = 24;
    const usableWidth = pageWidth - (margin * 2);
    const rowHeightBase = 18;
    const cols = [
      { key: 'created_at', label: 'Fecha', width: 85 },
      { key: 'curso_nombre', label: 'Curso', width: 125 },
      { key: 'nombre_completo', label: 'Nombre', width: 120 },
      { key: 'institucion', label: 'Institución', width: 185 },
      { key: 'correo', label: 'Correo', width: 140 },
      { key: 'telefono', label: 'Teléfono', width: 85 },
    ];

    const meta = window.inscripcionesDashboardMeta || {};
    const fileSuffix = slugify(meta.cursoNombre || 'todos-los-cursos') || 'todos-los-cursos';
    const exportPdfBtn = document.getElementById('exportInscripcionesPdf');
    const originalBtnLabel = exportPdfBtn ? exportPdfBtn.textContent : '';
    let y = margin;

    const drawHeader = (logoDataUrl) => {
      doc.setFillColor(14, 39, 82);
      doc.rect(0, 0, pageWidth, 10, 'F');
      doc.setFillColor(184, 151, 75);
      doc.rect(0, 10, pageWidth, 4, 'F');

      if (logoDataUrl) {
        doc.addImage(logoDataUrl, 'PNG', margin, 24, 42, 42);
      }

      doc.setFont('helvetica', 'bold');
      doc.setFontSize(16);
      doc.setTextColor(14, 42, 96);
      doc.text('Tribunal de Justicia Administrativa del Estado de Chiapas', pageWidth / 2, 34, { align: 'center' });

      doc.setFont('helvetica', 'normal');
      doc.setFontSize(10);
      doc.setTextColor(95, 104, 120);
      doc.text('Listado de inscritos', pageWidth / 2, 52, { align: 'center' });
      const scopeLabel = String(meta.reportScope || 'Todos los cursos');
      const courseLabel = cleanCourseLabel(meta.cursoNombre || 'Todos los cursos');
      const scopeText = scopeLabel === 'Curso seleccionado'
        ? `Curso: ${courseLabel}`
        : `Alcance: ${courseLabel}`;
      doc.text(scopeText, pageWidth / 2, 68, { align: 'center' });
      if (sanitizeText(meta.filtroBusqueda)) {
        doc.text(`Búsqueda aplicada: ${sanitizeText(meta.filtroBusqueda)}`, pageWidth / 2, 82, { align: 'center' });
        doc.text(`Total: ${rows.length}`, pageWidth / 2, 96, { align: 'center' });
        y = 114;
      } else {
        doc.text(`Total: ${rows.length}`, pageWidth / 2, 82, { align: 'center' });
        y = 100;
      }

      doc.setFillColor(241, 244, 249);
      doc.setDrawColor(226, 231, 239);
      doc.rect(margin, y, usableWidth, 24, 'FD');

      let x = margin;
      doc.setFont('helvetica', 'bold');
      doc.setFontSize(9);
      doc.setTextColor(30, 34, 45);
      cols.forEach((col) => {
        doc.text(col.label, x + 4, y + 15);
        x += col.width;
      });
      y += 24;
    };

    if (exportPdfBtn) {
      exportPdfBtn.disabled = true;
      exportPdfBtn.textContent = 'Generando PDF...';
    }
    setPdfLoader(true, 'Generando listado de inscritos en PDF...');

    loadImageAsDataUrl(meta.logoUrl)
      .then((logoDataUrl) => {
        drawHeader(logoDataUrl);

        rows.forEach((row) => {
          const lineSets = cols.map((col) => doc.splitTextToSize(sanitizeText(row[col.key]), col.width - 8));
          const maxLines = Math.max(...lineSets.map((lines) => Math.max(1, lines.length)));
          const rowHeight = Math.max(rowHeightBase, maxLines * 10 + 8);

          if (y + rowHeight > pageHeight - 28) {
            doc.addPage();
            drawHeader(logoDataUrl);
          }

          doc.setFillColor(255, 255, 255);
          doc.setDrawColor(226, 231, 239);
          doc.rect(margin, y, usableWidth, rowHeight, 'FD');

          let x = margin;
          doc.setFont('helvetica', 'normal');
          doc.setFontSize(8);
          doc.setTextColor(30, 34, 45);
          lineSets.forEach((lines, idx) => {
            const textY = y + 12;
            lines.forEach((line, lineIdx) => {
              doc.text(String(line), x + 4, textY + (lineIdx * 10));
            });
            x += cols[idx].width;
          });

          y += rowHeight;
        });

        const finalNoteY = Math.min(pageHeight - 34, y + 16);
        doc.setFont('helvetica', 'italic');
        doc.setFontSize(9);
        doc.setTextColor(94, 102, 117);
        doc.text('Reporte generado por el Sistema de Evaluación TJAECH', pageWidth / 2, finalNoteY, { align: 'center' });

        doc.save(`listado-inscritos-${fileSuffix}.pdf`);
      })
      .finally(() => {
        if (exportPdfBtn) {
          exportPdfBtn.disabled = false;
          exportPdfBtn.textContent = originalBtnLabel;
        }
        setPdfLoader(false);
      });
  };

  charts.gender = createPieChart('genderPieChart', stats.gender, 'Distribución por género');
  charts.age = createPieChart('agePieChart', stats.age_ranges, 'Rangos de edad');

  charts.colectivos = createBarChart('colectivosBarChart', stats.colectivos, 'Colectivos registrados');

  const exportExcelBtn = document.getElementById('exportInscripcionesExcel');
  if (exportExcelBtn) {
    exportExcelBtn.addEventListener('click', exportListToCsv);
  }

  const exportPdfBtn = document.getElementById('exportInscripcionesPdf');
  if (exportPdfBtn) {
    exportPdfBtn.addEventListener('click', exportListToPdf);
  }

  const exportBtn = document.getElementById('exportDashboardPdf');
  if (!exportBtn) return;

  exportBtn.addEventListener('click', async () => {
    if (!window.jspdf || !window.jspdf.jsPDF) {
      alert('No se pudo cargar el generador de PDF.');
      return;
    }

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ orientation: 'landscape', unit: 'pt', format: 'a4' });
    const pageWidth = doc.internal.pageSize.getWidth();
    const pageHeight = doc.internal.pageSize.getHeight();
    const margin = 24;
    const contentW = pageWidth - (margin * 2);

    const meta = window.inscripcionesDashboardMeta || {};
    const now = new Date();
    const generated = now.toLocaleString('es-MX', {
      day: 'numeric',
      month: 'numeric',
      year: 'numeric',
      hour: 'numeric',
      minute: '2-digit',
      second: '2-digit',
      hour12: true,
    });

    const genderRows = orderedCountMap(stats.gender, [
      'Mujer', 'Hombre', 'No binario/otro', 'Prefiero no responder', 'Otro/No especificado'
    ]);
    const ageRows = orderedCountMap(stats.age_ranges, ['10-17', '18-25', '26-35', '36-45', '46-60', '61+']);
    const colectivosRows = orderedMapEntries(stats.colectivos);

    const drawCard = (x, y, w, h, fill = [255, 255, 255], border = [219, 225, 235]) => {
      doc.setFillColor(fill[0], fill[1], fill[2]);
      doc.setDrawColor(border[0], border[1], border[2]);
      doc.roundedRect(x, y, w, h, 8, 8, 'FD');
    };

    const drawKpi = (x, y, w, value, label) => {
      drawCard(x, y, w, 78, [255, 255, 255], [220, 225, 234]);
      doc.setFont('helvetica', 'bold');
      doc.setFontSize(24);
      doc.setTextColor(14, 42, 96);
      doc.text(String(value), x + (w / 2), y + 34, { align: 'center' });
      doc.setFont('helvetica', 'normal');
      doc.setFontSize(10);
      doc.setTextColor(95, 104, 120);
      doc.text(label, x + (w / 2), y + 58, { align: 'center' });
    };

    const drawSimpleTable = (x, y, w, title, rows) => {
      doc.setFont('helvetica', 'bold');
      doc.setTextColor(26, 30, 42);
      doc.setFontSize(10);
      doc.text(title, x + 8, y - 8);

      const cols = rows.length;
      const colW = w / cols;
      const headerH = 40;
      const valueH = 24;

      doc.setFillColor(241, 244, 249);
      doc.setDrawColor(226, 231, 239);
      doc.rect(x, y, w, headerH, 'FD');

      doc.setFontSize(9);
      rows.forEach((row, idx) => {
        const cx = x + (colW * idx) + (colW / 2);
        doc.setTextColor(30, 34, 45);
        const lines = doc.splitTextToSize(String(row.key), colW - 8);
        const lineHeight = 10;
        const blockH = lines.length * lineHeight;
        const startY = y + ((headerH - blockH) / 2) + 8;
        lines.forEach((line, lineIndex) => {
          doc.text(line, cx, startY + (lineIndex * lineHeight), { align: 'center' });
        });
      });

      doc.setFillColor(255, 255, 255);
      doc.rect(x, y + headerH, w, valueH, 'FD');
      rows.forEach((row, idx) => {
        const cx = x + (colW * idx) + (colW / 2);
        doc.setFont('helvetica', 'normal');
        doc.setTextColor(30, 34, 45);
        doc.text(String(row.value), cx, y + headerH + 15, { align: 'center' });
      });
    };

    const drawVerticalStatTable = (x, y, w, title, rows, maxRows = 10) => {
      const visibleRows = rows.length > 0 ? rows.slice(0, maxRows) : [{ key: 'Sin datos', value: 0 }];
      const headerH = 26;
      const rowH = 24;
      const tableH = headerH + (visibleRows.length * rowH);

      doc.setFont('helvetica', 'bold');
      doc.setTextColor(26, 30, 42);
      doc.setFontSize(11);
      doc.text(title, x, y - 8);

      doc.setFillColor(241, 244, 249);
      doc.setDrawColor(226, 231, 239);
      doc.rect(x, y, w, headerH, 'FD');

      doc.setFontSize(9);
      doc.setTextColor(30, 34, 45);
      doc.text('Colectivo', x + 10, y + 16);
      doc.text('Total', x + w - 10, y + 16, { align: 'right' });

      let currentY = y + headerH;
      visibleRows.forEach((row) => {
        doc.setFillColor(255, 255, 255);
        doc.rect(x, currentY, w, rowH, 'FD');
        doc.setFont('helvetica', 'normal');
        doc.text(String(row.key), x + 10, currentY + 15);
        doc.text(String(row.value), x + w - 10, currentY + 15, { align: 'right' });
        currentY += rowH;
      });

      return tableH;
    };

    const originalLabel = exportBtn.textContent;
    exportBtn.disabled = true;
    exportBtn.textContent = 'Generando PDF...';
    setPdfLoader(true, 'Generando reporte en PDF...');

    try {
      const genderImg = await buildHighResChartImage(stats.gender);
      const ageImg = await buildHighResChartImage(stats.age_ranges);
      const colectivosImg = await buildHighResChartImage(stats.colectivos);

      // Header bands
      doc.setFillColor(14, 39, 82);
      doc.rect(0, 0, pageWidth, 10, 'F');
      doc.setFillColor(184, 151, 75);
      doc.rect(0, 10, pageWidth, 4, 'F');

      // Title
      doc.setFont('helvetica', 'bold');
      doc.setFontSize(28);
      doc.setTextColor(14, 42, 96);
      doc.text('Estadística de Inscripciones', pageWidth / 2, 52, { align: 'center' });

      doc.setFontSize(16);
      doc.setTextColor(26, 30, 42);
      doc.text('Curso:', pageWidth / 2 - 45, 76, { align: 'right' });
      doc.setFont('helvetica', 'normal');
      doc.text(String(meta.cursoNombre || 'Todos los cursos'), pageWidth / 2 - 40, 76);

      doc.setFont('helvetica', 'bold');
      doc.text('Fecha de generación:', pageWidth / 2 - 45, 98, { align: 'right' });
      doc.setFont('helvetica', 'normal');
      doc.text(generated, pageWidth / 2 - 40, 98);

      // KPI row
      const kpiY = 116;
      const kGap = 12;
      const kW = (contentW - (kGap * 3)) / 4;
      drawKpi(margin, kpiY, kW, Number(stats.total || 0), 'Total inscritos');
      drawKpi(margin + (kW + kGap), kpiY, kW, Number(stats.age_avg || 0), 'Edad promedio');
      drawKpi(margin + ((kW + kGap) * 2), kpiY, kW, Number(stats.age_min || 0), 'Edad mínima');
      drawKpi(margin + ((kW + kGap) * 3), kpiY, kW, Number(stats.age_max || 0), 'Edad máxima');

      // Two main panels
      const panelY = 204;
      const panelGap = 12;
      const panelW = (contentW - panelGap) / 2;
      const panelH = 292;
      drawCard(margin, panelY, panelW, panelH);
      drawCard(margin + panelW + panelGap, panelY, panelW, panelH);

      doc.setFont('helvetica', 'bold');
      doc.setTextColor(18, 24, 38);
      doc.setFontSize(12);
      doc.text('Distribución por género', margin + panelW / 2, panelY + 22, { align: 'center' });
      doc.text('Rangos de edad', margin + panelW + panelGap + panelW / 2, panelY + 22, { align: 'center' });

      // Charts
      doc.addImage(genderImg, 'PNG', margin + 10, panelY + 28, panelW - 20, 180);
      doc.addImage(ageImg, 'PNG', margin + panelW + panelGap + 10, panelY + 28, panelW - 20, 180);

      // Count tables
      drawSimpleTable(margin + 10, panelY + 230, panelW - 20, 'Conteo por género', genderRows);
      drawSimpleTable(margin + panelW + panelGap + 10, panelY + 230, panelW - 20, 'Conteo por rangos de edad', ageRows);

      // Footer
      doc.setFont('helvetica', 'normal');
      doc.setFontSize(9);
      doc.setTextColor(94, 102, 117);
      doc.text('TJAECH - Sistema de Evaluación de Capacitaciones', pageWidth / 2, pageHeight - 16, { align: 'center' });

      // Page 2: Colectivos
      doc.addPage();
      doc.setFillColor(14, 39, 82);
      doc.rect(0, 0, pageWidth, 10, 'F');
      doc.setFillColor(184, 151, 75);
      doc.rect(0, 10, pageWidth, 4, 'F');

      doc.setFont('helvetica', 'bold');
      doc.setFontSize(24);
      doc.setTextColor(14, 42, 96);
      doc.text('Colectivos Registrados', pageWidth / 2, 48, { align: 'center' });

      doc.setFont('helvetica', 'normal');
      doc.setFontSize(11);
      doc.setTextColor(95, 104, 120);
      doc.text(String(meta.cursoNombre || 'Todos los cursos'), pageWidth / 2, 68, { align: 'center' });

      const collectivePanelY = 92;
      const collectivePanelW = contentW;
      const collectivePanelH = 420;
      drawCard(margin, collectivePanelY, collectivePanelW, collectivePanelH);

      doc.setFont('helvetica', 'bold');
      doc.setFontSize(12);
      doc.setTextColor(18, 24, 38);
      doc.text('Distribución por colectivos seleccionados', pageWidth / 2, collectivePanelY + 22, { align: 'center' });

      doc.addImage(colectivosImg, 'PNG', margin + 12, collectivePanelY + 34, collectivePanelW * 0.56, 300);
      drawVerticalStatTable(
        margin + (collectivePanelW * 0.62),
        collectivePanelY + 46,
        collectivePanelW * 0.30,
        'Conteo por colectivo',
        colectivosRows,
        11
      );

      doc.setFont('helvetica', 'normal');
      doc.setFontSize(9);
      doc.setTextColor(94, 102, 117);
      doc.text('TJAECH - Sistema de Evaluación de Capacitaciones', pageWidth / 2, pageHeight - 16, { align: 'center' });

      doc.save('estadistica-inscripciones.pdf');
    } finally {
      exportBtn.disabled = false;
      exportBtn.textContent = originalLabel;
      setPdfLoader(false);
    }
  });
})();
