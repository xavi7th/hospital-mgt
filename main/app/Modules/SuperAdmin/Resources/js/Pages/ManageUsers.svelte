<script context="module">
  import FrontDeskUserPagesLayout from "@frontdeskuser-pages/Layouts/FrontDeskUserPagesLayout.svelte";
  export const layout = FrontDeskUserPagesLayout
</script>

<script>
  import InertiaLink from '@inertiajs/inertia-svelte/src/InertiaLink.svelte';
  import ConfirmModal from '@miscellaneous-components/ConfirmModal.svelte';
  import FileInput from '@miscellaneous-components/FileInput.svelte';
  import Modal from '@miscellaneous-components/Modal.svelte';
  import { page } from '@inertiajs/inertia-svelte';
  import { Inertia } from '@inertiajs/inertia';

  $: ({ errors } = $page.props);

  // export let users = [],
  //   must_verify_users = false,
  //   can_delete_users = false;

    let actionUrl, actionMethod, details={}, userDetails;

  let searchTerm = "";

	$: filteredList = front_desk_users.filter(item => item.name.toLowerCase().indexOf(searchTerm.toLowerCase()) !== -1 || item.email.indexOf(searchTerm.toLowerCase()) !== -1);

  export let front_desk_users = {},
    must_verify_users = false,
    can_delete_users = false,
    total_registered_front_desk_users = front_desk_users.length,
    total_unverified_front_desk_users = 0;

    front_desk_users.forEach(element => {
      if(!element.is_active){
        total_unverified_front_desk_users++
      }
    });

  let createUser = () => {
    BlockToast.fire({text:'Creating fron desk user account. Please wait ...'})

    Inertia.post(route('frontdeskusers.create'), details);
  }

</script>

<div class="grid grid-cols-12 gap-6">
  <div class="col-span-12 mt-8">
      <div class="intro-y flex items-center h-10">
          <a href="javascript:;" class="button bg-theme-10 mt-2 mb-3 pl-2 flex items-center" data-toggle="modal" data-target="#create-users">
            <i data-feather="pocket" class="w-4 h-4 mr-1"></i> Create Front Desk User Account
          </a>
      </div>
  </div>
</div>

<h2 class="intro-y text-lg font-medium mt-10">
  App Users
</h2>

<div class="grid grid-cols-12 gap-6 mt-5">
  <div class="intro-y col-span-12 flex flex-wrap sm:flex-no-wrap items-center mt-2">
      <div class="hidden md:block mx-auto text-gray-600">Showing 1 to 10 of {total_registered_front_desk_users} entries</div>
      <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
          <div class="w-56 relative text-gray-700 dark:text-gray-300">
              <input bind:value={searchTerm} type="text" class="input w-56 box pr-10 placeholder-theme-13" placeholder="Search...">
              <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i>
          </div>
      </div>
  </div>

  {#each filteredList as user (user.id)}
    <div class="intro-y col-span-12 md:col-span-6">
      <div class="box">
          <div class="flex flex-col items-start p-5 border-b border-gray-200 dark:border-dark-5">

            <div class="">
              <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1 ml-5">
                <img alt="{user.name}" class="rounded-full" src="{user.avatar_url || '/img/userimg.png'}">
              </div>

              <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                {#if ! user.is_verified}
                  <div class="w-48 h-5 flex items-center justify-center absolute top-0 right-0 text-xs text-white rounded-full bg-theme-6 font-medium -mt-2 mr-2">EMAIL NOT VERIFIED</div>
                {:else if true && ! user.has_uploaded_id}
                  <div class="w-48 h-5 flex items-center justify-center absolute top-0 right-0 text-xs text-white rounded-full bg-theme-6 font-medium -mt-2 mr-2">VALID ID NOT UPLOADED</div>
                {:else if true && ! user.has_accepted_terms}
                  <div class="w-48 h-5 flex items-center justify-center absolute top-0 right-0 text-xs text-white rounded-full bg-theme-6 font-medium -mt-2 mr-2">TERMS NOT ACCEPTED</div>
                {/if}
                <InertiaLink href="" class="font-medium">{user.name.toUpperCase()}</InertiaLink>
                <div class="text-gray-600 text-xs">{user.email}</div>
              </div>
            </div>

            <div class="flex flex-wrap">
                {#if ! user.is_suspended}
                <a  href="javascript:;" class="btn--xs mt-2 py-1 px-2 rounded-full flex items-center justify-center border dark:border-dark-5 ml-2 bg-red-600 text-white zoom-in" on:click="{() => {actionUrl = route('frontdeskusers.suspend', user); actionMethod = 'PUT'}}"> <i class="w-3 h-3 mr-1 fill-current" data-feather="user"></i> SUSPEND </a>
                {:else}

                <a  href="javascript:;" class="btn--xs mt-2 py-1 px-2 rounded-full flex items-center justify-center border dark:border-dark-5 ml-2 bg-red-600 text-white zoom-in" style="background-color: #aa4f0b;" on:click="{() => {actionUrl = route('frontdeskusers.unsuspend', user); actionMethod = 'PUT'}}"> <i class="w-3 h-3 mr-1 fill-current" data-feather="user"></i> UNSUSPEND </a>
                
                {/if}
                <a href="javascript:;" class="btn--xs mt-2 py-1 px-2 rounded-full flex items-center justify-center border dark:border-dark-5 ml-2 bg-crimson-600 text-white zoom-in" on:click="{() => {actionUrl = route('frontdeskusers.activate', user); actionMethod = 'PUT'}}"> <i class="w-3 h-3 mr-1 fill-current" data-feather="user"></i> ACTIVATE </a>
                <InertiaLink href="" class="btn--xs mt-2 py-1 px-2 rounded-full flex items-center justify-center border dark:border-dark-5 ml-2 bg-indigo-600 text-white zoom-in" > <i class="w-3 h-3 mr-1 fill-current" data-feather="user"></i> DETAILS </InertiaLink>
                <a href="javascript:;" class="btn--xs mt-2 py-1 px-2 rounded-full flex items-center justify-center border dark:border-dark-5 ml-2 bg-red-600 text-white zoom-in" style="background-color: #a00808;" on:click="{() => {actionUrl = route('frontdeskusers.activate', user); actionMethod = 'DELETE'}}"> <i class="w-3 h-3 mr-1 fill-current" data-feather="trash" style="margin: 0;"></i></a>
                <!-- <InertiaLink href="" class="btn--xs mt-2 py-1 px-2 rounded-full flex items-center justify-center border dark:border-dark-5 ml-2 bg-indigo-600 text-white zoom-in" > <i class="w-3 h-3 mr-1 fill-current" data-feather="user"></i> DETAILS </InertiaLink> -->
                {#if user.is_verified}
                  {#if true}
                      {#if ! user.can_withdraw}
                        <a href="javascript:;" data-toggle="modal" data-target="#confirm-action-modal" class="btn--xs mt-2 py-1 px-2 rounded-full flex items-center justify-center border dark:border-dark-5 ml-2 bg-theme-33 text-white zoom-in" on:click="{() => {actionUrl = route('appusers.withdrawal_status', user); actionMethod = 'PUT'}}"> <i class="w-3 h-3 mr-1 fill-current" data-feather="sunrise"></i> ALLOW WITHDRAWALS </a>
                        {:else}
                        <a href="javascript:;" data-toggle="modal" data-target="#confirm-action-modal" class="btn--xs mt-2 py-1 px-2 rounded-full flex items-center justify-center border dark:border-dark-5 ml-2 bg-theme-11 text-white zoom-in" on:click="{() => {actionUrl = route('appusers.withdrawal_status', user); actionMethod = 'PUT'}}"> <i class="w-3 h-3 mr-1 fill-current" data-feather="sunrise"></i> DENY WITHDRAWALS </a>
                      {/if}
                  {/if}
                  {#if true}
                      <a href="javascript:;" data-toggle="modal" on:click="{() => userDetails = user}" data-target="#set-btc-modal" class="btn--xs mt-2 py-1 px-2 rounded-full flex items-center justify-center border dark:border-dark-5 ml-2 bg-purple-300 text-purple-800 zoom-in"> <i class="w-3 h-3 mr-1 fill-current" data-feather="wind"></i> SET BTC </a>
                  {/if}

                {/if}

                {#if user.is_verified}
                  {#if true}
                    <a href="javascript:;" data-toggle="modal" on:click="{() => userDetails = user}" data-target="#update-bonus-modal" class="btn--xs mt-2 py-1 px-2 rounded-full flex items-center justify-center border dark:border-dark-5 ml-2 bg-gray-200 text-gray-600 zoom-in"> <i class="w-3 h-3 mr-1 fill-current" data-feather="bar-chart-2"></i> Update Bonus </a>
                  {/if}
                  {#if must_verify_users && ! user.is_activated}
                    <a href="javascript:;" data-toggle="modal" data-target="#confirm-action-modal" class="btn--xs mt-2 py-1 px-2 rounded-full ml-2 zoom-in flex items-center justify-center button button--sm text-white bg-theme-1" on:click="{() => {actionUrl = route('appusers.activate', user); actionMethod = 'PUT'}}"><i class="w-3 h-3 mr-1 fill-current" data-feather="zap"></i> Activate Account</a>
                  {/if}
                  {#if user.is_active}
                    {#key user.is_active}
                      <a href="javascript:;" data-toggle="modal" data-target="#confirm-action-modal" class="btn--xs mt-2 py-1 px-2 rounded-full ml-2 zoom-in flex items-center justify-center button button--sm text-white bg-theme-11" on:click="{() => {actionUrl = route('appusers.suspend', user); actionMethod = 'PUT'}}"><i class="w-3 h-3 mr-1 fill-current" data-feather="pause-circle"></i> Suspend</a>
                    {/key}
                  {:else}
                    {#key user.is_active}
                      <a href="javascript:;" data-toggle="modal" data-target="#confirm-action-modal" class="btn--xs mt-2 py-1 px-2 rounded-full ml-2 zoom-in flex items-center justify-center button button--sm text-white bg-indigo-900" on:click="{() => {actionUrl = route('appusers.unsuspend', user); actionMethod = 'PUT'}}"><i class="w-3 h-3 mr-1 fill-current" data-feather="play-circle"></i> Restore</a>
                    {/key}
                  {/if}
                {/if}
                {#if can_delete_users}
                   <a href="javascript:;" data-toggle="modal" data-target="#confirm-action-modal" class="btn--xs mt-2 py-1 px-2 rounded-full ml-2 zoom-in flex items-center justify-center button button--sm text-gray-700 bg-theme-6 dark:text-gray-300 border border-red-300 dark:border-dark-5" on:click="{() => {actionUrl = route('appusers.delete', user); actionMethod = 'DELETE'}}"><i class="w-3 h-3 mr-1 fill-current" data-feather="trash"></i> Delete</a>
                {/if}
              </div>
          </div>

          <div class="flex flex-wrap lg:flex-no-wrap items-center justify-center p-5">
              <div class="w-full mb-4 lg:mb-0 mr-auto">
                  <div class="flex flex-wrap">
                    {#if true}
                       <div class="text-gray-600 text-xs mr-auto">Assigned Wallet Address: {user.btc_wallet}</div>
                    {/if}
                    <div class="text-xs font-medium">User Balance: <strong>{(user.current_user_balance, user.currency)}</strong></div>
                  </div>
                  <div class="w-full h-1 mt-2 bg-gray-400 dark:bg-dark-1 rounded-full">
                    <div class="w-1/4 h-full bg-theme-1 dark:bg-theme-10 rounded-full"></div>
                  </div>
              </div>

          </div>

      </div>
    </div>
  {/each}
</div>

<ConfirmModal {actionUrl} {actionMethod} />

<Modal id="create-users" modalTitle="Create Front Desk User Account">

  <div class="p-5">
      <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
      <div class="text-2xl mt-5">Upload POP for this investment</div>
      <form on:submit|preventDefault|stopPropagation="{createUser}" class="border-gray-200 border-dashed">
        <!-- BEGIN: Form Layout -->
        <div class="intro-y box p-5">
          <div class="mt-3">
            <label for="name">Full Name</label>
            <div class="mt-2"><input type="text" name="name" class="input w-full border mt-2" placeholder="e.g Mike Rex" bind:value="{details.name}"></div>
          </div>
          <div class="mt-3">
            <label for="name">Password</label>
            <div class="mt-2"><input type="text" name="number" class="input w-full border mt-2" placeholder="e.g +2348183452673" bind:value="{details.password}"></div>
          </div>
          <div class="mt-3">
            <label for="name">Email</label>
            <div class="mt-2"><input type="text" name="email" class="input w-full border mt-2" placeholder="e.g abx@gmail.com" bind:value="{details.email}"></div>
          </div>
          <div class="mt-3">
            <label for="name">Profile Image</label>
            <div class="mt-2">
              <FileInput maxHeight={2000} maxWidth={2000} className="my-3 rounded" height=70 label="Avatar Image" name="avatar" accept="image/*" errors={errors.avatar} onChange={file => details.avatar = file}/>
            </div>
          </div>
          <div class="text-right mt-5">
            <button type="submit" class="button w-24 bg-theme-1 text-white">Save</button>
          </div>
        </div>
        <!-- END: Form Layout -->

        <div class="px-5 pb-8 text-center mt-5">
        <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">Cancel</button>
        <button type="submit" data-dismiss="modal" class="button w-40 bg-theme-1 text-white">Upload POP</button>
        </div>
      </form>


  </div>
</Modal>
