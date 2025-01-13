import SearchableInputContext from "./searchablecontext.class";

/**
 * @author Ferdinand Engländer <ferdinand.englaender@concepts-and-training.de>
 */
export default class SearchableInputContextFactory {
  /**
     * @type {Array<string, SearchableInputContext>}
     */
  instances = [];

  /**
     * @param {string} input_id
     * @return {void}
     * @throws {Error} if the input was already initialized.
     */
  init(input_id) {
    console.log(`Factory was called with input id: ${input_id}`);
    if (undefined !== this.instances[input_id]) {
      throw new Error(`SearchableSelect with input-id '${input_id}' has already been initialized.`);
    }

    const inputFieldContext = document.getElementById(input_id);

    this.instances[input_id] = new SearchableInputContext(inputFieldContext);
  }

  /**
     * @param {string} input_id
     * @return {SearchableInputContext|null}
     */
  get(input_id) {
    return this.instances[input_id] ?? null;
  }
}
