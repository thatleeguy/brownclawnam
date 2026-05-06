// Reveal-on-scroll
const obs = new IntersectionObserver((entries) => {
    for (const e of entries) {
        if (e.isIntersecting) {
            e.target.classList.add('is-revealed');
            obs.unobserve(e.target);
        }
    }
}, { threshold: 0.1, rootMargin: "0px 0px -40px 0px" });

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
});
