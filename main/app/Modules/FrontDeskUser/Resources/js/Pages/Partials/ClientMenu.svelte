<script>
import { page, InertiaLink } from '@inertiajs/inertia-svelte';

$: ({ app } = $page.props);

// export let routes = {};
$: currentRoute = route().current();
</script>

<!-- BEGIN: Side Menu -->
<nav class="side-nav">
  <a href="" class="intro-x flex items-center pl-5 pt-4">
      <img alt="{app.name} logo" class="w-6" src="dist/images/logo.png" style="width: 150px;">
  </a>
  <div class="side-nav__devider my-6"></div>
  <ul>
    <li>
      <InertiaLink href="{route('superadmins.dashboard')}" class="side-menu {currentRoute === 'superadmins.dashboard' ? 'side-menu--active' : ''}">
        <div class="side-menu__icon"> <i data-feather="home"></i> </div>
        <div class="side-menu__title"> Dashboard</div>
      </InertiaLink>
    </li>
    <li>
      <InertiaLink href="{route('frontdeskusers.index')}" class="side-menu {currentRoute === 'frontdeskusers.index' ? 'side-menu--active' : ''}">
        <div class="side-menu__icon"> <i data-feather="user"></i> </div>
        <div class="side-menu__title"> Front Desk Users</div>
      </InertiaLink>
    </li>
    <li>
      <InertiaLink href="{route('doctors.index')}" class="side-menu {currentRoute === 'doctors.index' ? 'side-menu--active' : ''}">
        <div class="side-menu__icon"> <i data-feather="users"></i> </div>
        <div class="side-menu__title"> Doctors</div>
      </InertiaLink>
    </li>
    <li>
      <InertiaLink href="{route('nurses.index')}" class="side-menu {currentRoute === 'nurses.index' ? 'side-menu--active' : ''}">
        <div class="side-menu__icon"> <i data-feather="users"></i> </div>
        <div class="side-menu__title"> Nurses</div>
      </InertiaLink>
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
