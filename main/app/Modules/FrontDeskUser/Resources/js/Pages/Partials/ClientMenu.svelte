<script>
import { page, InertiaLink } from '@inertiajs/inertia-svelte';

$: ({ app } = $page.props);

export let routes = {};
</script>

<!-- BEGIN: Side Menu -->
<nav class="side-nav">
  <a href="" class="intro-x flex items-center pl-5 pt-4">
      <img alt="{app.name} logo" class="w-6" src="dist/images/logo.png" style="width: 150px;">
  </a>
  <div class="side-nav__devider my-6"></div>
  <ul>
    {#if route().current('frontdeskusers.activation.pending')}
      <li>
        <InertiaLink href="{route('frontdeskusers.activation.pending')}" class="side-menu side-menu--active">
          <div class="side-menu__icon"> <i data-feather="home"></i> </div>
          <div class="side-menu__title"> Pending Activation </div>
        </InertiaLink>
      </li>
    {:else}
      {#each Object.entries(routes) as [route_name, route_cont], idx (idx)}
        {#if route_cont.length == 1}
          <li>
            <InertiaLink href={route(route_cont[0].name)} class="side-menu { route().current(route_cont[0].name) ? 'side-menu--active' : ''}" >
              <div class="side-menu__icon"> <i data-feather="{route_cont[0].icon}"></i> </div>
              <div class="side-menu__title"> {route_name} </div>
            </InertiaLink>
          </li>

        {:else if route_cont.length > 1}
          <li>
            <InertiaLink href={route(route_cont[0].name)} class="side-menu { route().current(route_cont[0].name) ? 'side-menu--active' : ''}" >
              <div class="side-menu__icon"> <i data-feather="{route_cont[0].icon}"></i> </div>
              <div class="side-menu__title"> {route_name} </div>
            </InertiaLink>
          </li>
        {/if}
      {/each}
    {/if}
  </ul>
</nav>
<!-- END: Side Menu -->
