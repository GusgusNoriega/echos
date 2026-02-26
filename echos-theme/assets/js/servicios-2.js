/* Slider Proyectos Destacados - Servicios Iluminación */
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
