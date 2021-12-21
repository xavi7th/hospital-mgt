<script>
  import { createEventDispatcher } from "svelte";

  const dispatch = createEventDispatcher();
  let  checked = false, house = 'hello';

  export let label = 'I need a label', name, className = '', errors = [];

  /**
   * ! Whatever you export like this can be bound to in the component eg bind:checked:{details.property}
   */
  export { checked };

  const handleChange = () => {
    checked = !checked;
    dispatch("change", checked);
  };

  $: props = (({ onChange, label, name, className, errors, type, ...rest }) => rest)($$props);
</script>

<!-- Example Usage -->
<!-- Given this function defined in the parent
function handleChange({ target: { name, value } }) {
  details = {
      ...details,
      [name]: value
  };
}
ALT: Use emit to emit the value and accept it to update what you need to update
-->

<!-- <CheckBoxInput className="uk-margin-small uk-width-auto uk-text-small" label="Remember me" name="remember" errors={errors.remember} bind:checked={details.remember}/> -->
<!-- <CheckBoxInput className="uk-margin-small uk-width-auto uk-text-small" label="Remember me" name="remember" errors={errors.remember} on:change={(e) => details.remember = e.detail.checked }/> -->

<div class={className}>

  <label for={name}>
    <input id={name} name={name} {...props} type="checkbox" on:change={handleChange} class="uk-checkbox uk-border-rounded" class:error={errors && errors.length}/>
    <span class="ml-2 text-sm text-gray-600">{label}</span>
  </label>

  {#if errors && errors.length}
      <div class="form-error">{errors}</div>
  {/if}
</div>
