<script context="module">
  import FrontDeskUserPagesLayout from "@frontdeskuser-pages/Layouts/FrontDeskUserPagesLayout.svelte";
  export const layout = FrontDeskUserPagesLayout
</script>

<script>
  import InertiaLink from '@inertiajs/inertia-svelte/src/InertiaLink.svelte';
  import ConfirmModal from '@miscellaneous-components/ConfirmModal.svelte';
  import FileInput from '@miscellaneous-components/FileInput.svelte';
  import TextInput from '@miscellaneous-components/TextInput.svelte';
  import Modal from '@miscellaneous-components/Modal.svelte';
  import { page } from '@inertiajs/inertia-svelte';
  import { Inertia } from '@inertiajs/inertia';
  import { onMount } from 'svelte';

  $: ({ errors } = $page.props);

  let actionUrl, actionMethod, details={}, searchTerm = "";

	$: filteredList = front_desk_users.filter(item => item.name.toLowerCase().indexOf(searchTerm.toLowerCase()) !== -1 || item.email.indexOf(searchTerm.toLowerCase()) !== -1);

  export let front_desk_users = [],
    total_registered_front_desk_users = front_desk_users.length,
    total_unverified_front_desk_users = 0;


  let createUser = () => {
    BlockToast.fire({text:'Creating fron desk user account. Please wait ...'})

    Inertia.post(route('frontdeskusers.create'), details);
  }

  onMount(() => {
    front_desk_users.forEach(user => {
      if(!user.is_active){
        total_unverified_front_desk_users++
      }
    });
  })

</script>

<div class="grid grid-cols-12 gap-6">
  <div class="col-span-12 mt-8 flex intro-y">
    <h2 class="text-lg font-medium mr-auto">
      Front Desk Users
    </h2>
    <div>
        <a href="javascript:;" class="button bg-theme-10 pl-2 flex items-center" data-toggle="modal" data-target="#create-users">
          <i data-feather="pocket" class="w-4 h-4 mr-1"></i> Create Front Desk User Account
        </a>
    </div>
  </div>
</div>

<div class="grid grid-cols-12 gap-6 mt-5">

  <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
      <div class="report-box zoom-in">
          <div class="box p-5">
              <div class="text-3xl font-bold leading-8 mt-4">{total_registered_front_desk_users}</div>
              <div class="text-base text-gray-600 mt-4">Total Registered Front Desk Users</div>
          </div>
      </div>
  </div>

  <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
      <div class="report-box zoom-in">
          <div class="box p-5">
              <div class="text-3xl font-bold leading-8 mt-4">{total_unverified_front_desk_users}</div>
              <div class="text-base text-gray-600 mt-4">Total Unverified Front Desk Users</div>
          </div>
      </div>
  </div>

</div>

<div class="grid grid-cols-12 gap-6 mt-10 border-t border-gray-200 dark:border-dark-5 pt-10">
  <div class="intro-y col-span-12 flex flex-wrap sm:flex-no-wrap items-center mt-2">
      <!-- <div class="hidden md:block mx-auto text-gray-600">Showing 1 to 10 of {total_registered_front_desk_users} entries</div> -->
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
          <div class="flex flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">

            <div class="mr-auto flex items-center">
              <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1 ml-5">
                <img alt="{user.name}" class="rounded-full" src="{user.avatar_url || '/img/userimg.png'}">
              </div>

              <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                <InertiaLink href="" class="font-medium">{user.name.toUpperCase()}</InertiaLink>
                <div class="text-gray-600 text-xs">{user.email}</div>
              </div>
            </div>

            <div class="flex flex-wrap">
                {#if ! user.is_suspended}
                  <a  href="javascript:;" class="button button--sm rounded flex items-center justify-center border dark:border-dark-5 ml-2 bg-red-600 text-white zoom-in" data-toggle="modal" data-target="#confirm-action-modal" on:click="{() => {actionUrl = route('frontdeskusers.suspend', user); actionMethod = 'PUT'}}"> SUSPEND </a>
                {:else}
                  <a  href="javascript:;" class="button button--sm rounded flex items-center justify-center border dark:border-dark-5 ml-2 bg-blue-400 text-white zoom-in" data-toggle="modal" data-target="#confirm-action-modal" on:click="{() => {actionUrl = route('frontdeskusers.unsuspend', user); actionMethod = 'PUT'}}"> UNSUSPEND </a>
                {/if}
                {#if ! user.is_activated}
                  <a href="javascript:;" class="button button--sm rounded flex items-center justify-center border dark:border-dark-5 ml-2 bg-green-600 text-white zoom-in" data-toggle="modal" data-target="#confirm-action-modal" on:click="{() => {actionUrl = route('frontdeskusers.activate', user); actionMethod = 'PUT'}}"> ACTIVATE </a>
                {/if}

                <!-- <a href="javascript:;" class="button button--sm rounded flex items-center justify-center border dark:border-dark-5 ml-2 bg-red-600 text-white zoom-in" style="background-color: #a00808;" on:click="{() => {actionUrl = route('frontdeskusers.activate', user); actionMethod = 'DELETE'}}"> <i class="w-3 h-3 mr-1 fill-current" data-feather="trash" style="margin: 0;"></i>DELETE</a> -->

                <InertiaLink href="" class="button button--sm rounded flex items-center justify-center border dark:border-dark-5 ml-2 bg-indigo-600 text-white zoom-in" > <i class="w-3 h-3 mr-1 fill-current" data-feather="user"></i> DETAILS </InertiaLink>

              </div>
          </div>
      </div>
    </div>
  {/each}
</div>

<ConfirmModal {actionUrl} {actionMethod} />

<Modal id="create-users" modalTitle="Create Front Desk User Account">
  <div class="p-5">
    <form on:submit|preventDefault|stopPropagation="{createUser}" class="border-gray-200 border-dashed">
      <!-- BEGIN: Form Layout -->
      <div class="intro-y box">
        <div class="mt-3">
          <TextInput flat={true} className="input w-full border mt-2" required placeHolder="Full Name" name="name" type="text" errors={errors.name} value={details.name} bind:val={details.name}/>
        </div>
        <div class="mt-3">
          <TextInput flat={true} className="input w-full border mt-2" required placeHolder="Password" name="password" type="password" errors={errors.password} value={details.password} bind:val={details.password}/>
        </div>
        <div class="mt-3">
          <TextInput flat={true} className="input w-full border mt-2" required placeHolder="Confirm Password" name="password_confirmation" type="password" errors={errors.password_confirmation} value={details.password_confirmation} bind:val={details.password_confirmation}/>
        </div>
        <div class="mt-3">
          <TextInput flat={true} className="input w-full border mt-2" required placeHolder="Email" name="email" type="email" errors={errors.email} value={details.email} bind:val={details.email}/>
        </div>
        <div class="mt-3">
          <FileInput maxHeight={2000} maxWidth={2000} className="my-3 rounded" height=100 label="User's Image" name="avatar" accept="image/*" errors={errors.avatar} onChange={file => details.avatar = file}/>
        </div>
        <div class="text-right mt-5">
          <button type="submit" class="button bg-theme-1 text-white" disabled={details.password != details.password_confirmation}>Create Front Desk User Account</button>
        </div>
      </div>
      <!-- END: Form Layout -->
    </form>
  </div>
</Modal>
