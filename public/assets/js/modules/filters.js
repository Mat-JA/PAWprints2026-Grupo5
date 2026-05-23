export function applyFilters(books, { minPrice, maxPrice, sortField, sortDir }) {
  return [...books]
    .filter(b => b.precio >= minPrice && b.precio <= (maxPrice || Infinity))
    .sort((a, b) => {
      const dir = sortDir === 'asc' ? 1 : -1;
      if (a[sortField] < b[sortField]) return -1 * dir;
      if (a[sortField] > b[sortField]) return  1 * dir;
      return 0;
    });
}
