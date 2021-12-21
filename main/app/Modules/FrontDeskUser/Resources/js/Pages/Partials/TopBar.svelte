<script>
  import { inertia } from '@inertiajs/inertia-svelte';

  export let authuser = {}, can_update_profile = false;
</script>

<style lang="scss">
  .dropdown-box.right-0{
    @media (max-width: 767px) {
      right: auto;
    }
  }
</style>

<!-- BEGIN: Top Bar -->
<div class="top-bar">
  <!-- BEGIN: Breadcrumb -->
  <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <!-- svelte-ignore a11y-missing-attribute -->
    <a style="text-transform: capitalize">{ authuser.name }</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="" class="breadcrumb--active">Dashboard</a>
  </div>
  <!-- END: Breadcrumb -->
  <!-- BEGIN: Account Menu -->
  <div class="intro-x dropdown w-8 h-8 relative">
    <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in">
        <img alt="" src="{authuser.avatar_url || '/img/userimg.png'}">
    </div>
    <div class="dropdown-box mt-10 absolute w-56 top-0 right-0 z-20">
      <div class="dropdown-box__content box bg-theme-38 dark:bg-dark-6 text-white">
        <div class="p-4 border-b border-theme-40 dark:border-dark-3">
            <div class="font-medium" style="text-transform: capitalize">{ authuser.name }</div>
            <div class="text-xs text-theme-41 dark:text-gray-600">Online</div>
        </div>
        {#if can_update_profile}
          <div class="p-2">
              <a href="{ route('frontdeskusers.profile') }" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md">
                <i data-feather="user" class="w-4 h-4 mr-2"></i> Profile
              </a>
          </div>
        {/if}
        <div class="p-2 border-t border-theme-40 dark:border-dark-3">
          <a href={route('auth.logout')} use:inertia={{method:'post'}} class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md">
            <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> Logout
          </a>
        </div>
      </div>
    </div>
</div>
  <!-- END: Account Menu -->
</div>
<!-- END: Top Bar -->
