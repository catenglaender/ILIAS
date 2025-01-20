import SearchableInputContext from './searchablecontext.class';

/**
 * @author Ferdinand Engländer <ferdinand.englaender@concepts-and-training.de>
 */
export default class SearchableInputContextFactory {
  /**
     * @type {Array<string, SearchableInputContext>}
     */
  instances = [];

  /**
     * @param {string} inputID
     * @return {void}
     * @throws {Error} if the input was already initialized.
     */
  init(inputID) {
    if (undefined !== this.instances[inputID]) {
      throw new Error(`SearchableSelect with input-id '${inputID}' has already been initialized.`);
    }

    const inputFieldContext = document.getElementById(inputID);

    this.instances[inputID] = new SearchableInputContext(inputFieldContext);
  }

  /**
     * @param {string} inputID
     * @return {SearchableInputContext|null}
     */
  get(inputID) {
    return this.instances[inputID] ?? null;
  }
}
