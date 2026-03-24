(() => {
  const container = document.getElementById('questionsContainer');
  const addBtn = document.getElementById('addQuestion');
  const form = document.getElementById('builderForm');
  if (!container || !addBtn || !form) return;

  const createOptionRow = (qIndex, oIndex) => {
    const row = document.createElement('div');
    row.className = 'option-row';
    row.innerHTML = `
      <input type="text" name="questions[${qIndex}][opciones][${oIndex}][texto]" placeholder="Texto" required>
      <input type="hidden" name="questions[${qIndex}][opciones][${oIndex}][valor]" value="">
      <label class="option-correct">
        <input type="checkbox" name="questions[${qIndex}][opciones][${oIndex}][es_correcta]"> Correcta
      </label>
      <button type="button" class="btn btn-danger btn-sm remove-option">X</button>
    `;
    return row;
  };

  const createQuestionBlock = (index) => {
    const block = document.createElement('div');
    block.className = 'question-block';
    block.dataset.index = index;
    block.innerHTML = `
      <div class="question-block-header">
        <strong>Pregunta ${index + 1}</strong>
        <div class="question-actions">
          <button type="button" class="btn btn-secondary btn-sm move-up">Subir</button>
          <button type="button" class="btn btn-secondary btn-sm move-down">Bajar</button>
          <button type="button" class="btn btn-danger btn-sm remove-question">Quitar</button>
        </div>
      </div>
      <label>Texto
        <input type="text" name="questions[${index}][texto]" required>
      </label>
      <label>Tipo
        <select name="questions[${index}][tipo]" class="question-type">
          <option value="opcion">Opción múltiple</option>
          <option value="likert">Escala Likert</option>
          <option value="si_no">Sí/No</option>
          <option value="abierta">Abierta</option>
        </select>
      </label>
      <label class="checkbox">
        <input type="checkbox" name="questions[${index}][requerido]"> Respuesta obligatoria
      </label>
      <div class="options-container">
        <div class="options-header">
          <strong>Opciones</strong>
          <button type="button" class="btn btn-secondary btn-sm add-option">Agregar opción</button>
          <button type="button" class="btn btn-secondary btn-sm dedupe-options">Limpiar duplicadas</button>
        </div>
        <div class="options-list"></div>
      </div>
    `;
    return block;
  };

  const updateQuestionTitles = () => {
    const blocks = container.querySelectorAll('.question-block');
    blocks.forEach((block, idx) => {
      block.dataset.index = idx;
      block.querySelector('strong').textContent = `Pregunta ${idx + 1}`;
      const inputs = block.querySelectorAll('input, select');
      inputs.forEach(input => {
        input.name = input.name.replace(/questions\[\d+\]/, `questions[${idx}]`);
      });
    });
  };

  const toggleOptions = (block) => {
    const type = block.querySelector('.question-type').value;
    const options = block.querySelector('.options-container');
    if (type === 'abierta') {
      options.style.display = 'none';
    } else {
      options.style.display = 'block';
    }
  };

  const ensureErrorBox = (block) => {
    let box = block.querySelector('.option-dup-error');
    if (!box) {
      box = document.createElement('div');
      box.className = 'option-dup-error';
      box.style.color = 'var(--magenta-strong)';
      box.style.fontSize = '0.9rem';
      box.style.marginTop = '6px';
      const list = block.querySelector('.options-list');
      list.insertAdjacentElement('afterend', box);
    }
    return box;
  };

  const ensureSuggestBox = (block) => {
    let box = block.querySelector('.option-dup-suggest');
    if (!box) {
      box = document.createElement('div');
      box.className = 'option-dup-suggest';
      box.style.color = '#6b6b6b';
      box.style.fontSize = '0.85rem';
      box.style.marginTop = '4px';
      const err = ensureErrorBox(block);
      err.insertAdjacentElement('afterend', box);
    }
    return box;
  };

  const setDupHint = (row, message) => {
    let hint = row.querySelector('.option-dup-hint');
    const input = row.querySelector('input[type="text"]');
    if (message) {
      if (input) input.title = message;
      if (!hint) {
        hint = document.createElement('span');
        hint.className = 'option-dup-hint';
        hint.textContent = message;
        hint.style.color = 'var(--magenta-strong)';
        hint.style.fontSize = '0.75rem';
        hint.style.marginLeft = '8px';
        input && input.insertAdjacentElement('afterend', hint);
      } else {
        hint.textContent = message;
      }
    } else {
      if (input) input.removeAttribute('title');
      if (hint) hint.remove();
    }
  };

  const normalize = (value) => {
    let v = value.trim().toLowerCase()
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, '')
      .replace(/[^a-z0-9]+/g, '')
      .trim();
    v = v.replace(/\d+/g, (m) => String(parseInt(m, 10)));
    return v;
  };

  const validateOptions = (block) => {
    const type = block.querySelector('.question-type').value;
    const rows = Array.from(block.querySelectorAll('.option-row'));
    rows.forEach(r => {
      const input = r.querySelector('input[type="text"]');
      if (input) input.classList.remove('input-error');
      setDupHint(r, '');
    });
    const errorBox = ensureErrorBox(block);
    errorBox.textContent = '';
    const suggestBox = ensureSuggestBox(block);
    suggestBox.textContent = '';
    block.classList.remove('has-dup');

    if (type === 'abierta') {
      return false;
    }

    const seen = new Map();
    const duplicates = new Set();
    const dupNumbers = [];
    rows.forEach(r => {
      const textInput = r.querySelector('input[type="text"]');
      const hidden = r.querySelector('input[type="hidden"]');
      const raw = (hidden && hidden.value ? hidden.value : (textInput ? textInput.value : '')) || '';
      const key = normalize(raw);
      if (!key) return;
      if (seen.has(key)) {
        duplicates.add(key);
        seen.get(key).push(textInput);
        if (/^\d+$/.test(key)) {
          dupNumbers.push(parseInt(key, 10));
        }
      } else {
        seen.set(key, [textInput]);
      }
    });

    if (duplicates.size > 0) {
      block.classList.add('has-dup');
      duplicates.forEach(key => {
        const inputs = seen.get(key) || [];
        inputs.forEach(inp => {
          if (inp) inp.classList.add('input-error');
        });
        const rowsToMark = inputs.map(inp => inp && inp.closest('.option-row')).filter(Boolean);
        rowsToMark.forEach(row => setDupHint(row, 'Duplicada'));
      });
      const values = Array.from(duplicates).join(', ');
      const qNum = (parseInt(block.dataset.index || '0', 10) + 1);
      errorBox.textContent = `Pregunta ${qNum}: opciones duplicadas: ${values}`;
      if (dupNumbers.length > 0) {
        const base = dupNumbers[0];
        const suggestion = `${base}, ${base + 1}, ${base + 2}`;
        suggestBox.textContent = `Sugerencia: si era secuencia, prueba ${suggestion}.`;
      }
      return values;
    }
    return '';
  };

  const validateAll = () => {
    const messages = [];
    container.querySelectorAll('.question-block').forEach(block => {
      const dupValues = validateOptions(block);
      if (dupValues) {
        const qNum = (parseInt(block.dataset.index || '0', 10) + 1);
        messages.push(`Pregunta ${qNum}: ${dupValues}`);
      }
    });
    setGlobalAlert(messages);
    return messages.length > 0;
  };

  const ensureGlobalAlert = () => {
    let alert = form.querySelector('.option-dup-global');
    if (!alert) {
      alert = document.createElement('div');
      alert.className = 'alert alert-magenta option-dup-global';
      alert.style.display = 'none';
      alert.style.marginBottom = '12px';
      form.insertAdjacentElement('afterbegin', alert);
    }
    return alert;
  };

  const setGlobalAlert = (messages) => {
    const alert = ensureGlobalAlert();
    if (messages.length > 0) {
      alert.textContent = `Hay opciones duplicadas. Corrige las marcadas en rojo: ${messages.join(' | ')}`;
      alert.style.display = '';
    } else {
      alert.textContent = '';
      alert.style.display = 'none';
    }
  };

  addBtn.addEventListener('click', () => {
    const block = createQuestionBlock(container.children.length);
    container.appendChild(block);
  });

  container.addEventListener('click', (e) => {
    if (e.target.classList.contains('remove-question')) {
      e.target.closest('.question-block').remove();
      updateQuestionTitles();
    }
    if (e.target.classList.contains('move-up')) {
      const block = e.target.closest('.question-block');
      const prev = block.previousElementSibling;
      if (prev) {
        container.insertBefore(block, prev);
        updateQuestionTitles();
      }
    }
    if (e.target.classList.contains('move-down')) {
      const block = e.target.closest('.question-block');
      const next = block.nextElementSibling;
      if (next) {
        container.insertBefore(next, block);
        updateQuestionTitles();
      }
    }
    if (e.target.classList.contains('add-option')) {
      const block = e.target.closest('.question-block');
      const list = block.querySelector('.options-list');
      const qIndex = parseInt(block.dataset.index, 10);
      const oIndex = list.children.length;
      list.appendChild(createOptionRow(qIndex, oIndex));
      validateOptions(block);
      validateAll();
    }
    if (e.target.classList.contains('dedupe-options')) {
      const block = e.target.closest('.question-block');
      const rows = Array.from(block.querySelectorAll('.option-row'));
      const seen = new Set();
      rows.forEach(row => {
        const textInput = row.querySelector('input[type="text"]');
        const hidden = row.querySelector('input[type="hidden"]');
        const raw = (hidden && hidden.value ? hidden.value : (textInput ? textInput.value : '')) || '';
        const key = normalize(raw);
        if (!key) return;
        if (seen.has(key)) {
          row.remove();
        } else {
          seen.add(key);
        }
      });
      validateOptions(block);
      validateAll();
    }
    if (e.target.classList.contains('remove-option')) {
      const block = e.target.closest('.question-block');
      e.target.closest('.option-row').remove();
      validateOptions(block);
      validateAll();
    }
  });

  container.addEventListener('change', (e) => {
    if (e.target.classList.contains('question-type')) {
      const block = e.target.closest('.question-block');
      toggleOptions(block);
      validateOptions(block);
      validateAll();
    }
  });

  container.addEventListener('input', (e) => {
    if (e.target.matches('input[name$="[texto]"]')) {
      const row = e.target.closest('.option-row');
      const hidden = row.querySelector('input[type="hidden"]');
      if (hidden) {
        hidden.value = e.target.value;
      }
      validateOptions(e.target.closest('.question-block'));
      validateAll();
    }
  });

  form.addEventListener('submit', (e) => {
    const hasDupes = validateAll();
    if (hasDupes) {
      e.preventDefault();
      const first = container.querySelector('.input-error');
      if (first) {
        first.scrollIntoView({ behavior: 'smooth', block: 'center' });
        first.focus();
      }
    }
  });

  container.querySelectorAll('.question-block').forEach(toggleOptions);
  container.querySelectorAll('.question-block').forEach(validateOptions);
  validateAll();
})();


