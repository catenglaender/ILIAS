import SearchableSelect from './searchableselect.class';
import Textarea from '../Textarea/textarea.class';

/**
 * @author Ferdinand Engländer <ferdinand.englaender@concepts-and-training.de>
 */
export default class SearchableSelectFactory {
  /**
     * @type {Array<string, SearchableSelect>}
     */
  instances = [];

  /**
     * @param {string} input_id
     * @return {void}
     * @throws {Error} if the input was already initialized.
     */
  init(input_id, searchfield_id) {
    console.log(`Factory was called with input id: ${input_id}`);
    if (undefined !== this.instances[input_id]) {
      throw new Error(`SearchableSelect with input-id '${input_id}' has already been initialized.`);
    }

    this.instances[input_id] = new SearchableSelect(input_id, searchfield_id);
  }

  /**
     * @param {string} input_id
     * @return {SearchableSelect|null}
     */
  get(input_id) {
    return this.instances[input_id] ?? null;
  }
}
