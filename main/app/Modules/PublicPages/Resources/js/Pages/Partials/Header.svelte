<script>
  import { InertiaLink, inertia, page } from '@inertiajs/inertia-svelte';
  import ForexChart from '@miscellaneous-components/ForexChart.svelte';

  export let routes = [];

  $: ({ can_request_alt_deposits } = $page.props);
</script>

<header class="header header-sticky default">
  <nav class="navbar navbar-static-top navbar-expand-xl">

    <ul class="nav navbar-nav">

      {#each Object.entries(routes) as [route_name, route_cont], idx (idx)}
        {#if route_cont.length == 1}
          <li class="nav-item" class:active={route().current(route_cont[0].name)}>
            <InertiaLink class="nav-link" href={route(route_cont[0].name)}>{route_name}</InertiaLink>
          </li>
        {:else if route_cont.length > 1}
          <li>
            <!-- svelte-ignore a11y-missing-attribute -->
            <a>{route_name}<i class="fas fa-chevron-down"></i></a>
            <div class="uk-navbar-dropdown">
              <ul class="uk-nav uk-navbar-dropdown-nav">
                {#each route_cont as elem}
                  <li><InertiaLink href={route(elem.name)}>{elem.menu_name}</InertiaLink></li>
                {/each}
              </ul>
            </div>
          </li>
        {/if}
      {/each}
      {#if can_request_alt_deposits}
        <a use:inertia href="{route('bitcoinpurchaserequests.show')}" class="nav-link">Buy Bitcoin</a>
      {/if}
      <li class="nav-item  d-xl-none d-xxl-none d-lg-none">
        <a class="nav-link" href="{route('auth.login')}">Login</a>
      </li>
      <li class="nav-item  d-xl-none d-xxl-none d-lg-none">
        <a class="nav-link" href="{route('auth.register')}">Register</a>
      </li>
    </ul>

  </nav>
</header>
