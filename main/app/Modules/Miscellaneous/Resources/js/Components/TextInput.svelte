<script>
  // export let onChange;
  export let label;
  export let inputIcon ="fa-user";
  export let placeHolder;
  export let name;
  export let className = '';
  export let errors = [];
  export let flat = true;

  let val;

  $: props = (({ onChange, label, name, className, errors, flat, ...rest }) => rest)($$props);


  /**
   * ! Whatever you export like this can be bound to in the component eg bind:checked:{details.property}
   */
   export { val };
</script>

<!-- Example Usage -->
<!-- <TextInput className="uk-margin-small uk-width-1-1 uk-inline" label="Password" name="password" type="password" inputIcon="fa-user" placeHolder="Username" errors={errors.password} bind:val={details.password}/> -->
<!-- <TextInput flat={true} label="Your Mobile Number" className="input w-full border mt-2" required placeHolder="Enter Phone Number" name="phone" type="text" errors={errors.phone} value={details.phone} bind:val={details.phone}/> -->

{#if flat}
  {#if label}
        <label class="form-label" for={name}>{label}:</label>
    {/if}
   <input id={name} name={name} {...props} bind:value="{val}" class={className} {placeHolder} class:error={errors && errors.length}/>
{:else}
  <div class={className}>
    {#if label}
        <label class="form-label" for={name}>{label}:</label>
    {/if}

    <span class="uk-form-icon uk-form-icon-flip fas {inputIcon} fa-sm"></span>
    <input id={name} name={name} {...props} bind:value="{val}" class="uk-input uk-border-rounded" {placeHolder} class:error={errors && errors.length}/>

    {#if errors && errors.length}
        <div class="form-error">{errors}</div>
    {/if}
  </div>
{/if}
