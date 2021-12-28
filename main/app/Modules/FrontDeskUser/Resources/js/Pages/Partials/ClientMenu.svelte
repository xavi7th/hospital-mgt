<script>
import { page, InertiaLink } from '@inertiajs/inertia-svelte';

$: ({ app } = $page.props);

// export let routes = {};
let currentRoute = route().current();
</script>

<!-- BEGIN: Side Menu -->
<nav class="side-nav">
  <a href="" class="intro-x flex items-center pl-5 pt-4">
      <img alt="{app.name} logo" class="w-6" src="dist/images/logo.png" style="width: 150px;">
  </a>
  <div class="side-nav__devider my-6"></div>
  <ul>
    <li>
      <InertiaLink href="{route('superadmins.dashboard')}" class="side-menu {currentRoute === 'dashboard' ? 'side-menu--active' : ''}" on:click="{() => currentRoute = 'dashboard'}">
        <div class="side-menu__icon"> <i data-feather="home"></i> </div>
        <div class="side-menu__title"> Dashboard</div>
      </InertiaLink>
    </li>
    <li>
      <a href="javascript:;" class="side-menu {(currentRoute === 'frontdeskusers.list' || currentRoute === 'frontdeskusers.create_users' || currentRoute === 'frontdeskusers.remove_users') ? 'side-menu--active' : ''}">
          <div class="side-menu__icon"> <i data-feather="users"></i> </div>
          <div class="side-menu__title"> Front Desk Users <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
      </a>
      <ul class="">
          <li>
              <InertiaLink href="{route('frontdeskusers.list')}" class="side-menu" on:click="{() => currentRoute = 'frontdeskusers.list'}">
                  <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                  <div class="side-menu__title"> Users list </div>
              </InertiaLink>
          </li>
          <li>
              <InertiaLink href="{route('frontdeskusers.create_users')}" class="side-menu" on:click="{() => currentRoute = 'frontdeskusers.create_users'}">
                  <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                  <div class="side-menu__title"> Create Users </div>
              </InertiaLink>
          </li>
          <li>
              <InertiaLink href="{route('frontdeskusers.remove_users')}" class="side-menu" on:click="{() => currentRoute = 'frontdeskusers.remove_users'}">
                  <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                  <div class="side-menu__title"> Delete Users </div>
              </InertiaLink>
          </li>
      </ul>
    </li>

    <!-- {#if route().current('frontdeskusers.activation.pending')}
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
    {/if} -->
  </ul>
</nav>
<!-- END: Side Menu -->
