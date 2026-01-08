document.addEventListener("DOMContentLoaded", () => {

    /* ========= CAROUSEL ========= */
    let currentSlide = 0;
    const slides = document.querySelectorAll(".slide");

    if (slides.length === 0) {
        console.warn("Carousel not found");
        return;
    }

    function showSlide(i) {
        slides.forEach(s => s.classList.remove("active"));
        slides[i].classList.add("active");
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(currentSlide);
    }

    document.querySelector(".carousel-controls button:nth-child(1)")?.addEventListener("click", prevSlide);
    document.querySelector(".carousel-controls button:nth-child(2)")?.addEventListener("click", nextSlide);

    setInterval(nextSlide, 5000);

});
document.addEventListener("DOMContentLoaded", () => {

    // CAROUSEL
    const slides = document.querySelectorAll(".slide");
    let idx = 0;

    function showSlide(i) {
        slides.forEach(s => s.classList.remove("active"));
        slides[i].classList.add("active");
    }

    function next() {
        idx = (idx + 1) % slides.length;
        showSlide(idx);
    }

    function prev() {
        idx = (idx - 1 + slides.length) % slides.length;
        showSlide(idx);
    }

    document.getElementById("nextBtn").addEventListener("click", next);
    document.getElementById("prevBtn").addEventListener("click", prev);

    setInterval(next, 5000);

});
const sidebar = document.getElementById("mobileSidebar");
const overlay = document.getElementById("overlay");
const toggle = document.getElementById("navToggle");

if (toggle) {
    toggle.onclick = () => {
        sidebar.classList.add("active");
        overlay.classList.add("active");
    };
}

if (overlay) {
    overlay.onclick = () => {
        sidebar.classList.remove("active");
        overlay.classList.remove("active");
    };
}
// Sample dataset
    const films = [
      {id:1,title:'Aurora: The Awakening',rating:'8.6',meta:'Action · 2h 10m',poster:'https://picsum.photos/seed/a/400/600',synopsis:'A high‑octane adventure of a team racing to stop a tech catastrophe.',showtimes:[{t:'10:00',aud:'A1',sold:false},{t:'13:30',aud:'A1',sold:false},{t:'16:30',aud:'A2',sold:true}]},
      {id:2,title:'Midnight Bloom',rating:'7.9',meta:'Drama · 1h 50m',poster:'https://picsum.photos/seed/b/400/600',synopsis:'An intimate portrait of love and late nights across the city.',showtimes:[{t:'11:45',aud:'B2',sold:false},{t:'15:00',aud:'B2',sold:false}]},
      {id:3,title:'Neon Circuit',rating:'8.2',meta:'Sci‑Fi · 2h',poster:'https://picsum.photos/seed/c/400/600',synopsis:'In a neon metropolis, a courier discovers an AI secret.',showtimes:[{t:'12:00',aud:'C1',sold:false},{t:'18:00',aud:'C1',sold:true}]},
      {id:4,title:'Harvest Moon',rating:'7.2',meta:'Family · 1h 35m',poster:'https://picsum.photos/seed/d/400/600',synopsis:'A warm tale about family and one unusual harvest.',showtimes:[{t:'09:30',aud:'D1',sold:false}]},
      {id:5,title:'Echoes of Yesterday',rating:'8.0',meta:'Thriller · 2h 5m',poster:'https://picsum.photos/seed/e/400/600',synopsis:'A cold case reopens when a new audio clue surfaces.',showtimes:[{t:'14:00',aud:'E1',sold:true},{t:'20:30',aud:'E1',sold:false}]},
      {id:6,title:'Skybound',rating:'7.8',meta:'Adventure · 1h 55m',poster:'https://picsum.photos/seed/f/400/600',synopsis:'A crew of explorers chase a floating island in the clouds.',showtimes:[{t:'10:30',aud:'F1',sold:false},{t:'17:45',aud:'F1',sold:false}]}
    ];

    const catalog = document.getElementById('catalogGrid');
    const cartPanel = document.getElementById('cartPanel');
    const cartBtn = document.getElementById('cartBtn');
    const cartCount = document.getElementById('cartCount');
    const cartItemsEl = document.getElementById('cartItems');
    const subtotalEl = document.getElementById('subtotal');
    const mobileNav = document.getElementById('mobileNav');
    const burger = document.getElementById('burger');

    let cart = [];

    function formatIDR(n){return 'Rp'+n.toLocaleString('id-ID')}

    function renderCatalog(){
      catalog.innerHTML = '';
      films.forEach(f=>{
        const card = document.createElement('article');
        card.className='card';
        card.tabIndex=0;
        card.innerHTML = `
          <div class="poster"><img src="${f.poster}" alt="Poster ${f.title}"></div>
          <div class="meta">
            <h3 class="title">${f.title}</h3>
            <div class="meta-line">${f.meta} · <span class="rating">${f.rating}</span></div>
            <div style="color:var(--muted);font-size:0.9rem">${f.synopsis.slice(0,100)}...</div>
            <div class="card-actions">
              <button class="chip" data-id="${f.id}" data-action="watchlist">Watchlist</button>
              <button class="chip" data-id="${f.id}" data-action="detail">Lihat</button>
              <button class="chip" data-id="${f.id}" data-action="book">Pesan</button>
            </div>
          </div>
        `;
        catalog.appendChild(card);
      });
    }

    function openDetail(id){
      const film = films.find(x=>x.id===id);
      const tpl = document.getElementById('detailTpl');
      const clone = tpl.content.cloneNode(true);
      const backdrop = clone.querySelector('.modal-backdrop');
      const img = clone.querySelector('.modal-poster img');
      img.src = film.poster; img.alt = `Poster ${film.title}`;
      clone.querySelector('.m-title').textContent = film.title;
      clone.querySelector('.m-meta').textContent = `${film.meta} · Rating ${film.rating}`;
      clone.querySelector('.m-synopsis').textContent = film.synopsis;

      const st = clone.querySelector('.showtimes');
      film.showtimes.forEach(s=>{
        const btn = document.createElement('button');
        btn.className='time-chip';
        btn.textContent = `${s.t} · ${s.aud}`;
        btn.setAttribute('role','button');
        if(s.sold){btn.setAttribute('aria-disabled','true');}
        btn.addEventListener('click',()=>{ if(!s.sold) addToCart(film,s) });
        st.appendChild(btn);
      });

      backdrop.querySelector('.m-close').addEventListener('click',()=>backdrop.remove());
      backdrop.querySelector('.m-book').addEventListener('click',()=>{ /* open showtime chooser */ });

      backdrop.addEventListener('click',(e)=>{ if(e.target===backdrop) backdrop.remove(); });

      document.body.appendChild(clone);
      // focus trap: move focus to the first focusable inside modal
      setTimeout(()=>backdrop.querySelector('.m-close').focus(),60);
    }

    function addToCart(film, showtime){
      const item = {id:Date.now(),filmId:film.id,title:film.title,price:45000,showtime:showtime.t,aud:showtime.aud};
      cart.push(item); updateCartUI();
      // close any open modal backdrops to simulate flow
      document.querySelectorAll('.modal-backdrop').forEach(m=>m.remove());
    }

    function updateCartUI(){
      cartItemsEl.innerHTML='';
      cart.forEach(it=>{
        const el = document.createElement('div');
        el.style.display='flex';el.style.justifyContent='space-between';el.style.padding='8px 0';
        el.innerHTML = `<div style="min-width:0"><div style='font-weight:700;color:var(--white)'>${it.title}</div><div style='font-size:0.85rem;color:#bdbdbf'>${it.showtime} · ${it.aud}</div></div><div style='text-align:right'><div style='font-weight:800'>${formatIDR(it.price)}</div><button data-id='${it.id}' class='icon-btn' style='margin-top:6px'>Hapus</button></div>`;
        el.querySelector('button').addEventListener('click',()=>{cart=cart.filter(c=>c.id!==it.id);updateCartUI()});
        cartItemsEl.appendChild(el);
      });
      const total = cart.reduce((s,i)=>s+i.price,0);
      subtotalEl.textContent = formatIDR(total);
      cartCount.textContent = cart.length;
    }

    // Event delegation for catalog
    catalog.addEventListener('click',e=>{
      const btn = e.target.closest('button');
      if(!btn) return;
      const id = Number(btn.dataset.id);
      const action = btn.dataset.action;
      if(action==='detail') openDetail(id);
      if(action==='book'){ openDetail(id); }
      if(action==='watchlist'){ alert('Ditambahkan ke watchlist — demo'); }
    });

    // Cart slideover toggles
    cartBtn.addEventListener('click',()=>{
      const open = cartPanel.classList.toggle('open');
      cartBtn.setAttribute('aria-expanded', String(open));
      cartPanel.setAttribute('aria-hidden', String(!open));
    });

    // Burger toggle mobile nav
    burger.addEventListener('click',()=>{
      const open = mobileNav.classList.toggle('open');
      mobileNav.setAttribute('aria-hidden', String(!open));
    });

    // Close on Escape
    document.addEventListener('keydown',e=>{
      if(e.key==='Escape'){
        document.querySelectorAll('.modal-backdrop').forEach(m=>m.remove());
        cartPanel.classList.remove('open');
        mobileNav.classList.remove('open');
      }
    });

    // Initial render
    renderCatalog();
    updateCartUI();

    // Sticky header shadow on scroll
    window.addEventListener('scroll',()=>{
      const h = document.querySelector('header');
      if(window.scrollY>20) h.style.boxShadow='0 6px 18px rgba(0,0,0,0.6)'; else h.style.boxShadow='none';
    });

    // Focus styles for keyboard nav
    document.addEventListener('focusin',e=>{
      const card = e.target.closest('.card');
      if(card) card.style.boxShadow= '0 18px 40px rgba(2,6,23,0.7)';
    });
    document.addEventListener('focusout',e=>{
      const card = e.target.closest('.card');
      if(card) card.style.boxShadow='';
    });

    // zenith.js
document.addEventListener("DOMContentLoaded", () => {
  const burger = document.getElementById("burger");
  const mobileNav = document.getElementById("mobileNav");

  // Toggle menu mobile
  burger?.addEventListener("click", () => {
    mobileNav.classList.toggle("active");
    const expanded = burger.getAttribute("aria-expanded") === "true";
    burger.setAttribute("aria-expanded", !expanded);
  });

  // Close menu when click outside
  document.addEventListener("click", (e) => {
    if (!mobileNav.contains(e.target) && !burger.contains(e.target)) {
      mobileNav.classList.remove("active");
    }
  });

  // Optional: Modal event (for Now Showing popup)
  const modals = document.querySelectorAll(".modal-bg");
  const openBtns = document.querySelectorAll("[data-open]");
  const closeBtns = document.querySelectorAll("[data-close]");

  openBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      const target = document.querySelector(btn.dataset.open);
      target?.classList.add("active");
    });
  });

  closeBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      btn.closest(".modal-bg")?.classList.remove("active");
    });
  });
});

document.addEventListener('DOMContentLoaded', function() {
    const burger = document.getElementById('burger'); // ID dari tombol menu
    const mobileSidebar = document.getElementById('mobileSidebar');
    const overlay = document.getElementById('overlay');

    if (burger) {
        burger.addEventListener('click', function() {
            mobileSidebar.classList.add('active');
            overlay.classList.add('active');
        });
    }

    if (overlay) {
        overlay.addEventListener('click', function() {
            mobileSidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
    }
});

document.addEventListener('DOMContentLoaded', () => {
    // 1. MOBILE MENU LOGIC (Penting agar responsive jalan)
    const burger = document.getElementById('burger');
    const mobileSidebar = document.getElementById('mobileSidebar');
    const overlay = document.getElementById('overlay');

    if (burger) {
        burger.addEventListener('click', () => {
            mobileSidebar.classList.add('active');
            overlay.classList.add('active');
        });
    }

    if (overlay) {
        overlay.addEventListener('click', () => {
            mobileSidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
    }

    // 2. SEARCH & UI EFFECTS
    const navbar = document.querySelector('.navbar-glass');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.style.background = 'rgba(10, 10, 10, 0.95)';
        } else {
            navbar.style.background = 'rgba(18, 18, 18, 0.8)';
        }
    });

    /* CATATAN: 
       Bagian "catalogGrid.innerHTML" atau "fetchMovies()" 
       di file lama HARUS dihapus total karena sekarang 
       kita pakai data langsung dari Laravel (@foreach).
    */
});