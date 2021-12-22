<script context="module">
  import FrontDeskUserPagesLayout from "@frontdeskuser-pages/Layouts/FrontDeskUserPagesLayout.svelte";
  export const layout = FrontDeskUserPagesLayout
</script>

<script>
  import InertiaLink from '@inertiajs/inertia-svelte/src/InertiaLink.svelte';
  import ConfirmModal from '@miscellaneous-components/ConfirmModal.svelte';
  import { Inertia } from '@inertiajs/inertia';
import { toCurrency } from '@PublicShared/helpers';

  export let app_users = [],
    must_verify_users = false,
    can_delete_users = false;

  let actionUrl, actionMethod, details={}, userDetails;
</script>

<div class="grid grid-cols-12 gap-6">
  <div class="col-span-12 mt-8">
      <div class="intro-y flex items-center h-10">
          <h2 class="text-lg font-medium truncate mr-5">
              Account Summary
          </h2>
      </div>
      <div class="grid grid-cols-12 gap-6 mt-5">

          <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
              <div class="report-box zoom-in">
                  <div class="box p-5">
                      <div class="text-3xl font-bold leading-8 mt-4">{2}</div>
                      <div class="text-base text-gray-600 mt-4">Total Registered Clients</div>
                  </div>
              </div>
          </div>

          <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
              <div class="report-box zoom-in">
                  <div class="box p-5">
                      <div class="text-3xl font-bold leading-8 mt-4">{2}</div>
                      <div class="text-base text-gray-600 mt-4">Total Unverified Clients</div>
                  </div>
              </div>
          </div>

          <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
              <div class="report-box zoom-in">
                  <div class="box p-5">
                      <div class="text-3xl font-bold leading-8 mt-4">{2}</div>
                      <div class="text-base text-gray-600 mt-4">Last Withdrawal Request</div>
                  </div>
              </div>
          </div>

      </div>
  </div>
</div>

<h2 class="intro-y text-lg font-medium mt-10">
  App Users
</h2>

<div class="grid grid-cols-12 gap-6 mt-5">
  <div class="intro-y col-span-12 flex flex-wrap sm:flex-no-wrap items-center mt-2">
      <div class="hidden md:block mx-auto text-gray-600">Showing 1 to 10 of 150 entries</div>
      <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
          <div class="w-56 relative text-gray-700 dark:text-gray-300">
              <input type="text" class="input w-56 box pr-10 placeholder-theme-13" placeholder="Search...">
              <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i>
          </div>
      </div>
  </div>

  {#each app_users as user (user.id)}
    <div class="intro-y col-span-12 md:col-span-6">
      <div class="box">
          <div class="flex flex-col items-start p-5 border-b border-gray-200 dark:border-dark-5">

            <div class="">
              <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1 ml-5">
                <img alt="{user.first_name}" class="rounded-full" src="{user.avatar_url || '/img/userimg.png'}">
              </div>

              <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                {#if ! user.is_verified}
                  <div class="w-48 h-5 flex items-center justify-center absolute top-0 right-0 text-xs text-white rounded-full bg-theme-6 font-medium -mt-2 mr-2">EMAIL NOT VERIFIED</div>
                {:else if true && ! user.has_uploaded_id}
                  <div class="w-48 h-5 flex items-center justify-center absolute top-0 right-0 text-xs text-white rounded-full bg-theme-6 font-medium -mt-2 mr-2">VALID ID NOT UPLOADED</div>
                {:else if true && ! user.has_accepted_terms}
                  <div class="w-48 h-5 flex items-center justify-center absolute top-0 right-0 text-xs text-white rounded-full bg-theme-6 font-medium -mt-2 mr-2">TERMS NOT ACCEPTED</div>
                {/if}
                <a href="" class="font-medium">{user.full_name}</a>
                <div class="text-gray-600 text-xs">{user.phone}</div>
              </div>
            </div>

              <div class="flex flex-wrap">
                <a href="javascript:;" data-toggle="modal" data-target="#user-details-modal" on:click="{() => userDetails = user}" class="btn--xs mt-2 py-1 px-2 rounded-full flex items-center justify-center border dark:border-dark-5 ml-2 bg-indigo-600 text-white zoom-in" > <i class="w-3 h-3 mr-1 fill-current" data-feather="user"></i> DETAILS </a>
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

                  <InertiaLink href="{route('usertransactions.list', user)}" class="btn--xs mt-2 py-1 px-2 rounded-full flex items-center justify-center border dark:border-dark-5 ml-2 bg-theme-8 text-gray-700 zoom-in"> <i class="w-3 h-3 mr-1 fill-current" data-feather="activity"></i> Transactions </InertiaLink>
                  <InertiaLink href="{route('withdrawalrequests.list', user)}" class="btn--xs mt-2 py-1 px-2 rounded-full flex items-center justify-center border dark:border-dark-5 ml-2 bg-theme-10 text-white zoom-in"> <i class="w-3 h-3 mr-1 fill-current" data-feather="sunset"></i> Withdrawal Requests</InertiaLink>
                  <InertiaLink href="{route('usertransactions.deposit_requests', user)}" class="btn--xs mt-2 py-1 px-2 rounded-full flex items-center justify-center border dark:border-dark-5 ml-2 bg-pink-500 text-white zoom-in"> <i class="w-3 h-3 mr-1 fill-current" data-feather="database"></i> Deposit Requests</InertiaLink>
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
