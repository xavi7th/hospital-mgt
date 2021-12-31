<script>
  import MobileMenu from "@frontdeskuser-pages/Partials/MobileMenu.svelte";
  import ClientMenu from "@frontdeskuser-pages/Partials/ClientMenu.svelte";
  import SuperAdminMenu from "@superadmin-pages/Partials/SuperAdminMenu.svelte";
  import DoctorMenu from "@doctor-pages/Partials/DoctorMenu.svelte";
  import NurseMenu from "@nurse-pages/Partials/NurseMenu.svelte";
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
  {#if authuser.isFrontDeskUser}
    <ClientMenu {routes}/>
  {:else if authuser.isSuperAdmin}
    <SuperAdminMenu {routes}/>
  {:else if authuser.isDoctor}
    <DoctorMenu {routes}/>
  {:else if authuser.isNurse}
    <NurseMenu {routes}/>
  {/if}
  <div class="content">
    <TopBar {authuser} {can_update_profile}/>

    <slot {app}/>

  </div>
</main>

<!-- <Footer {app}/> -->

{#if isLoaded && pageLoaded}
  <script src="/js/dashboard-init.js"></script>
{/if}
