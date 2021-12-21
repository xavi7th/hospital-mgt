<script>
  export let action;
</script>

{#if action}
  <form on:submit|preventDefault|stopPropagation={action} class="uk-grid uk-form">
    <slot></slot>
  </form>
{:else}
  <form class="uk-grid uk-form">
    <slot></slot>
  </form>
{/if}
