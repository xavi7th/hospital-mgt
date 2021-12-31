<script>
    export let label;
    export let name;
    export let className = '';
    export let onChange;
    export let errors = [];
    export let inputIcon = [];
    export let flat = true;

    let val;

    $: props = (({ label, name, className, errors, onChange, value, ...rest }) => rest)($$props);

    export { val };
</script>

<!-- Example Usage -->
<!-- <SelectInput className="uk-margin-small uk-width-1-1 uk-inline" inputIcon="fa-user" label="Role" name="role" value={values.role} onChange={handleChange} bind:value={val}>
  <option value=""></option>
  <option value="user">User</option>
  <option value="owner">Owner</option>
</SelectInput> -->

<!-- <SelectInput className="uk-margin-small uk-width-1-1 uk-inline" inputIcon="fa-user" label="Organization" name="organization_id" errors={errors.organization_id} value={values.organization_id} onChange={handleChange} bind:value={val}>
  <option value=""></option>
  {#each organizations as {id, name} (id)}
      <option value={`${id}`}>{name}</option>
  {/each}
  <option value="CA">Canada</option>
  <option value="US">United States</option>
</SelectInput> -->


{#if flat}
  {#if label}
        <label class="form-label" for={name}>{label}:</label>
    {/if}
    <select id={name} name={name} {...props} class={className} class:error={errors && errors.length} on:change={onChange} bind:value={val}>
      <slot/>
    </select>
{:else}
<div class={className}>
    {#if label}
        <label class="form-label" for={name}>{label}:</label>
    {/if}

    <span class="uk-form-icon uk-form-icon-flip fas {inputIcon} fa-sm"></span>
    <!-- svelte-ignore a11y-no-onchange -->
    <select id={name} name={name} {...props} class="uk-select uk-border-rounded" class:error={errors && errors.length} on:change={onChange} bind:value={val}>
        <slot/>
    </select>

    {#if errors && errors.length}
        <div class="form-error">{errors}</div>
    {/if}
</div>
{/if}
