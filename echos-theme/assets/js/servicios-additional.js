(function () {
  const sections = Array.from(document.querySelectorAll(".srv-additional"));
  if (!sections.length) {
    return;
  }

  function splitLines(value) {
    return String(value || "")
      .split(/\r\n|\r|\n/)
      .map((line) => line.trim())
      .filter(Boolean);
  }

  sections.forEach((section) => {
    if (section.dataset.additionalInit === "1") {
      return;
    }
    section.dataset.additionalInit = "1";

    const track = section.querySelector(".srv-additional__track");
    const cards = track ? Array.from(track.querySelectorAll(".srv-additional__card")) : [];
    const prevBtn = section.querySelector(".srv-additional__arrow--prev");
    const nextBtn = section.querySelector(".srv-additional__arrow--next");
    const dotsWrap = section.querySelector(".srv-additional__dots");
    let pageIndex = 0;

    const visibleCards = () => (window.innerWidth <= 720 ? 1 : 2);
    const totalPages = () => Math.max(Math.ceil(cards.length / visibleCards()), 1);

    function updateArrows() {
      const pages = totalPages();
      if (prevBtn) {
        prevBtn.disabled = pageIndex <= 0;
      }
      if (nextBtn) {
        nextBtn.disabled = pageIndex >= pages - 1;
      }
    }

    function buildDots() {
      if (!dotsWrap) {
        return;
      }

      dotsWrap.innerHTML = "";
      const pages = totalPages();
      for (let i = 0; i < pages; i += 1) {
        const dot = document.createElement("button");
        dot.type = "button";
        dot.className = "srv-additional__dot" + (i === pageIndex ? " srv-additional__dot--active" : "");
        dot.setAttribute("aria-label", "Ir al slide " + (i + 1));
        dot.addEventListener("click", () => {
          pageIndex = i;
          updateSlider();
        });
        dotsWrap.appendChild(dot);
      }
    }

    function updateSlider() {
      if (!track || !cards.length) {
        return;
      }

      const pages = totalPages();
      pageIndex = Math.max(0, Math.min(pageIndex, pages - 1));

      const firstCard = cards[0];
      const cardWidth = firstCard.offsetWidth;
      const trackStyles = window.getComputedStyle(track);
      const gapValue = parseFloat(trackStyles.columnGap || trackStyles.gap || "0");
      const gap = Number.isFinite(gapValue) ? gapValue : 0;
      const offset = pageIndex * visibleCards() * (cardWidth + gap);
      track.style.transform = "translateX(-" + offset + "px)";

      buildDots();
      updateArrows();
    }

    if (prevBtn) {
      prevBtn.addEventListener("click", () => {
        pageIndex -= 1;
        updateSlider();
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener("click", () => {
        pageIndex += 1;
        updateSlider();
      });
    }

    if (track && cards.length) {
      updateSlider();
      window.addEventListener("resize", updateSlider);
    }

    const modal = section.querySelector(".srv-additional-modal");
    if (!modal) {
      return;
    }

    const modalImage = modal.querySelector(".srv-additional-modal__image");
    const modalTitle = modal.querySelector(".srv-additional-modal__title");
    const modalDescription = modal.querySelector(".srv-additional-modal__description");
    const modalFeaturesWrap = modal.querySelector(".srv-additional-modal__features-wrap");
    const modalFeaturesTitle = modal.querySelector(".srv-additional-modal__features-title");
    const modalFeaturesList = modal.querySelector(".srv-additional-modal__features");
    const modalClosePrimary = modal.querySelector(".srv-additional-modal__close");
    const openButtons = Array.from(section.querySelectorAll(".js-srv-additional-open"));
    const closeButtons = Array.from(modal.querySelectorAll(".js-srv-additional-close"));
    let activeTrigger = null;

    function populateModal(button) {
      if (modalImage) {
        modalImage.src = button.dataset.popupImage || "";
        modalImage.alt = button.dataset.popupImageAlt || "";
      }

      if (modalTitle) {
        modalTitle.textContent = button.dataset.popupTitle || "";
      }

      if (modalDescription) {
        modalDescription.textContent = button.dataset.popupDescription || "";
      }

      if (modalFeaturesTitle) {
        modalFeaturesTitle.textContent = button.dataset.popupFeaturesTitle || "Caracteristicas";
      }

      if (modalFeaturesList) {
        modalFeaturesList.innerHTML = "";
        const lines = splitLines(button.dataset.popupFeatures);
        lines.forEach((line) => {
          const li = document.createElement("li");
          li.textContent = line;
          modalFeaturesList.appendChild(li);
        });

        if (modalFeaturesWrap) {
          if (lines.length) {
            modalFeaturesWrap.classList.remove("is-hidden");
          } else {
            modalFeaturesWrap.classList.add("is-hidden");
          }
        }
      }
    }

    function openModal(button) {
      populateModal(button);
      activeTrigger = button;
      modal.setAttribute("aria-hidden", "false");
      document.body.classList.add("srv-modal-lock");

      if (modalClosePrimary) {
        modalClosePrimary.focus();
      }
    }

    function closeModal() {
      if (modal.getAttribute("aria-hidden") === "true") {
        return;
      }

      modal.setAttribute("aria-hidden", "true");
      document.body.classList.remove("srv-modal-lock");

      if (activeTrigger) {
        activeTrigger.focus();
      }
      activeTrigger = null;
    }

    openButtons.forEach((button) => {
      button.addEventListener("click", () => openModal(button));
    });

    closeButtons.forEach((button) => {
      button.addEventListener("click", closeModal);
    });

    document.addEventListener("keydown", (event) => {
      if (event.key === "Escape" && modal.getAttribute("aria-hidden") === "false") {
        closeModal();
      }
    });
  });
})();
