export class InfiniteScroll {
    chunk;
    renderedTo = 0;
    items = [];
    container;
    renderFn;
    observer;
    loadingEl;                     // ← added

    constructor({ containerId, sentinelId, chunk = 20, renderFn, loadingEl }) {
        this.chunk     = chunk;
        this.container = document.getElementById(containerId);
        this.renderFn  = renderFn;
        this.loadingEl = loadingEl;         // ← added

        this.observer = new IntersectionObserver(([entry]) => {
            if (entry.isIntersecting) this.loadNext();
        });
        this.observer.observe(document.getElementById(sentinelId));
    }

    reset(items) {
        this.items      = items;
        this.renderedTo = 0;
        this.container.innerHTML = '';
        this.loadNext();
    }

    loadNext() {
        if (this.loadingEl) this.loadingEl.style.display = 'block';    // ← added
        const chunk = this.items.slice(this.renderedTo, this.renderedTo + this.chunk);
        chunk.forEach(item => {
            this.container.insertAdjacentHTML('beforeend', this.renderFn(item));
        });
        this.renderedTo += chunk.length;

        // Hide spinner when all items are rendered
        if (this.renderedTo >= this.items.length) {
            if (this.loadingEl) this.loadingEl.style.display = 'none';   // ← added
        } else {
            if (this.loadingEl) this.loadingEl.style.display = 'none';   // ← hide after loading chunk
        }
    }
}
