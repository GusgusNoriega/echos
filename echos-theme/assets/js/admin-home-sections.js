(function () {
  const doc = window.document;

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
    const rows = [...repeater.querySelectorAll('[data-home-row]')];

    rows.forEach((row, index) => {
      row.querySelectorAll('[data-home-name-template]').forEach((field) => {
        const template = field.getAttribute('data-home-name-template');
        if (!template) return;
        field.name = template.replace(/__index__/g, String(index));
      });
    });
  }

  function addRow(repeater) {
    const template = repeater.querySelector('[data-home-row-template]');
    const rowsWrap = repeater.querySelector('[data-home-rows]');
    if (!template || !rowsWrap) return;

    const nextIndex = rowsWrap.querySelectorAll('[data-home-row]').length;
    const html = template.innerHTML.replace(/__index__/g, String(nextIndex));
    rowsWrap.insertAdjacentHTML('beforeend', html);

    renumberRepeater(repeater);

    const lastRow = rowsWrap.querySelector('[data-home-row]:last-child');
    if (!lastRow) return;

    lastRow.querySelectorAll('[data-home-image-field]').forEach(updateImagePreview);
  }

  function removeRow(row) {
    const repeater = row.closest('[data-home-repeater]');
    if (!repeater) return;

    const rows = repeater.querySelectorAll('[data-home-row]');
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
