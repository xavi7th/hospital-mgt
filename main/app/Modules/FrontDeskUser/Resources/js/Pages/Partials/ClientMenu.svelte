<script>
import { page, InertiaLink } from '@inertiajs/inertia-svelte';

$: ({ app } = $page.props);
</script>

<!-- BEGIN: Side Menu -->
<nav class="side-nav">
  <a href="" class="intro-x flex items-center pl-5 pt-4">
      <img alt="{app.name} logo" class="w-6" src="dist/images/logo.png" style="width: 150px;">
  </a>
  <div class="side-nav__devider my-6"></div>
  <ul>
    <li>
      <InertiaLink href="{route('frontdeskusers.dashboard')}" class="side-menu {$page.url.includes('dashboard') ? 'side-menu--active' : ''}">
        <div class="side-menu__icon"> <i data-feather="home"></i> </div>
        <div class="side-menu__title"> Dashboard</div>
      </InertiaLink>
    </li>
    <li>
      <InertiaLink href="{route('patients.index')}" class="side-menu {$page.url.includes('/patients') ? 'side-menu--active' : ''}">
        <div class="side-menu__icon"> <i data-feather="users"></i> </div>
        <div class="side-menu__title"> Patients</div>
      </InertiaLink>
    </li>
    <li>
      <InertiaLink href="{route('appointments.index')}" class="side-menu {$page.url.includes('/appointments') ? 'side-menu--active' : ''}">
        <div class="side-menu__icon"> <i data-feather="search"></i> </div>
        <div class="side-menu__title"> Appointments</div>
      </InertiaLink>
    </li>
  </ul>
</nav>
<!-- END: Side Menu -->
