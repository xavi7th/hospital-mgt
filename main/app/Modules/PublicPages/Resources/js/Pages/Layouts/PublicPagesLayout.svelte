<script>
  import Header from "@PublicPages/Partials/Header.svelte";
  import Footer from "@PublicPages/Partials/Footer.svelte";
  import { page } from "@inertiajs/inertia-svelte";
  import { onMount } from "svelte";

  let isLoaded = false, pageLoaded = false;

  $: ({ routes, app, can_request_alt_deposits } = $page.props);

  onMount(() => {
    isLoaded = true;
  });
</script>

<svelte:window on:load={() => pageLoaded = true} />

{#if ! route().current('auth.*')}
   <Header {routes} {app} {can_request_alt_deposits}/>
{/if}

<slot {app}/>

{#if ! route().current('auth.*')}
   <Footer {app}/>
{/if}


{#if isLoaded && pageLoaded}
  <script src="/js/app-init.js"></script>
{/if}
