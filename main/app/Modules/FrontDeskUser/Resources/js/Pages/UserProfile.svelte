<script context="module">
  import FrontDeskUserPagesLayout from "@frontdeskuser-pages/Layouts/FrontDeskUserPagesLayout.svelte";
  export const layout = FrontDeskUserPagesLayout
</script>

<script>
  import FileInput from '@miscellaneous-components/FileInput.svelte';
  import { page } from '@inertiajs/inertia-svelte';
import { Inertia } from '@inertiajs/inertia';

$: ({ authuser, errors } = $page.props);

let details = {}

export let can_update_profile = false;

let updateProfileImage = () => {
  BlockToast.fire({text: 'Uploading profile image ...'})

  console.log(details);

  Inertia.post(route('frontdeskusers.profile'), details);
}
</script>

<div class="intro-y flex items-center mt-8">
  <h2 class="text-lg font-medium mr-auto">
      My Profile
  </h2>
</div>

<div class="intro-y box px-5 pt-5 mt-5">
  <div class="flex flex-col lg:flex-row border-b border-gray-200 dark:border-dark-5 pb-5 -mx-5">
      <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
          <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
              <img alt="{authuser.name}" class="rounded-full" src="{authuser.avatar_url}">
          </div>
          <div class="ml-5">
              <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{authuser.name}</div>
              <div class="text-gray-600">{authuser.ref_id}</div>
          </div>
      </div>
      <div class="flex mt-6 lg:mt-0 items-center lg:items-start flex-1 flex-col justify-center text-gray-600 dark:text-gray-300 px-5 border-l border-r border-gray-200 dark:border-dark-5 border-t lg:border-t-0 pt-5 lg:pt-0">
          <div class="truncate sm:whitespace-normal flex items-center"> Account ID: { authuser.account_id }</div>
          <div class="truncate sm:whitespace-normal flex items-center mt-3"> Email: { authuser.email } </div>
          <div class="truncate sm:whitespace-normal flex items-center mt-3"> Phone: { authuser.phone } </div>
          <div class="truncate sm:whitespace-normal flex items-center mt-3"> Country: { authuser.country } </div>
      </div>
      <!-- <div class="mt-6 lg:mt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-0 border-gray-200 dark:border-dark-5 pt-5 lg:pt-0">
          <div class="text-center rounded-md w-20 py-3">
              <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">201</div>
              <div class="text-gray-600">Orders</div>
          </div>
          <div class="text-center rounded-md w-20 py-3">
              <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">1k</div>
              <div class="text-gray-600">Purchases</div>
          </div>
          <div class="text-center rounded-md w-20 py-3">
              <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">492</div>
              <div class="text-gray-600">Reviews</div>
          </div>
      </div> -->
  </div>
  <div class="nav-tabs flex flex-col sm:flex-row justify-center lg:justify-start">
      <!-- <a data-toggle="tab" data-target="#profile" href="javascript:;" class="py-4 sm:mr-8 flex items-center active"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user w-4 h-4 mr-2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> Profile </a>
      <a data-toggle="tab" data-target="#account" href="javascript:;" class="py-4 sm:mr-8 flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield w-4 h-4 mr-2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg> Account </a>
      <a data-toggle="tab" data-target="#change-password" href="javascript:;" class="py-4 sm:mr-8 flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock w-4 h-4 mr-2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg> Change Password </a>
      <a data-toggle="tab" data-target="#settings" href="javascript:;" class="py-4 sm:mr-8 flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings w-4 h-4 mr-2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg> Settings </a> -->
      {#if can_update_profile}
        <div class="p-2 border-t flex w-2/3">
          <div class="w-2/3">
            <FileInput className="rounded no-icon" height=30 minWidth=300 allowedFileTypes="png jpg jpeg gif webp webm" label="Click here to Upload your Profile Image" name="id-card" accept="image/*" errors={errors.avatar} onChange={file => details.avatar = file}/>
          </div>
          <button type="button" class="button button--sm border text-gray-700 dark:border-dark-5 dark:text-gray-300 ml-auto w-48 ml-2" on:click="{updateProfileImage}">Update Profile Image</button>
        </div>
      {/if}
  </div>
</div>
