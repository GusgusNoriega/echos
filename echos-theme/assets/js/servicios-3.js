/* Slider Proyectos Destacados - Servicios Stands */
(function(){
  const track = document.querySelector('.srv-featured__track');
  if(!track) return;
  const cards = track.querySelectorAll('.srv-featured__card');
  const prevBtn = document.querySelector('.srv-featured__arrow--prev');
  const nextBtn = document.querySelector('.srv-featured__arrow--next');
  let idx = 0;
  const visible = () => window.innerWidth <= 720 ? 1 : window.innerWidth <= 980 ? 2 : 3;
  const gap = 28;

  function update(){
    const v = visible();
    const max = Math.max(cards.length - v, 0);
    if(idx > max) idx = max;
    if(idx < 0) idx = 0;
    const card = cards[0];
    const w = card.offsetWidth + gap;
    track.style.transform = `translateX(-${idx * w}px)`;
  }

  prevBtn.addEventListener('click', ()=>{ idx--; update(); });
  nextBtn.addEventListener('click', ()=>{ idx++; update(); });
  window.addEventListener('resize', update);
  update();
})();

/* Slider Servicios Adicionales */
(function(){
  const track = document.querySelector('.srv-additional__track');
  if(!track) return;
  const cards = track.querySelectorAll('.srv-additional__card');
  const prevBtn = document.querySelector('.srv-additional__arrow--prev');
  const nextBtn = document.querySelector('.srv-additional__arrow--next');
  const dotsWrap = document.querySelector('.srv-additional__dots');
  let idx = 0;
  const visible = () => window.innerWidth <= 720 ? 1 : 2;
  const gap = 28;

  function totalPages(){ return Math.max(Math.ceil(cards.length / visible()) , 1); }

  function buildDots(){
    dotsWrap.innerHTML = '';
    const pages = totalPages();
    for(let i = 0; i < pages; i++){
      const dot = document.createElement('span');
      dot.className = 'srv-additional__dot' + (i === idx ? ' srv-additional__dot--active' : '');
      dot.addEventListener('click', ()=>{ idx = i; update(); });
      dotsWrap.appendChild(dot);
    }
  }

  function update(){
    const v = visible();
    const pages = totalPages();
    if(idx >= pages) idx = pages - 1;
    if(idx < 0) idx = 0;
    const card = cards[0];
    const w = card.offsetWidth + gap;
    const offset = idx * v * w;
    track.style.transform = `translateX(-${offset}px)`;
    buildDots();
  }

  prevBtn.addEventListener('click', ()=>{ idx--; update(); });
  nextBtn.addEventListener('click', ()=>{ idx++; update(); });
  window.addEventListener('resize', update);
  update();
})();

/* Slider Mobiliario en Alquiler */
(function(){
  const track = document.querySelector('.srv-furniture__track');
  if(!track) return;
  const cards = Array.from(track.querySelectorAll('.srv-furniture__card'));
  const slider = document.querySelector('.srv-furniture__slider');
  let idx = 0;
  let isDown = false, startX, scrollLeft;

  function getCardWidth(){
    if(!cards.length) return 0;
    const style = getComputedStyle(track);
    const gap = parseInt(style.gap) || 24;
    return cards[0].offsetWidth + gap;
  }

  function getVisibleCount(){
    const w = window.innerWidth;
    if(w <= 520) return 1;
    if(w <= 720) return 2;
    if(w <= 980) return 3;
    return 4;
  }

  function update(){
    const v = getVisibleCount();
    const max = Math.max(cards.length - v, 0);
    if(idx > max) idx = max;
    if(idx < 0) idx = 0;
    const cw = getCardWidth();
    track.style.transform = `translateX(-${idx * cw}px)`;

    cards.forEach((card, i) => {
      if(i < idx || i >= idx + v){
        card.style.opacity = '0.35';
        card.style.pointerEvents = 'none';
      } else if(i === idx || i === idx + v - 1){
        card.style.opacity = '1';
        card.style.pointerEvents = 'auto';
      } else {
        card.style.opacity = '1';
        card.style.pointerEvents = 'auto';
      }
    });

    if(idx > 0 && cards[idx - 1]){
      cards[idx - 1].style.opacity = '0.35';
    }
    if(idx + v < cards.length && cards[idx + v]){
      cards[idx + v].style.opacity = '0.35';
    }
  }

  let autoInterval = setInterval(()=>{
    const v = getVisibleCount();
    const max = Math.max(cards.length - v, 0);
    idx = idx >= max ? 0 : idx + 1;
    update();
  }, 4000);

  function resetAuto(){
    clearInterval(autoInterval);
    autoInterval = setInterval(()=>{
      const v = getVisibleCount();
      const max = Math.max(cards.length - v, 0);
      idx = idx >= max ? 0 : idx + 1;
      update();
    }, 4000);
  }

  slider.addEventListener('mousedown', (e)=>{
    isDown = true;
    startX = e.pageX;
    slider.style.cursor = 'grabbing';
  });
  slider.addEventListener('mouseleave', ()=>{ isDown = false; slider.style.cursor = ''; });
  slider.addEventListener('mouseup', ()=>{ isDown = false; slider.style.cursor = ''; });
  slider.addEventListener('mousemove', (e)=>{
    if(!isDown) return;
    e.preventDefault();
    const diff = e.pageX - startX;
    if(Math.abs(diff) > 60){
      if(diff < 0) idx++;
      else idx--;
      update();
      resetAuto();
      isDown = false;
      slider.style.cursor = '';
    }
  });

  let touchStartX = 0;
  slider.addEventListener('touchstart', (e)=>{ touchStartX = e.touches[0].clientX; }, {passive:true});
  slider.addEventListener('touchend', (e)=>{
    const diff = e.changedTouches[0].clientX - touchStartX;
    if(Math.abs(diff) > 50){
      if(diff < 0) idx++;
      else idx--;
      update();
      resetAuto();
    }
  });

  window.addEventListener('resize', update);
  update();
})();
