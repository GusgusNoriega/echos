/**
 * ECHOS Sidebar Menu
 * - Toggle sidebar con botón hamburguesa (inferior izquierdo)
 * - Sub-menús acordeón
 * - Cierre con backdrop, botón X, tecla Escape
 * - Bloqueo de scroll del body
 */
(() => {
  const sidebar   = document.getElementById('echosSidebar');
  const backdrop  = document.getElementById('echosSidebarBackdrop');
  const hamburger = document.getElementById('echosHamburger');
  const closeBtn  = document.getElementById('echosSidebarClose');

  if (!sidebar || !hamburger) return;

  /* ── Abrir / Cerrar ── */
  function openSidebar() {
    sidebar.classList.add('is-open');
    backdrop.classList.add('is-visible');
    hamburger.classList.add('is-active');
    document.body.classList.add('echos-sidebar--lock');
    hamburger.setAttribute('aria-expanded', 'true');
    sidebar.setAttribute('aria-hidden', 'false');
  }

  function closeSidebar() {
    sidebar.classList.remove('is-open');
    backdrop.classList.remove('is-visible');
    hamburger.classList.remove('is-active');
    document.body.classList.remove('echos-sidebar--lock');
    hamburger.setAttribute('aria-expanded', 'false');
    sidebar.setAttribute('aria-hidden', 'true');
  }

  function toggleSidebar() {
    if (sidebar.classList.contains('is-open')) {
      closeSidebar();
    } else {
      openSidebar();
    }
  }

  /* ── Event Listeners ── */
  hamburger.addEventListener('click', (e) => {
    e.preventDefault();
    e.stopPropagation();
    toggleSidebar();
  });

  if (closeBtn) {
    closeBtn.addEventListener('click', (e) => {
      e.preventDefault();
      closeSidebar();
    });
  }

  if (backdrop) {
    backdrop.addEventListener('click', closeSidebar);
  }

  // Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && sidebar.classList.contains('is-open')) {
      closeSidebar();
    }
  });

  /* ── Sub-menú toggle (acordeón) ── */
  const submenuToggles = sidebar.querySelectorAll('.echos-submenu-toggle');

  submenuToggles.forEach((toggle) => {
    toggle.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();

      const parentLi = toggle.closest('li');
      const submenu  = parentLi.querySelector(':scope > ul');

      if (!submenu) return;

      const isExpanded = submenu.classList.contains('is-expanded');

      // Cerrar todos los sub-menús hermanos (acordeón)
      const siblings = parentLi.parentElement.querySelectorAll(':scope > li > ul.is-expanded');
      siblings.forEach((sibling) => {
        if (sibling !== submenu) {
          sibling.classList.remove('is-expanded');
          const siblingToggle = sibling.parentElement.querySelector(':scope > a .echos-submenu-toggle');
          if (siblingToggle) siblingToggle.classList.remove('is-expanded');
        }
      });

      // Toggle actual
      submenu.classList.toggle('is-expanded');
      toggle.classList.toggle('is-expanded');
    });
  });

  /* ── Cerrar sidebar al hacer click en un link (mobile) ── */
  const menuLinks = sidebar.querySelectorAll('a:not(.echos-submenu-toggle)');
  menuLinks.forEach((link) => {
    link.addEventListener('click', () => {
      // Solo cerrar si no tiene sub-menú
      const parentLi = link.closest('li');
      if (parentLi && parentLi.classList.contains('menu-item-has-children')) {
        // No cerrar, solo toggle submenu
        return;
      }
      closeSidebar();
    });
  });
})();
