/* ===== STICKY HEADER SCROLL EFFECT ===== */
const header = document.querySelector('.site-header');
window.addEventListener('scroll', () => {
    if (window.scrollY > 60) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});

/* ===== SCROLL REVEAL ===== */
const revealElements = document.querySelectorAll('.reveal, .feature-row, .stat-item');

const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
            setTimeout(() => {
                entry.target.classList.add('visible');
            }, entry.target.dataset.delay || 0);
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.12 });

revealElements.forEach(el => observer.observe(el));

/* ===== ANIMATED COUNTER ===== */
function animateCounter(el, target, suffix = '', duration = 2000) {
    let start = 0;
    const step = target / (duration / 16);
    const timer = setInterval(() => {
        start += step;
        if (start >= target) {
            el.textContent = target.toLocaleString() + suffix;
            clearInterval(timer);
        } else {
            el.textContent = Math.floor(start).toLocaleString() + suffix;
        }
    }, 16);
}

const statsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const counters = document.querySelectorAll('.stat-number');
            counters.forEach(counter => {
                const target = parseInt(counter.dataset.target);
                const suffix = counter.dataset.suffix || '';
                animateCounter(counter, target, suffix);
            });
            statsObserver.disconnect();
        }
    });
}, { threshold: 0.3 });

const statsBar = document.querySelector('.stats-bar');
if (statsBar) statsObserver.observe(statsBar);

/* ===== STAGGERED STAT ITEMS ===== */
const statItems = document.querySelectorAll('.stat-item');
const statObserver = new IntersectionObserver((entries) => {
    if (entries[0].isIntersecting) {
        statItems.forEach((item, i) => {
            setTimeout(() => item.classList.add('visible'), i * 150);
        });
        statObserver.disconnect();
    }
}, { threshold: 0.3 });

if (statsBar) statObserver.observe(statsBar);

/* ===== LIGHTBOX ===== */
const lightbox = document.querySelector('.lightbox-overlay');
const lightboxImg = lightbox ? lightbox.querySelector('img') : null;

document.querySelectorAll('.gal-item img').forEach(img => {
    img.style.cursor = 'zoom-in';
    img.addEventListener('click', () => {
        lightboxImg.src = img.src;
        lightbox.classList.add('active');
    });
});

if (lightbox) {
    lightbox.addEventListener('click', () => lightbox.classList.remove('active'));
}

/* ===== STICKY NAV HIGHLIGHT ===== */
window.addEventListener('scroll', () => {
    const nav = document.querySelector('.main-nav');
    if (window.scrollY > 80) {
        nav.style.boxShadow = '0 4px 20px rgba(0,0,0,0.7)';
    } else {
        nav.style.boxShadow = '0 3px 15px rgba(0,0,0,0.5)';
    }
});

/* ===== PARTICLES ===== */
function createParticles() {
    const container = document.querySelector('.particles');
    if (!container) return;
    for (let i = 0; i < 18; i++) {
        const p = document.createElement('div');
        p.classList.add('particle');
        p.style.left = Math.random() * 100 + '%';
        p.style.bottom = '0';
        p.style.animationDuration = (4 + Math.random() * 6) + 's';
        p.style.animationDelay = (Math.random() * 6) + 's';
        p.style.width = p.style.height = (2 + Math.random() * 4) + 'px';
        p.style.opacity = (0.4 + Math.random() * 0.6).toString();
        container.appendChild(p);
    }
}

createParticles();
