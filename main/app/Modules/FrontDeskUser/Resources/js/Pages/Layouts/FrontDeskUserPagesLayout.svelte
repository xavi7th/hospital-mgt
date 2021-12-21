<script>
  import MobileMenu from "@frontdeskuser-pages/Partials/MobileMenu.svelte";
  import ClientMenu from "@frontdeskuser-pages/Partials/ClientMenu.svelte";
  import TopBar from "@frontdeskuser-pages/Partials/TopBar.svelte";
  import { page } from "@inertiajs/inertia-svelte";
  import { onMount } from "svelte";

  let isLoaded = false, pageLoaded = false;

  $: ({ app, authuser, routes, can_update_profile } = $page.props);

  onMount(() => {
    isLoaded = true;
  });
</script>

<svelte:window on:load={() => pageLoaded = true} />

<MobileMenu {routes}/>


<main class="flex">
  <ClientMenu {routes}/>
  <div class="content">
    <TopBar {authuser} {can_update_profile}/>

    <slot {app}/>

  </div>
</main>

<!-- <Footer {app}/> -->

{#if isLoaded && pageLoaded}
  <script src="/js/dashboard-init.js"></script>
{/if}
