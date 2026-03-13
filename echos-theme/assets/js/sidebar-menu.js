/**
 * ECHOS Sidebar Menu
 * - Toggle sidebar with hamburger button
 * - Accordion submenus
 * - Close with backdrop, close button, or Escape
 * - Lock body scroll while open
 */
(() => {
  const MOBILE_BREAKPOINT = 980;
  const mediaQuery = window.matchMedia(`(max-width: ${MOBILE_BREAKPOINT}px)`);

  const sidebar = document.getElementById('echosSidebar');
  const backdrop = document.getElementById('echosSidebarBackdrop');
  const hamburger = document.getElementById('echosHamburger');
  const closeBtn = document.getElementById('echosSidebarClose');

  if (!sidebar || !backdrop || !hamburger) return;

  function isMobileNavEnabled() {
    return mediaQuery.matches;
  }

  function openSidebar() {
    if (!isMobileNavEnabled()) return;

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
      return;
    }

    openSidebar();
  }

  function handleDesktopTransition() {
    if (!isMobileNavEnabled()) {
      closeSidebar();
    }
  }

  if (typeof mediaQuery.addEventListener === 'function') {
    mediaQuery.addEventListener('change', handleDesktopTransition);
  } else if (typeof mediaQuery.addListener === 'function') {
    mediaQuery.addListener(handleDesktopTransition);
  }

  // Safety fallback for older browsers and orientation changes.
  window.addEventListener('resize', handleDesktopTransition);

  hamburger.addEventListener('click', (event) => {
    event.preventDefault();
    event.stopPropagation();
    toggleSidebar();
  });

  if (closeBtn) {
    closeBtn.addEventListener('click', (event) => {
      event.preventDefault();
      closeSidebar();
    });
  }

  backdrop.addEventListener('click', closeSidebar);

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && sidebar.classList.contains('is-open')) {
      closeSidebar();
    }
  });

  const submenuToggles = sidebar.querySelectorAll('.echos-submenu-toggle');

  submenuToggles.forEach((toggle) => {
    toggle.addEventListener('click', (event) => {
      event.preventDefault();
      event.stopPropagation();

      const parentLi = toggle.closest('li');
      const submenu = parentLi ? parentLi.querySelector(':scope > ul') : null;

      if (!submenu) return;

      const siblings = parentLi.parentElement.querySelectorAll(':scope > li > ul.is-expanded');
      siblings.forEach((sibling) => {
        if (sibling === submenu) return;

        sibling.classList.remove('is-expanded');

        const siblingToggle = sibling.parentElement.querySelector(':scope > a .echos-submenu-toggle');
        if (siblingToggle) {
          siblingToggle.classList.remove('is-expanded');
        }
      });

      submenu.classList.toggle('is-expanded');
      toggle.classList.toggle('is-expanded');
    });
  });

  const menuLinks = sidebar.querySelectorAll('a');
  menuLinks.forEach((link) => {
    link.addEventListener('click', () => {
      const parentLi = link.closest('li');
      if (parentLi && parentLi.classList.contains('menu-item-has-children')) {
        return;
      }

      closeSidebar();
    });
  });

  handleDesktopTransition();
})();
