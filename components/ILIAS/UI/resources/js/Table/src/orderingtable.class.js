/**
 * This file is part of ILIAS, a powerful learning management system
 * published by ILIAS open source e-Learning e.V.
 *
 * ILIAS is licensed with the GPL-3.0,
 * see https://www.gnu.org/licenses/gpl-3.0.en.html
 * You should have received a copy of said license along with the
 * source code, too.
 *
 * If this is not the case or you just want to try ILIAS, you'll find
 * us at:
 * https://www.ilias.de
 * https://github.com/ILIAS-eLearning
 */

export default class OrderingTable {
  /**
   * @type {HTMLDivElement}
   */
  #component;

  /**
   * @type {HTMLTableElement}
   */
  #table;

  /**
   * @type {array<HTMLTableRowElement>}
   */
  #rows;

  /**
   * @type {HTMLTableRowElement}
   */
  #tmpDragRow;

  /**
   * @type {HTMLTableRowElement}
   */
  #rippedRowGap;

  /**
   *
   * @type {null|HTMLTableRowElement}
   */
  touchDragImage = null;

  /**
   * @param {string} componentId
   * @throws {Error} if DOM element is missing
   */
  constructor(componentId) {
    this.#component = document.getElementById(componentId);
    if (this.#component === null) {
      throw new Error(`Could not find a OrderingTable for id '${componentId}'.`);
    }
    this.#table = this.#component.getElementsByTagName('table').item(0);
    if (this.#table === null) {
      throw new Error('There is no <table> in the component\'s HTML.');
    }

    this.#indexRows();
    this.#rows.forEach((row) => this.#addDraglisteners(row));
  }

  #indexRows() {
    this.#rows = Array.from(this.#table.rows);
    this.#rows.shift();// exclude header
    this.#rows.pop();// exclude footer
  }

  #addDraglisteners(row) {
    row.setAttribute('draggable', true);
    row.addEventListener('dragstart', (event) => this.dragstart(event));
    row.addEventListener('dragover', (event) => this.dragover(event));
    row.addEventListener('dragend', () => { this.dragend(); });

    row.addEventListener('touchstart', (event) => this.touchstart(event));
    row.addEventListener('touchmove', (event) => this.touchmove(event));
    row.addEventListener('touchend', (event) => this.touchend(event));
    row.addEventListener('touchcancel', (event) => this.touchend(event));
  }

  dragstart(event) {
    this.#tmpDragRow = event.target.closest('tr');

    // Safari needs this
    event.dataTransfer.setData('text/plain', 'dummy');

    // Create a placeholder row with empty cells (same number of cells)
    this.#rippedRowGap = this.#tmpDragRow.cloneNode(true);
    this.#rippedRowGap.classList.add('rippedRowGap');
    Array.from(this.#rippedRowGap.getElementsByTagName('td')).forEach((cell) => {
      cell.innerHTML = '';
    });
  }

  dragover(event) {
    if (!this.#isDraggedElementValidRow()) {
      return;
    }

    event.preventDefault();

    const target = event.target.closest('tr');
    if (target && target !== this.#rippedRowGap) {
      // Insert placeholder row in the new position
      if (this.#rows.indexOf(target) > this.#rows.indexOf(this.#tmpDragRow)) {
        target.after(this.#rippedRowGap);
      } else {
        target.before(this.#rippedRowGap);
      }
    }

    // Now remove the original row after we confirm the drag started
    if (this.#tmpDragRow.parentElement) {
      this.#tmpDragRow.remove();
    }
  }

  dragend() {
    // Restore original row at placeholder's position
    this.#rippedRowGap.replaceWith(this.#tmpDragRow);

    this.#indexRows();
    this.#renumberAfterDrag();
  }

  #isDraggedElementValidRow() {
    return this.#rows.includes(this.#tmpDragRow);
  }

  touchstart(event) {
    this.#tmpDragRow = event.target.closest('tr');

    // Create a placeholder row with empty cells (same number of cells)
    this.#rippedRowGap = this.#tmpDragRow.cloneNode(true);
    this.#rippedRowGap.classList.add('rippedRowGap');
    Array.from(this.#rippedRowGap.getElementsByTagName('td')).forEach((cell) => {
      cell.innerHTML = '';
    });

    // custom drag image for touch
    this.dragImage = this.#tmpDragRow.cloneNode(true);
    this.dragImage.classList.add('touchDragImage');
    document.body.appendChild(this.dragImage);
  }

  touchmove(event) {
    event.preventDefault();
    const touch = event.touches[0];

    // Position the drag image under the finger
    this.dragImage.style.left = `${touch.clientX - 100}px`;
    this.dragImage.style.top = `${touch.clientY}px`;

    const target = document.elementFromPoint(touch.clientX, touch.clientY)?.closest('tr');
    if (target && this.#rows.includes(target)) {
      if (this.#rows.indexOf(target) > this.#rows.indexOf(this.#tmpDragRow)) {
        target.after(this.#rippedRowGap);
      } else {
        target.before(this.#rippedRowGap);
      }
    }

    // Scroll viewport if near edges
    const buffer = 100; // Distance from edge to trigger scrolling
    const scrollStep = 8;

    // Start scrolling if in buffer margin
    if (touch.clientY < buffer) {
      this.#startScrolling(-scrollStep);
    } else if (touch.clientY > window.innerHeight - buffer) {
      this.#startScrolling(scrollStep);
    } else {
      this.#stopScrolling();
    }
  }

  touchend() {
    // Restore original row at placeholder's position
    this.#rippedRowGap.replaceWith(this.#tmpDragRow);

    document.body.removeChild(this.dragImage);
    this.dragImage = null;

    this.#indexRows();
    this.#renumberAfterDrag();
  }

  #renumberAfterDrag() {
    let pos = 10;
    this.#table.querySelectorAll('input[type="number"]').forEach(
      (input) => {
        const field = input;
        field.value = pos;
        pos += 10;
      },
    );
  }

  #startScrolling(step) {
    if (this.scrollInterval) return; // Already scrolling
    this.scrollInterval = setInterval(() => {
      window.scrollBy(0, step);
    }, 16); // Approx 60fps
  }

  #stopScrolling() {
    if (this.scrollInterval) {
      clearInterval(this.scrollInterval);
      this.scrollInterval = null;
    }
  }
}
