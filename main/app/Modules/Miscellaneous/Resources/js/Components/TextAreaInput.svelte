<script>
  export let onChange;
  export let label;
  export let name;
  export let className = '';
  export let errors = [];

  $: props = (({ onChange, label, name, className, errors, ...rest }) => rest)($$props);
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

<!-- <TextAreaInput className="pr-6 pb-8 w-full lg:w-1/2" label="Phone" name="phone" type="text" errors={errors.phone} value={values.phone} onChange={handleChange}/> -->

<div class={className}>
  {#if label}
      <label class="form-label" for={name}>{label}:</label>
  {/if}

  <textarea id={name} name={name} {...props} on:change={onChange} class="form-input" class:error={errors && errors.length}>
    <slot></slot>
  </textarea>

  {#if errors && errors.length}
      <div class="form-error">{errors[0]}</div>
  {/if}
</div>
