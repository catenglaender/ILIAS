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

import { beforeEach, describe, it } from 'node:test';
import { strict } from 'node:assert/strict';
import { JSDOM } from 'jsdom';
import LengthOfTimeClass from '../../../../resources/js/Input/Field/src/LengthOfTime/lengthOfTime.class.js';
import LengthOfTimeFactory from '../../../../resources/js/Input/Field/src/LengthOfTime/lengthOfTime.factory.js';

let lengthOfTimeFactory;

function init() {
  lengthOfTimeFactory = new LengthOfTimeFactory();
}

describe('Length Of Time Input Field helpers', () => {
  beforeEach(init);

  it('can overflow minutes to hours.', () => {
    const normalizeTime = LengthOfTimeClass.calculateTimeOverflow(93, 0, 60);
    const expectedNormalizedTime = [33, 1];
    strict.deepEqual(normalizeTime, expectedNormalizedTime);
  });

  it('can overflow hours to days.', () => {
    const normalizeTime = LengthOfTimeClass
      .calculateTimeOverflow(50, 0, 24);
    const expectedNormalizedTime = [2, 2];
    strict.deepEqual(normalizeTime, expectedNormalizedTime);
  });

  it('can overflow minutes to hours to days', () => {
    const normalizeTime = LengthOfTimeClass
      .calculateTimeOverflowForMultipleSteps([90, 23, 0], [60, 24]);
    const expectedNormalizedTime = [30, 0, 1];
    strict.deepEqual(normalizeTime, expectedNormalizedTime);
  });

  it('can overflow seconds to minutes to hours', () => {
    const normalizeTime = LengthOfTimeClass
      .calculateTimeOverflowForMultipleSteps([62, 93, 0], [60, 60]);
    const expectedNormalizedTime = [2, 34, 1];
    strict.deepEqual(normalizeTime, expectedNormalizedTime);
  });
});

let dom;
let container;

function initDOM2fields() {
  init();
  dom = new JSDOM(
    `
      <div id="field-hours-minutes" class='length-of-time'>
        <input type='numeric' name='hours' value='0'>
        <input type='numeric' name='minutes' value='90'>
      </div>
      `,
    {
      url: 'https://localhost',
    },
  );

  container = dom.window.document.querySelector('#field-hours-minutes');
}

describe('Length Of Time DOM Inputs', () => {
  beforeEach(initDOM2fields);

  it('can initialize', () => {
    lengthOfTimeFactory.init(container, 'hoursMinutes', 'to');
    const instance = lengthOfTimeFactory.get('field-hours-minutes');
    strict.deepEqual((instance instanceof LengthOfTimeClass), true);
  });

  it('can process minute to hour overflow', () => {
    lengthOfTimeFactory.init(container, 'hoursMinutes', 'to');
    const instance = lengthOfTimeFactory.get('field-hours-minutes');
    instance.applyTimeOverflow();

    const inputs = container.querySelectorAll('input');

    strict.deepEqual(inputs[0].value, '1');
    strict.deepEqual(inputs[1].value, '30');
  });
});
