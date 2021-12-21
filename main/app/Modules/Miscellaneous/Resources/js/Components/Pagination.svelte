<script>
  import { InertiaLink } from '@inertiajs/inertia-svelte';

  export let links = [];
</script>

<!-- Example Usage -->
<!-- Given:  $: data = $page.contacts.data; $: links = $page.contacts.links; from laravel pagination -->
<!-- <Pagination links={links} /> -->

<!-- dont render, if there's only 1 page (previous, 1, next) -->
{#if links && links.length !== 3}
  <div class="mt-6 -mb-1 flex flex-wrap">
      {#each links as { active, label, url } (label)}
          {#if url === null}
              <!-- Previous, if on first page -->
              <!-- Next, if on last page -->
              <!-- and dots, if exists (...) -->
              <div class="mr-1 mb-1 px-4 py-3 text-sm border rounded text-gray {label === 'Next' && 'ml-auto'}">{label}</div>
          {:else}
              <InertiaLink class="mr-1 mb-1 px-4 py-3 border rounded text-sm hover:bg-white focus:border-indigo-700 focus:text-indigo-700 {active && 'bg-white', label === 'Next' && 'ml-auto'}" href={url}>
                  {label}
              </InertiaLink>
          {/if}
      {/each}
  </div>
{/if}
