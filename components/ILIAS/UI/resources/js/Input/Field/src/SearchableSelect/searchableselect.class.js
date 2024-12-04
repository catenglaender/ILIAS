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

/**
 * Searchable Select Component
 * JS features:
 *    - search bar input filters (hides) list items
 *    - button to clear the filter
 *    - expanding and collapsing the component (hiding and showing elements) with button triggers
 * SCSS features:
 *    - pushing checked items to the top of the list using flex-box order
 *    - component expanding animation
 *    - item switching position animation
 * @author Ferdinand Engländer <ferdinand.englaender@concepts-and-training.de>
 */
export default class SearchableSelect {
  /**
   * @type {HTMLFieldSetElement}
   */
  searchableSelect;

  /**
   * @type {HTMLInputElement}
   */
  searchbar;

  /**
   * @type {HTMLFieldSetElement}
   */
  selectionComponent;

  /**
   * @type {string}
   */
  listType;

  /**
   * @type {HTMLDivElement}
   */
  itemList;

  /**
   * @type {NodeList}
   */
  selectionComponentItems;

  /**
   * @type {HTMLButtonElement}
   */
  engageButton;

  /**
   * @type {HTMLButtonElement}
   */
  disengageButton;

  /**
   * @type {HTMLButtonElement}
   */
  clearSearchButton;

  /**
   * @type {boolean}
   */
  #isFiltered;

  /**
   * @type {boolean}
   */
  #isEngaged;

  constructor(input_id) {
    /* DOM Elements */
    this.searchableSelect = document.getElementById(input_id);
    // first input is always search bar
    this.searchbar = this.searchableSelect.getElementsByTagName("input")[0];
    // second .c-input is always the nested selection component
    this.selectionComponent = this.searchableSelect.querySelectorAll(".c-input__field .c-input")[1];
    this.itemList = this.selectionComponent.querySelector(".c-input__field");
    console.log("item list set up: " + this.itemList)
    this.listType = this.selectionComponent.getAttribute("data-il-ui-component");
    switch (this.listType) {
      case "multi-select-field-input":
        this.selectionComponentItems = this.selectionComponent.querySelectorAll(".c-input__field ul li");
        break;
      case "radio-field-input":
        this.selectionComponentItems = this.selectionComponent.querySelectorAll(".c-input__field .c-field-radio .c-field-radio__item");
        break;
    }

    /* Buttons */
    this.clearSearchButton = this.searchableSelect.getElementsByTagName('button')[0];
    this.disengageButton = this.searchableSelect.getElementsByTagName("button")[1];
    this.engageButton = this.searchableSelect.getElementsByTagName("button")[2];

    /* Initialize states */
    this.isEngaged = false; // will also set isFiltered false

    /* Event Listeners */
    this.filterItemsSearch = this.filterItemsSearch.bind(this);
    this.searchbar.addEventListener('input', this.filterItemsSearch);

    this.clearSearchButton.addEventListener('click', () => { this.isFiltered = false });

    this.disengageButton.addEventListener('click', () => { this.isEngaged = false });

    this.engageButton.addEventListener('click', () => { this.isEngaged = true });

    if (this.listType === "radio-field-input") {
      this.scrollListToTop = this.scrollListToTop.bind(this);
      this.selectionComponentItems.forEach(item => {
        console.log("item: " + item)
        item.addEventListener('change', this.scrollListToTop);
      })

    }

  }

  /**
   * Getter for isEngaged state
   * @returns {boolean}
   */
  get isEngaged() {
    return this.#isEngaged;
  }

  /**
   * Setter for isEngaged state
   * Disengaging the component resets the filter
   * @param {boolean} value
   */
  set isEngaged(value) {
    if (this.#isEngaged === value) return; // Avoid unnecessary updates
    this.#isEngaged = value;

    switch (value) {
      case true:
        this.searchableSelect.classList.add("engaged")
        break;
      case false:
        this.searchableSelect.classList.remove("engaged")
        this.isFiltered = false;
        break;
    }
  }

  /**
   * Getter for isFiltered state
   * @returns {boolean}
   */
  get isFiltered() {
    return this.#isFiltered;
  }

  /**
   * Setter for isFiltered state
   * @param {boolean} value
   */
  set isFiltered(value) {
    if (this.#isFiltered === value) return; // Avoid unnecessary updates
    this.#isFiltered = value;

    switch (value) {
      case true:
        this.clearSearchButton.style.removeProperty("display");
        break;
      case false:
        this.searchbar.value = '';
        this.clearSearchButton.style.display = "none";
        this.resetItemsDisplay();
        break;
    }
  }

  /**
   * Filter items based on search input
   * @param {Event} event
   */
  filterItemsSearch(event) {
    const value = event.target.value.toLowerCase();

    this.isFiltered = !!value; // negates any search term input to false then flips it to true

    this.selectionComponentItems.forEach(item => {
      const itemText = item.textContent.toLowerCase();
      const isMatch = itemText.includes(value);
      if (isMatch) {
        this.showItem(item);
      } else {
        this.hideItem(item);
      }
    });
  }

  /**
   * Reset the display of all items
   */
  resetItemsDisplay() {
    this.selectionComponentItems.forEach(item => this.showItem(item));
  }

  /**
   * Show a specific item
   * @param {HTMLElement} item
   */
  showItem(item) {
    item.style.transform = "scale(1,1)";
    item.style.removeProperty("display");
  }

  /**
   * Hide a specific item
   * @param {HTMLElement} item
   */
  hideItem(item) {
    item.style.transform = "scale(1,0)";
    item.style.display = "none";
  }

  scrollListToTop(event) {
    console.log("attempting to scroll to top because of event: " + event)
    this.itemList.scrollTo({
      top: 0,
      behavior: "smooth",
    })
  }
}
