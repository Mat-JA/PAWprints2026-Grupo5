class Carousel {

    constructor(selector, options = {}) {

        this.container = document.querySelector(selector);

        this.images = [...this.container.querySelectorAll("img")];

        this.current = 0;
        this.touchStartX = 0;
        this.touchEndX = 0;
        this.initialized = false;

        this.options = {
            autoplay: true,
            delay: 3000,
            transition: "fade",
            fullscreen: false,  
            ...options
        };

        this.createLoader();
        this.preloadImages();
    }

    init() {
        this.createStructure();
        this.createThumbs();

        this.container.addEventListener("mouseenter", () => this.pause());
        this.container.addEventListener("mouseleave", () => this.resume());

        this.showSlide(0);
        this.enableSwipe();
        this.enableKeyboard();

        if (this.options.autoplay) {
            this.startAutoplay();
        }
    }

    createLoader() {

        this.loader = document.createElement("div");
        this.loader.classList.add("carousel-loader");
        this.loader.innerHTML = `
            <div class="carousel-loader-content">
                <p class="carousel-loader-text">Cargando imágenes...</p>
                <div class="carousel-progress">
                    <div class="carousel-progress-bar"></div>
                </div>
                <p class="carousel-progress-number">0%</p>
            </div>
        `;

        this.container.appendChild(this.loader);

        this.progressBar   = this.loader.querySelector(".carousel-progress-bar");
        this.progressNumber = this.loader.querySelector(".carousel-progress-number");
    }

    updateProgress(percent) {
        this.progressBar.style.width    = `${percent}%`;
        this.progressNumber.textContent = `${percent}%`;
    }

    preloadImages() {

        let loaded = 0;
        const total = this.images.length;

        this.images.forEach(image => {

            const img = new Image();
            img.src = image.src;

            const onLoad = () => {
                loaded++;
                const percent = Math.round((loaded / total) * 100);
                this.updateProgress(percent);

                if (loaded === total) {
                    setTimeout(() => {
                        this.loader.remove();
                        this.container.style.visibility = "visible";

                        if (!this.initialized) {
                            this.initialized = true;
                            this.init();
                        }
                    }, 500);
                }
            };

            if (img.complete) {
                onLoad();
            } else {
                img.onload  = onLoad;
                img.onerror = onLoad;
            }
        });
    }

    createStructure() {

        this.container.classList.add("carousel");
        this.container.classList.add(`transition-${this.options.transition}`);

        if (this.options.fullscreen) {
            this.container.classList.add("carousel-fullscreen");
        }

        // Track
        const track = document.createElement("div");
        track.classList.add("carousel-track");

        this.images.forEach(image => {
            const slide = document.createElement("div");
            slide.classList.add("carousel-slide");
            slide.appendChild(image);
            track.appendChild(slide);
        });

        [...this.container.children].forEach(el => {
            if (!el.classList.contains("carousel-loader")) el.remove();
        });

        this.container.appendChild(track);

        const prevButton = document.createElement("button");
        prevButton.classList.add("carousel-prev");
        prevButton.setAttribute("aria-label", "Anterior");
        prevButton.innerHTML = "&#8249;";

        const nextButton = document.createElement("button");
        nextButton.classList.add("carousel-next");
        nextButton.setAttribute("aria-label", "Siguiente");
        nextButton.innerHTML = "&#8250;";

        this.container.appendChild(prevButton);
        this.container.appendChild(nextButton);

        prevButton.addEventListener("click", () => this.prev());
        nextButton.addEventListener("click", () => this.next());

        this.createDots();

        this.slides = [...this.container.querySelectorAll(".carousel-slide")];
    }

    createDots() {

        const dotsContainer = document.createElement("div");
        dotsContainer.classList.add("carousel-dots");

        this.images.forEach((_, index) => {
            const dot = document.createElement("button");
            dot.classList.add("carousel-dot");
            dot.setAttribute("aria-label", `Slide ${index + 1}`);
            dot.addEventListener("click", () => this.goTo(index));
            dotsContainer.appendChild(dot);
        });

        this.container.appendChild(dotsContainer);
        this.dots = [...dotsContainer.querySelectorAll(".carousel-dot")];
    }

    createThumbs() {

        const thumbsContainer = document.createElement("div");
        thumbsContainer.classList.add("carousel-thumbs");

        this.images.forEach((image, index) => {
            const thumb = document.createElement("img");
            thumb.src = image.src;
            thumb.alt = image.alt || `Slide ${index + 1}`;
            thumb.classList.add("carousel-thumb");
            thumb.addEventListener("click", () => this.goTo(index));
            thumbsContainer.appendChild(thumb);
        });

        this.container.appendChild(thumbsContainer);
        this.thumbs = [...this.container.querySelectorAll(".carousel-thumb")];
    }

    showSlide(index) {

        const transition = this.options.transition;
    
        if (transition === "slide") {
            const prev = this.slides[this.current];
            const next = this.slides[index];
            const direction = index > this.current ? 1 : -1;
    
            if (prev !== next) {
                this.slides.forEach(s => {
                    s.style.transition = "none";
                    s.classList.remove("active");
                    s.style.zIndex = "";
                });

                this.container.getBoundingClientRect();
    
                prev.style.transition = "";
                next.style.transition = "";
    
                prev.style.zIndex = "1";
                next.style.zIndex = "2";
                prev.classList.add("active");
    
                next.style.transform = `translateX(${direction * 100}%)`;
                next.classList.add("active");
    
                next.getBoundingClientRect();
    
                prev.style.transform = `translateX(${-direction * 100}%)`;
                next.style.transform = "translateX(0%)";
    
                const cleanup = () => {
                    prev.classList.remove("active");
                    prev.style.transform = "";
                    prev.style.zIndex = "";
                    next.style.zIndex = "";
                    prev.removeEventListener("transitionend", cleanup);
                };
                prev.addEventListener("transitionend", cleanup);
    
            } else {
                next.style.transform = "translateX(0%)";
                next.classList.add("active");
            }
    
        } else {
            this.slides.forEach(s => s.classList.remove("active"));
            this.slides[index].classList.add("active");
        }
    
        this.current = index;
    
        if (this.thumbs) {
            this.thumbs.forEach(t => t.classList.remove("active"));
            this.thumbs[index].classList.add("active");
        }
    
        if (this.dots) {
            this.dots.forEach(d => d.classList.remove("active"));
            this.dots[index].classList.add("active");
        }
    }

    next() {
        const nextIndex = (this.current + 1) % this.slides.length;
        this.goTo(nextIndex);
    }

    prev() {
        const prevIndex = (this.current - 1 + this.slides.length) % this.slides.length;
        this.goTo(prevIndex);
    }

    goTo(index) {
        if (index === this.current) return;
        this.showSlide(index);
        this.resetAutoplay();
    }

    startAutoplay() {
        clearInterval(this.interval);
        this.interval = setInterval(() => this.next(), this.options.delay);
    }

    pause() {
        clearInterval(this.interval);
    }

    resume() {
        if (this.options.autoplay) this.startAutoplay();
    }

    resetAutoplay() {
        if (this.options.autoplay) this.startAutoplay();
    }

    enableSwipe() {

        this.container.addEventListener("touchstart", (e) => {
            this.touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        this.container.addEventListener("touchend", (e) => {
            this.touchEndX = e.changedTouches[0].screenX;
            this.handleSwipe();
        }, { passive: true });
    }

    handleSwipe() {
        const distance = this.touchEndX - this.touchStartX;
        if (Math.abs(distance) > 50) {
            distance < 0 ? this.next() : this.prev();
        }
    }

    enableKeyboard() {
        document.addEventListener("keydown", (e) => {
            if (e.key === "ArrowRight") this.next();
            if (e.key === "ArrowLeft")  this.prev();
        });
    }
}