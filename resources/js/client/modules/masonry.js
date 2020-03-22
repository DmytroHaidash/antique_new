let grid, rowHeight, rowGap, rowSpan, allItems;

grid = document.querySelector('.grid');

function resizeGridItem(item) {
  rowHeight = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-auto-rows'));
  rowGap = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-row-gap'));
  rowSpan = Math.ceil((item.querySelector('.grid-item__content').getBoundingClientRect().height + rowGap) / (rowHeight + rowGap));

  item.style.gridRowEnd = "span " + rowSpan;
}

function resizeAllGridItems() {
  allItems = document.querySelectorAll(".grid-item");
  for (let x = 0; x < allItems.length; x++) {
    resizeGridItem(allItems[x]);
  }
}

// document.addEventListener('DOMContentLoaded', resizeAllGridItems);
window.onload = () => resizeAllGridItems();
window.addEventListener("resize", resizeAllGridItems);

// window.onload = resizeAllGridItems();