document.addEventListener("DOMContentLoaded", () => {
  if (window.lucide) lucide.createIcons();

  /* Mobile nav toggle */
  const menuBtn = document.getElementById("menu-btn");
  const mobileNav = document.getElementById("mobile-nav");
  if (menuBtn && mobileNav) {
    menuBtn.addEventListener("click", () => {
      const isOpen = !mobileNav.classList.contains("hidden");
      mobileNav.classList.toggle("hidden");
      menuBtn.setAttribute("aria-expanded", String(!isOpen));
      const openIcon = menuBtn.querySelector('[data-lucide="menu"]');
      const closeIcon = menuBtn.querySelector('[data-lucide="x"]');
      if (openIcon) openIcon.classList.toggle("hidden");
      if (closeIcon) closeIcon.classList.toggle("hidden");
    });
    mobileNav.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", () => mobileNav.classList.add("hidden"));
    });
  }

  /* Sticky nav shadow on scroll */
  const header = document.getElementById("site-header");
  if (header) {
    window.addEventListener("scroll", () => {
      header.classList.toggle("shadow-md", window.scrollY > 8);
    });
  }

  /* Animated stat counters */
  const counters = document.querySelectorAll("[data-counter]");
  if (counters.length) {
    const animate = (el) => {
      const target = parseInt(el.dataset.counter, 10) || 0;
      const duration = 1200;
      const start = performance.now();
      const step = (now) => {
        const progress = Math.min((now - start) / duration, 1);
        const value = Math.floor(progress * target);
        el.textContent = value + (el.dataset.suffix || "");
        if (progress < 1) requestAnimationFrame(step);
        else el.textContent = target + (el.dataset.suffix || "");
      };
      requestAnimationFrame(step);
    };
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            animate(entry.target);
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.6 }
    );
    counters.forEach((el) => observer.observe(el));
  }

  /* Enquiry form (static prototype, no backend wired up yet) */
  const enquiryForm = document.getElementById("enquiry-form");
  const enquirySuccess = document.getElementById("enquiry-success");
  if (enquiryForm) {
    enquiryForm.addEventListener("submit", (e) => {
      e.preventDefault();
      enquiryForm.classList.add("hidden");
      if (enquirySuccess) enquirySuccess.classList.remove("hidden");
      enquiryForm.reset();
    });
  }
});
