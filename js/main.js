/**
 * CleVista Group Limited - Main JavaScript Operations
 * Handles: Header animations, mobile menus, language dropdown toggles, modals, and dynamic filters.
 */

document.addEventListener('DOMContentLoaded', () => {
  // 1. Header scroll animation
  const header = document.querySelector('header');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  });

  // 2. Mobile Menu toggle
  const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
  const navMenu = document.querySelector('.nav-menu');
  if (mobileNavToggle && navMenu) {
    mobileNavToggle.addEventListener('click', () => {
      const isOpen = navMenu.classList.toggle('show');
      mobileNavToggle.classList.toggle('active');
      
      // Prevent background scrolling when menu drawer is open
      document.body.style.overflow = isOpen ? 'hidden' : 'auto';
    });

    // Close menu when clicking links
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
      link.addEventListener('click', () => {
        navMenu.classList.remove('show');
        mobileNavToggle.classList.remove('active');
        document.body.style.overflow = 'auto';
      });
    });
  }

  // Mobile language options handler inside full-screen drawer
  const mobileLangBtns = document.querySelectorAll('.mobile-lang-btn');
  if (mobileLangBtns.length > 0 && navMenu && mobileNavToggle) {
    const updateMobileLangActive = () => {
      const savedLang = localStorage.getItem('clevista_lang') || 'en';
      mobileLangBtns.forEach(btn => {
        if (btn.getAttribute('data-lang') === savedLang) {
          btn.classList.add('active');
        } else {
          btn.classList.remove('active');
        }
      });
    };

    // Initial check
    updateMobileLangActive();

    mobileLangBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        const lang = btn.getAttribute('data-lang');
        if (typeof setLanguage === 'function') {
          setLanguage(lang);
        }
        navMenu.classList.remove('show');
        mobileNavToggle.classList.remove('active');
        document.body.style.overflow = 'auto';
      });
    });

    // Sync state on dropdown clicks
    document.querySelectorAll('.lang-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        setTimeout(updateMobileLangActive, 200);
      });
    });
  }

  // 3. Language switcher dropdown
  const langSelector = document.querySelector('.lang-selector');
  const langTrigger = document.querySelector('.lang-trigger');
  const langDropdown = document.querySelector('.lang-dropdown');

  if (langTrigger && langDropdown) {
    langTrigger.addEventListener('click', (e) => {
      e.stopPropagation();
      langDropdown.classList.toggle('show');
    });

    // Handle button selections
    const langBtns = document.querySelectorAll('.lang-btn');
    langBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        const lang = btn.getAttribute('data-lang');
        if (typeof setLanguage === 'function') {
          setLanguage(lang);
        }
        langDropdown.classList.remove('show');
      });
    });

    // Click outside to close dropdown
    document.addEventListener('click', (e) => {
      if (langSelector && !langSelector.contains(e.target)) {
        langDropdown.classList.remove('show');
      }
    });
  }

  // 4. Property Dynamic Filtering (Estates page)
  const filterBtns = document.querySelectorAll('.filter-btn');
  const listingCards = document.querySelectorAll('.listing-card');

  if (filterBtns.length > 0 && listingCards.length > 0) {
    filterBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        // Update active class on buttons
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const category = btn.getAttribute('data-filter');
        let visibleCount = 0;

        listingCards.forEach(card => {
          const cardType = card.getAttribute('data-type');
          
          if (category === 'all' || cardType === category) {
            card.style.display = 'flex';
            // Subtle fade-in scale
            card.style.opacity = '0';
            card.style.transform = 'scale(0.95)';
            setTimeout(() => {
              card.style.opacity = '1';
              card.style.transform = 'scale(1)';
            }, 50);
            visibleCount++;
          } else {
            card.style.display = 'none';
          }
        });

        // Toggle "no records found" view
        const noRecords = document.querySelector('.no-records');
        if (noRecords) {
          noRecords.style.display = (visibleCount === 0) ? 'block' : 'none';
        }
      });
    });
  }

  // 5. Inquire Modal Handlers
  const modalTriggers = document.querySelectorAll('[data-modal-open]');
  const modalOverlay = document.getElementById('inquiry-modal');
  const modalClose = document.querySelector('.modal-close');

  if (modalOverlay) {
    modalTriggers.forEach(trigger => {
      trigger.addEventListener('click', () => {
        const listingId = trigger.getAttribute('data-id');
        const listingTitle = trigger.getAttribute('data-title');
        
        // Update reference hidden input
        const refIdInput = document.getElementById('modal-reference-id');
        if (refIdInput) refIdInput.value = listingId;

        // Update modal title header detail
        const modalRefTitle = document.getElementById('modal-reference-title');
        if (modalRefTitle) {
          modalRefTitle.textContent = `: ${listingTitle}`;
          modalRefTitle.style.color = '#D4AF37';
        }

        // Show modal overlay
        modalOverlay.classList.add('show');
        document.body.style.overflow = 'hidden';
      });
    });

    // Close buttons
    if (modalClose) {
      modalClose.addEventListener('click', () => {
        modalOverlay.classList.remove('show');
        document.body.style.overflow = 'auto';
      });
    }

    // Backdrop click close
    modalOverlay.addEventListener('click', (e) => {
      if (e.target === modalOverlay) {
        modalOverlay.classList.remove('show');
        document.body.style.overflow = 'auto';
      }
    });
  }

  // 6. Dismiss alerts automatically after 5 seconds
  const alerts = document.querySelectorAll('.alert');
  alerts.forEach(alert => {
    setTimeout(() => {
      alert.style.transition = 'opacity 0.6s ease';
      alert.style.opacity = '0';
      setTimeout(() => alert.remove(), 600);
    }, 5000);
  });

  // 7. Background Hero Video Slideshow Carousel (Sotheby's Style)
  const heroCarousel = document.getElementById('hero-carousel');
  if (heroCarousel) {
    const slides = heroCarousel.querySelectorAll('.carousel-slide');
    const dots = heroCarousel.querySelectorAll('.indicator-dot');
    const titleElem = document.getElementById('carousel-title');
    const detailsElem = document.getElementById('carousel-details');
    const linkElem = document.getElementById('carousel-link');
    
    let currentSlide = 0;
    const slideDuration = 8000; // 8 seconds per slide
    let slideInterval;

    function playSlideVideo(slideIndex) {
      // Pause all videos
      slides.forEach((slide, idx) => {
        const video = slide.querySelector('video');
        if (video) {
          if (idx === slideIndex) {
            video.play().catch(err => {
              // Handle autoplay restrictions gracefully if thrown
            });
          } else {
            video.pause();
          }
        }
      });
    }

    function showSlide(index) {
      if (index === currentSlide) return;
      
      // Remove active class from old slide and dot
      slides[currentSlide].classList.remove('active');
      dots[currentSlide].classList.remove('active');

      // Update current slide index
      currentSlide = index;

      // Add active class to new slide and dot
      slides[currentSlide].classList.add('active');
      dots[currentSlide].classList.add('active');

      // Play the video in the active slide
      playSlideVideo(currentSlide);

      // Fetch metadata from active slide dataset
      const title = slides[currentSlide].getAttribute('data-title');
      const details = slides[currentSlide].getAttribute('data-details');
      const link = slides[currentSlide].getAttribute('data-link');

      // Update card content with fade effect
      const card = document.getElementById('hero-overlay-card');
      if (card) {
        card.style.opacity = '0';
        card.style.transform = 'translateY(10px)';
        setTimeout(() => {
          if (titleElem) titleElem.textContent = title;
          if (detailsElem) detailsElem.innerHTML = details;
          if (linkElem) {
            linkElem.setAttribute('href', link);
          }
          card.style.opacity = '1';
          card.style.transform = 'translateY(0)';
        }, 300);
      }
    }

    function nextSlide() {
      let nextIndex = (currentSlide + 1) % slides.length;
      showSlide(nextIndex);
    }

    // Initialize slideshow timer
    function startInterval() {
      stopInterval();
      slideInterval = setInterval(nextSlide, slideDuration);
    }

    function stopInterval() {
      if (slideInterval) {
        clearInterval(slideInterval);
      }
    }

    // Dot indicators click handlers
    dots.forEach((dot, index) => {
      dot.addEventListener('click', () => {
        showSlide(index);
        startInterval(); // restart timer
      });
    });

    // Start video playing on page load for the first slide
    playSlideVideo(0);
    startInterval();
  }
});
