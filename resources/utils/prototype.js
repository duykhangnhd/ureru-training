Array.prototype.sortByField = function (field, sortOrder) {
    return this.sort((a, b) => {
      const field1 = a[field];
      const field2 = b[field];

      if (sortOrder === "asc") {
        return field1.localeCompare(field2, undefined, { numeric: true });
      }
      return field2.localeCompare(field1, undefined, { numeric: true });
    });
  };
