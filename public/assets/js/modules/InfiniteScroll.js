export class InfiniteScroll {
  chunk;
  renderedTo = 0;
  items = [];
  container;
  renderFn;
  observer;

  constructor({ containerId, sentinelId, chunk = 20, renderFn }) {
    this.chunk     = chunk;
    this.container = document.getElementById(containerId);
    this.renderFn  = renderFn;

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
    const chunk = this.items.slice(this.renderedTo, this.renderedTo + this.chunk);
    chunk.forEach(item => {
      this.container.insertAdjacentHTML('beforeend', this.renderFn(item));
    });
    this.renderedTo += chunk.length;
  }
}
