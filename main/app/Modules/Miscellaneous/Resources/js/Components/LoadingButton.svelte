<script>
    export let loading, className = '';

    $: props = (({loading, className, ...rest}) => rest)($$props); // pass all other props passed down e.g type=submit to the props variable
</script>

<style>
  :disabled{
    filter: contrast(0.5);
    cursor:no-drop;
  }
</style>

<!-- Example Usage -->
<!-- <LoadingButton type="submit" loading={sending} className="uk-button-primary uk-border-rounded uk-float-left">Sign in</LoadingButton> -->

<button disabled={loading} class="uk-button uk-width-1-1 {className}" {...props}>
  <slot/>
  {#if loading}<i class="fas fa-spinner fa-spin"/>{/if}
</button>
