<script>
import { InertiaLink, inertia } from '@inertiajs/inertia-svelte';

export let routes = [];
</script>


<!-- BEGIN: Mobile Menu -->
<div class="mobile-menu md:hidden">
  <div class="mobile-menu-bar">
    <a href="" class="flex mr-auto">
      <img alt="LOGO" class="w-6" src="/img/logo.svg">
    </a>
    <a href="javascript:;" id="mobile-menu-toggler">
      <i data-feather="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i>
    </a>
  </div>
  <ul class="border-t border-theme-24 py-5 hidden">
    {#if route().current('frontdeskusers.activation.pending')}
      <li>
        <InertiaLink href="{route('frontdeskusers.activation.pending')}" class="menu menu--active">
          <div class="menu__icon"> <i data-feather="home"></i> </div>
          <div class="menu__title"> Pending Activation </div>
        </InertiaLink>
      </li>
    {:else}
      {#each Object.entries(routes) as [route_name, route_cont], idx (idx)}
        {#if route_cont.length == 1}
          <li>
            <InertiaLink href={route(route_cont[0].name)} class="menu menu--active">
              <div class="menu__icon"> <i data-feather="{route_cont[0].icon}"></i> </div>
              <div class="menu__title"> {route_name} </div>
            </InertiaLink>
          </li>

        {:else if route_cont.length > 1}
          <li>
            <InertiaLink href={route(route_cont[0].name)} class="menu menu--active">
                <div class="menu__icon"> <i data-feather="{route_cont.icon}"></i> </div>
                <div class="menu__title"> {route_name} </div>
            </InertiaLink>
          </li>
        {/if}
      {/each}
    {/if}
    <li>
      <a href={route('auth.logout')} use:inertia={{method:'post'}} class="menu">
        <div class="menu__icon"> <i data-feather="log-out"></i> </div>
        <div class="menu__title"> Logout </div>
      </a>
    </li>
  </ul>
</div>
<!-- END: Mobile Menu -->
