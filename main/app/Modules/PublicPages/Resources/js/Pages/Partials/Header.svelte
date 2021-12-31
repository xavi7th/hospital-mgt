<script>
  import { InertiaLink, page } from '@inertiajs/inertia-svelte';

  export let routes = [];
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
      <li class="nav-item  d-xl-none d-xxl-none d-lg-none">
        <a class="nav-link" href="{route('auth.login')}">Login</a>
      </li>
    </ul>

  </nav>
</header>
