class LibrosCarousel {

    constructor(selector) {
        this.container = document.querySelector(selector);
        this.track = this.container.querySelector(".libros-track");
        this.cards = [...this.track.querySelectorAll(".tarjeta-libro")];
        this.currentPage = 0;

        const viewport = document.createElement("div");
        viewport.classList.add("libros-viewport");
        this.container.insertBefore(viewport, this.track);
        viewport.appendChild(this.track);

        this.viewport = viewport;

        this.createButtons();

        window.addEventListener("resize", () => {
            this.goTo(this.currentPage);
        });
    }

    createButtons() {
        const prev = document.createElement("button");
        prev.classList.add("libros-carousel-prev");
        prev.innerHTML = "&#8249;";
    
        const next = document.createElement("button");
        next.classList.add("libros-carousel-next");
        next.innerHTML = "&#8250;";
    
        this.container.appendChild(prev);
        this.container.appendChild(next);
    
        prev.addEventListener("click", () => this.prev());
        next.addEventListener("click", () => this.next());
    }

    getCardsPerView() {
        if (window.innerWidth <= 550) return 1;
        if (window.innerWidth <= 800) return 2;
        if (window.innerWidth <= 1100) return 3;
        return 4;
    }

    getMaxPage() {
        const cardsPerView = this.getCardsPerView();
        return Math.ceil(this.cards.length / cardsPerView) - 1;
    }

    goTo(page) {
        const cardsPerView = this.getCardsPerView();
        const maxPage = this.getMaxPage();

        if (page < 0) page = 0;
        if (page > maxPage) page = maxPage;

        this.currentPage = page;

        const cardWidth = this.cards[0].offsetWidth;
        const gap = 20;
        const move = (cardWidth + gap) * cardsPerView * page;

        this.track.style.transform = `translateX(-${move}px)`;
    }

    next() {
        if (this.currentPage >= this.getMaxPage()) {
            this.goTo(0);
        } else {
            this.goTo(this.currentPage + 1);
        }
    }
    
    prev() {
        if (this.currentPage <= 0) {
            this.goTo(this.getMaxPage());
        } else {
            this.goTo(this.currentPage - 1);
        }
    }
}