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

export default class LengthOfTimeClass {
  /**
   * @type {HTMLElement}
   */
  #container;

  /**
   * @type {array<HTMLInputElement>}
   */
  #inputsAsc;

  /**
   * @type {array<number>}
   */
  #timeStepAsc;

  /**
   * @type {HTMLElement}
   */
  #infobox;

  /**
   * @type {HTMLOutputElement}
   */
  #infoboxScreenReader;

  /**
   * @type {string}
   */
  #translationStringTo;

  /**
   * @type {boolean|null}
   */
  #timeOverflowOccured;

  /**
   * @type {string}
   */
  #previousValue;

  /**
   * @type {string}
   */
  #currentValue;

  /**
   * Manages a Length of Time form input. Consists out of multiple text fields,
   * one for each time unit (e.g. hours & minutes or days, hours & minutes)
   * @param {HTMLElement} field
   * @param {array<HTMLInputElement>} inputsAsc
   * @param {array<Number>} timeStepAsc
   * @param {HTMLElement} infobox
   * @param {HTMLOutputElement} infoboxScreenReader
   * @param {string} translationStringTo
   */
  constructor(
    field,
    inputsAsc,
    timeStepAsc,
    infobox,
    infoboxScreenReader,
    translationStringTo,
  ) {
    // basic landmarks
    this.#container = field;
    this.#inputsAsc = inputsAsc;

    // time overflow conversion
    this.#timeStepAsc = timeStepAsc;
    this.#previousValue = null;
    this.#currentValue = null;
    this.#timeOverflowOccured = null;

    // user notification for time overflow
    this.#infobox = infobox;
    this.#infoboxScreenReader = infoboxScreenReader;
    this.#translationStringTo = translationStringTo;

    // all events
    this.#inputsAsc.forEach((input) => {
      input.addEventListener('blur', () => this.handleUserMovingFocus());
      input.addEventListener('input', () => this.hideOutputNotification());
    });
  }

  /**
   * @return {void}
   */
  handleUserMovingFocus() {
    this.applyTimeOverflow();
    if (this.#timeOverflowOccured) {
      this.newOutputNotification();
    }
  }

  newOutputNotification() {
    const resultString = `
      ${this.#previousValue} ${this.#translationStringTo} ${this.#currentValue}
     `;

    // visual update
    if (this.#infobox.classList.contains('hidden')) {
      this.#infobox.classList.remove('hidden');
    }
    this.#infobox.querySelector('.c-input-length-of-time__result').innerHTML = resultString;

    // update for screen reader
    this.#infoboxScreenReader.querySelector('.c-input-length-of-time__result').innerHTML = resultString;
  }

  hideOutputNotification() {
    if (!this.#infobox.classList.contains('hidden')) {
      this.#infobox.classList.add('hidden');
    }
  }

  /**
   * If necessary, time values in input fields are recalculated so they flow into the
   * next higher unit (e.g. 01 minute 60 seconds becomes 02 minutes 00 seconds)
   * @return {void}
   */
  applyTimeOverflow() {
    const inputValues = this.#inputsAsc.map((input) => Number(input.value));

    const normalizedValues = LengthOfTimeClass
      .calculateTimeOverflowForMultipleSteps(inputValues, this.#timeStepAsc);
    this.#previousValue = LengthOfTimeClass.buildStringValueDescUnits(inputValues);
    this.#currentValue = LengthOfTimeClass.buildStringValueDescUnits(normalizedValues);

    if (this.#previousValue === this.#currentValue) {
      this.#timeOverflowOccured = false;
      return;
    }

    this.#timeOverflowOccured = true;

    this.#inputsAsc.forEach((input, index) => {
      input.value = normalizedValues[index].toString();
    });
  }

  /**
   * Creates strings with two digit paddings like hh:mm from arrays
   * sorted by ascending time units.
   * @param {array<Number>} arrayAscUnits
   */
  static buildStringValueDescUnits(arrayAscUnits) {
    const reversedArray = [...arrayAscUnits].reverse();

    return reversedArray
      .map((number) => number.toString().padStart(2, '0'))
      .join(':');
  }

  /**
   *
   * @param {array<number>} valuesUnitsAsc
   * @param {array<number>} stepsAsc
   */
  static calculateTimeOverflowForMultipleSteps(valuesUnitsAsc, stepsAsc) {
    const normalizedValues = [...valuesUnitsAsc];

    stepsAsc.forEach((step, index) => {
      const normalizedPair = LengthOfTimeClass.calculateTimeOverflow(
        normalizedValues[index],
        normalizedValues[index + 1],
        step,
      );
      [normalizedValues[index], normalizedValues[index + 1]] = normalizedPair;
    });

    return normalizedValues;
  }

  /**
   * Takes time in two ascending units with the conversion factor between them.
   * @param {int} lowerUnitValue
   * @param {int} higherUnitValue
   * @param {int} step
   * @return {array<int>}
   */
  static calculateTimeOverflow(lowerUnitValue, higherUnitValue, step) {
    let normalizedHigherUnitValue = higherUnitValue;
    normalizedHigherUnitValue += Math.trunc(lowerUnitValue / step);
    const normalizedLowerUnitValue = lowerUnitValue % step;
    return [normalizedLowerUnitValue, normalizedHigherUnitValue];
  }
}
