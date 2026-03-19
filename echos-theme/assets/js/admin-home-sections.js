(function () {
  const doc = window.document;

  function getDirectChild(parent, selector) {
    if (!parent) return null;
    return [...parent.children].find((child) => child.matches(selector)) || null;
  }

  function getRowsWrap(repeater) {
    return getDirectChild(repeater, '[data-home-rows]');
  }

  function getTemplate(repeater) {
    return getDirectChild(repeater, 'template[data-home-row-template]');
  }

  function getRows(repeater) {
    const rowsWrap = getRowsWrap(repeater);
    if (!rowsWrap) return [];
    return [...rowsWrap.children].filter((child) => child.matches('[data-home-row]'));
  }

  function getRepeaterToken(repeater) {
    return (repeater && repeater.getAttribute('data-home-index-token')) || '__index__';
  }

  function replaceToken(source, token, value) {
    if (typeof source !== 'string' || !source) return source;
    if (!token) return source;
    return source.split(token).join(String(value));
  }

  function updateImagePreview(field) {
    const input = field.querySelector('[data-home-image-input]');
    const preview = field.querySelector('[data-home-image-preview]');
    if (!input || !preview) return;

    const img = preview.querySelector('img');
    const url = (input.value || '').trim();

    if (!url) {
      preview.style.display = 'none';
      if (img) img.src = '';
      return;
    }

    if (img) img.src = url;
    preview.style.display = '';
  }

  function clearRow(row) {
    row.querySelectorAll('input, textarea, select').forEach((field) => {
      if (field.tagName === 'SELECT') {
        field.selectedIndex = 0;
      } else {
        field.value = '';
      }
    });

    row.querySelectorAll('[data-home-image-field]').forEach(updateImagePreview);
  }

  function renumberRepeater(repeater) {
    const token = getRepeaterToken(repeater);
    const rows = getRows(repeater);

    rows.forEach((row, index) => {
      row.querySelectorAll('[data-home-name-template]').forEach((field) => {
        const template = field.getAttribute('data-home-name-template');
        if (!template) return;
        if (!template.includes(token)) return;
        field.name = replaceToken(template, token, index);
      });
    });
  }

  function addRow(repeater) {
    const template = getTemplate(repeater);
    const rowsWrap = getRowsWrap(repeater);
    if (!template || !rowsWrap) return;

    const token = getRepeaterToken(repeater);
    const nextIndex = getRows(repeater).length;
    const html = replaceToken(template.innerHTML, token, nextIndex);
    rowsWrap.insertAdjacentHTML('beforeend', html);

    renumberRepeater(repeater);

    const rows = getRows(repeater);
    const lastRow = rows[rows.length - 1];
    if (!lastRow) return;

    lastRow.querySelectorAll('[data-home-image-field]').forEach(updateImagePreview);
    lastRow.querySelectorAll('[data-home-repeater]').forEach(renumberRepeater);
  }

  function removeRow(row) {
    const repeater = row.closest('[data-home-repeater]');
    if (!repeater) return;

    const rows = getRows(repeater);
    if (rows.length <= 1) {
      clearRow(row);
      return;
    }

    row.remove();
    renumberRepeater(repeater);
  }

  function pickImage(field) {
    if (!window.wp || !wp.media) return;

    const input = field.querySelector('[data-home-image-input]');
    if (!input) return;

    const frame = wp.media({
      title: (window.echosHomeAdmin && window.echosHomeAdmin.mediaTitle) || 'Seleccionar imagen',
      button: {
        text: (window.echosHomeAdmin && window.echosHomeAdmin.mediaButton) || 'Usar imagen'
      },
      multiple: false
    });

    frame.on('select', () => {
      const selection = frame.state().get('selection').first();
      if (!selection) return;

      const attachment = selection.toJSON();
      input.value = attachment.url || '';
      updateImagePreview(field);
    });

    frame.open();
  }

  doc.addEventListener('click', (event) => {
    const addButton = event.target.closest('[data-home-add-row]');
    if (addButton) {
      event.preventDefault();
      const repeater = addButton.closest('[data-home-repeater]');
      if (repeater) addRow(repeater);
      return;
    }

    const removeButton = event.target.closest('[data-home-remove-row]');
    if (removeButton) {
      event.preventDefault();
      const row = removeButton.closest('[data-home-row]');
      if (row) removeRow(row);
      return;
    }

    const pickButton = event.target.closest('[data-home-image-pick]');
    if (pickButton) {
      event.preventDefault();
      const field = pickButton.closest('[data-home-image-field]');
      if (field) pickImage(field);
      return;
    }

    const clearButton = event.target.closest('[data-home-image-clear]');
    if (clearButton) {
      event.preventDefault();
      const field = clearButton.closest('[data-home-image-field]');
      if (!field) return;

      const input = field.querySelector('[data-home-image-input]');
      if (input) input.value = '';
      updateImagePreview(field);
    }
  });

  doc.addEventListener('input', (event) => {
    const input = event.target.closest('[data-home-image-input]');
    if (!input) return;

    const field = input.closest('[data-home-image-field]');
    if (field) updateImagePreview(field);
  });

  doc.querySelectorAll('[data-home-repeater]').forEach(renumberRepeater);
  doc.querySelectorAll('[data-home-image-field]').forEach(updateImagePreview);
})();
