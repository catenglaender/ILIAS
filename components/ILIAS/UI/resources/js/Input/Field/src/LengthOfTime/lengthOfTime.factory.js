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

import LengthOfTime from './lengthOfTime.class.js';

export default class LengthOfTimeFactory {
  /**
   * @type {Array<string, LengthOfTime>}
   */
  #instances = [];

  /**
   * @param {HTMLElement} container
   * @param {string} patternType
   * @param {string} translationStringTo
   */
  init(container, patternType, translationStringTo) {
    if (this.#instances[container.id] !== undefined) {
      throw new Error(`LengthOfTime input with id '${container.id}' has already been initialized.`);
    }

    const inputsAsc = [];
    let timeStepsAsc = [];

    switch (patternType) {
      case 'hoursMinutes':
        inputsAsc.push(container.querySelector("input[name*='minutes']"));
        inputsAsc.push(container.querySelector("input[name*='hours']"));
        timeStepsAsc = [60];
        break;
      case 'minutesSeconds':
        inputsAsc.push(container.querySelector("input[name*='seconds']"));
        inputsAsc.push(container.querySelector("input[name*='minutes']"));
        timeStepsAsc = [60];
        break;
      case 'hoursMinutesSeconds':
        inputsAsc.push(container.querySelector("input[name*='seconds']"));
        inputsAsc.push(container.querySelector("input[name*='minutes']"));
        inputsAsc.push(container.querySelector("input[name*='hours']"));
        timeStepsAsc = [60, 60];
        break;
      case 'daysHoursMinutes':
        inputsAsc.push(container.querySelector("input[name*='minutes']"));
        inputsAsc.push(container.querySelector("input[name*='hours']"));
        inputsAsc.push(container.querySelector("input[name*='days']"));
        timeStepsAsc = [60, 24];
        break;
      default:
        break;
    }

    const infobox = container.querySelector(
      '.c-input-length-of-time__calc-message',
    );
    const infoboxScreenReader = container.querySelector(
      '.c-input-length-of-time__calc-message-sr',
    );

    this.#instances[container.id] = new LengthOfTime(
      container,
      inputsAsc,
      timeStepsAsc,
      infobox,
      infoboxScreenReader,
      translationStringTo,
    );
  }

  /**
   * @param {string} fieldId
   * @return {LengthOfTime|null}
   */
  get(fieldId) {
    return this.#instances[fieldId] ?? null;
  }
}
