export function applyFilters(books, { minPrice, maxPrice, sortField, sortDir }) {
  const upper = maxPrice || Infinity;
  const sign  = sortDir === 'asc' ? 1 : -1;

  const inRange = b => b.precio >= minPrice && b.precio <= upper;

  const getSortValue = (b, field) => {
    if (field === 'autor') {
      return b.autores?.[0]?.nombre ?? '';
    }
    return b[field];
  };

  const compare = (a, b) => {
    const va = getSortValue(a, sortField);
    const vb = getSortValue(b, sortField);
    return (va < vb ? -1 : va > vb ? 1 : 0) * sign;
  };

  return [...books].filter(inRange).sort(compare);
}
