const menuToggle = document.querySelector('.menu-toggle');
const navLinks = document.querySelector('.nav-links');
if(menuToggle && navLinks){
  menuToggle.addEventListener('click',()=>{
    const open=navLinks.classList.toggle('open');
    menuToggle.setAttribute('aria-expanded',String(open));
  });
}
document.querySelectorAll('.nav-links a').forEach(a=>{
  a.addEventListener('click',()=>{
    navLinks?.classList.remove('open');
    menuToggle?.setAttribute('aria-expanded','false');
  });
});

const navbar=document.querySelector('.navbar');
window.addEventListener('scroll',()=>{
  navbar?.classList.toggle('scrolled',window.scrollY>20);
});

const reveals=document.querySelectorAll('.reveal');
if('IntersectionObserver' in window){
  const observer=new IntersectionObserver(entries=>{
    entries.forEach(entry=>{
      if(entry.isIntersecting){
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  },{threshold:.12});
  reveals.forEach(el=>observer.observe(el));
}else{
  reveals.forEach(el=>el.classList.add('visible'));
}

const counters=document.querySelectorAll('[data-count]');
if('IntersectionObserver' in window){
  const counterObserver=new IntersectionObserver(entries=>{
    entries.forEach(entry=>{
      if(!entry.isIntersecting)return;
      const el=entry.target;
      const target=parseInt(el.dataset.count,10);
      const duration=1300;
      const startTime=performance.now();
      const tick=now=>{
        const progress=Math.min((now-startTime)/duration,1);
        el.textContent=Math.floor(progress*target)+'+';
        if(progress<1)requestAnimationFrame(tick);
      };
      requestAnimationFrame(tick);
      counterObserver.unobserve(el);
    });
  },{threshold:.7});
  counters.forEach(el=>counterObserver.observe(el));
}

/* Realisations category filters */
const galleryItems=[...document.querySelectorAll('.gallery-item')];
const galleryFilters=[...document.querySelectorAll('.gallery-filter')];
const galleryCount=document.querySelector('#galleryCount');
if(galleryItems.length && galleryFilters.length){
  const applyFilter=(filter)=>{
    let count=0;
    galleryItems.forEach(item=>{
      const visible=filter==='all'||item.dataset.category===filter;
      item.classList.toggle('is-hidden',!visible);
      if(visible)count++;
    });
    if(galleryCount)galleryCount.textContent=count;
  };
  galleryFilters.forEach(button=>{
    button.addEventListener('click',()=>{
      galleryFilters.forEach(btn=>{
        const active=btn===button;
        btn.classList.toggle('is-active',active);
        btn.setAttribute('aria-selected',String(active));
      });
      applyFilter(button.dataset.filter);
    });
  });
}

/* Realisations lightbox */
const lightbox=document.querySelector('#lightbox');
const lightboxImage=document.querySelector('#lightboxImage');
const lightboxTitle=document.querySelector('#lightboxTitle');
const lightboxCategory=document.querySelector('#lightboxCategory');
const lightboxClose=document.querySelector('.lightbox-close');
const openLightbox=(item)=>{
  if(!lightbox||!lightboxImage)return;
  const img=item.querySelector('img');
  lightboxImage.src=img.currentSrc||img.src;
  lightboxImage.alt=img.alt;
  if(lightboxTitle)lightboxTitle.textContent=item.dataset.title||'';
  if(lightboxCategory)lightboxCategory.textContent=item.querySelector('.tag')?.textContent||'';
  lightbox.classList.add('open');
  lightbox.setAttribute('aria-hidden','false');
  document.body.style.overflow='hidden';
};
const closeLightbox=()=>{
  if(!lightbox)return;
  lightbox.classList.remove('open');
  lightbox.setAttribute('aria-hidden','true');
  document.body.style.overflow='';
};
galleryItems.forEach(item=>{
  item.querySelector('.gallery-open')?.addEventListener('click',e=>{
    e.stopPropagation();
    openLightbox(item);
  });
  item.addEventListener('click',()=>openLightbox(item));
});
lightboxClose?.addEventListener('click',closeLightbox);
lightbox?.addEventListener('click',e=>{if(e.target===lightbox)closeLightbox();});
document.addEventListener('keydown',e=>{if(e.key==='Escape')closeLightbox();});

document.querySelectorAll('[data-year]').forEach(el=>el.textContent=new Date().getFullYear());
