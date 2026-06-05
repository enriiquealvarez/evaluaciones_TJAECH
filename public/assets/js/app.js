(() => {
  const form = document.getElementById('evaluacionForm');
  if (!form) return;

  const registro = document.getElementById('registroSection');
  const preguntas = document.getElementById('preguntasSection');
  const goQuestions = document.getElementById('goQuestions');
  const progress = document.getElementById('progressBar');
  const contactWarning = document.getElementById('contactWarning');
  const submitBtn = form.querySelector('button[type="submit"]');
  const verifyUrl = form.dataset.verifyUrl || '';
  const evaluacionId = form.dataset.evaluacionId || '';
  const cursoId = form.dataset.cursoId || '';

  const requiredFields = ['correo', 'telefono'];
  const correoInput = form.querySelector('input[name="correo"]');
  const telefonoInput = form.querySelector('input[name="telefono"]');
  let contactBlocked = false;
  let contactVerified = false;
  let checkingContact = false;
  let verifyTimer = null;
  let verifyController = null;

  const validateRegistro = () => {
    let ok = true;
    requiredFields.forEach(name => {
      const el = form.querySelector(`[name="${name}"]`);
      if (el && !el.value.trim()) {
        ok = false;
        el.classList.add('input-error');
      } else if (el) {
        el.classList.remove('input-error');
      }
    });
    return ok;
  };

  const setContactBlocked = (blocked, message) => {
    contactBlocked = blocked;
    contactVerified = !blocked;
    if (goQuestions) goQuestions.disabled = blocked || checkingContact;
    if (submitBtn) submitBtn.disabled = blocked;
    if (contactWarning) {
      if (blocked) {
        const safeMessage = (message || '').trim();
        if (safeMessage) {
          contactWarning.textContent = safeMessage;
          contactWarning.hidden = false;
        } else {
          contactWarning.hidden = true;
          contactWarning.textContent = '';
        }
      } else {
        contactWarning.hidden = true;
        contactWarning.textContent = '';
      }
    }
  };

  const setCheckingContact = (checking) => {
    checkingContact = checking;
    if (goQuestions) {
      goQuestions.disabled = checking || contactBlocked;
    }
  };

  const checkContact = (showInlineWarning = false) => {
    if (!verifyUrl || !cursoId || !correoInput || !telefonoInput) {
      return Promise.resolve(false);
    }
    const correo = correoInput.value.trim();
    const telefono = telefonoInput.value.trim();

    if (!correo && !telefono) {
      setContactBlocked(true, showInlineWarning ? 'Capture su correo y teléfono registrados para continuar.' : '');
      return Promise.resolve(false);
    }

    if (!correo || !telefono) {
      setContactBlocked(true, showInlineWarning ? 'Debe capturar correo y teléfono para validar acceso.' : '');
      return Promise.resolve(false);
    }

    if (verifyController) {
      verifyController.abort();
    }
    setCheckingContact(true);
    verifyController = new AbortController();
    const params = new URLSearchParams({
      evaluacion_id: evaluacionId,
      curso_id: cursoId,
      correo,
      telefono
    });

    return fetch(`${verifyUrl}?${params.toString()}`, { signal: verifyController.signal })
      .then(res => {
        if (!res.ok) {
          return Promise.reject(new Error('request_failed'));
        }
        return res.text().then(raw => {
          // Tolerate UTF-8 BOM or accidental output before JSON payload.
          const cleaned = (raw || '').replace(/^\uFEFF+/, '').trim();
          return JSON.parse(cleaned);
        });
      })
      .then(data => {
        if (!data || data.ok !== true) {
          setContactBlocked(true, 'No se pudo validar el acceso. Intente nuevamente.');
          return false;
        }
        setContactBlocked(!!data.exists, data.message || '');
        return !data.exists;
      })
      .catch(err => {
        if (err.name === 'AbortError') return;
        setContactBlocked(true, 'No se pudo validar el acceso. Revise su conexión e intente de nuevo.');
        return false;
      })
      .finally(() => {
        setCheckingContact(false);
      });
  };

  const scheduleCheck = () => {
    if (verifyTimer) clearTimeout(verifyTimer);
    verifyTimer = setTimeout(checkContact, 400);
  };

  const startTimer = (durationSeconds) => {
    const display = document.getElementById('timerDisplay');
    if (!display) return;

    let remaining = durationSeconds;

    const updateDisplay = () => {
      const minutes = Math.floor(remaining / 60);
      const seconds = remaining % 60;
      display.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    };

    updateDisplay();

    const timerInterval = setInterval(() => {
      remaining--;
      if (remaining <= 0) {
        remaining = 0;
        updateDisplay();
        clearInterval(timerInterval);
        alert('El tiempo de 30 minutos para responder la evaluación ha concluido. Sus respuestas se enviarán automáticamente.');
        form.submit();
      } else {
        updateDisplay();
        if (remaining <= 120) {
          const container = document.getElementById('timerContainer');
          if (container) {
            container.style.color = '#c53030';
            container.style.backgroundColor = '#fff5f5';
            container.style.borderColor = '#fc8181';
            container.style.animation = 'pulse 1s infinite alternate';
          }
        }
      }
    }, 1000);
  };

  if (goQuestions) {
    goQuestions.addEventListener('click', async () => {
      if (!validateRegistro()) {
        alert('Complete los datos obligatorios para continuar.');
        return;
      }
      const validated = await checkContact(true);
      if (!validated || checkingContact || contactBlocked || !contactVerified) {
        if (contactWarning) {
          contactWarning.hidden = false;
          contactWarning.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        return;
      }
      preguntas.hidden = false;
      registro.hidden = true;
      window.scrollTo({ top: preguntas.offsetTop - 20, behavior: 'smooth' });
      startTimer(1800);
    });
  }

  if (correoInput) correoInput.addEventListener('input', scheduleCheck);
  if (telefonoInput) telefonoInput.addEventListener('input', scheduleCheck);
  setContactBlocked(true, '');
  checkContact();

  const inputs = Array.from(form.querySelectorAll('input, textarea, select'))
    .filter(el => el.name && el.name.startsWith('answers'));

  const updateProgress = () => {
    const answered = inputs.filter(el => {
      if (el.type === 'radio') {
        return form.querySelector(`input[name="${el.name}"]:checked`);
      }
      return el.value && el.value.trim() !== '';
    }).length;
    const total = new Set(inputs.map(el => el.name)).size;
    const percent = total ? Math.min(100, Math.round((answered / total) * 100)) : 0;
    if (progress) {
      progress.querySelector('span').style.width = `${percent}%`;
    }
  };

  form.addEventListener('input', updateProgress);
  updateProgress();
})();
