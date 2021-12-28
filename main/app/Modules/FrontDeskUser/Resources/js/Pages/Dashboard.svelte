<script context="module">
  import FrontDeskUserPagesLayout from "@frontdeskuser-pages/Layouts/FrontDeskUserPagesLayout.svelte";
  export const layout = FrontDeskUserPagesLayout
</script>

<script>
  import Modal from '@miscellaneous-components/Modal.svelte';
  import { to_currency } from '@miscellaneous-shared/utils';
  import { page } from '@inertiajs/inertia-svelte';
  import { Inertia } from '@inertiajs/inertia';

  $: ({ authuser } = $page.props);

  export let current_plan = {}, forex_charts = [], has_user_bonus = false, can_suspend_investments = false, can_upload_pop = false;

  let files, transaction, details={};

  let uploadPOP= ()=>{
    details._method = "PUT";

    BlockToast.fire({
        text: "Uploading POP ..."
    });

    Inertia.post(route('usertransactions.investments.upload_pop', transaction), details, {
      onSuccess: () => {
        details = {};
        // jQuery('#upload-pop-modal').modal('hide');
      }
    })
  }

</script>

<div class="grid grid-cols-12 gap-6">
  <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">

      <div class="col-span-12 mt-8">
          <div class="intro-y flex items-center h-10">
            <h2 class="text-lg font-medium truncate mr-auto">
                My Trading Dashboard
            </h2>
            <div class="w-auto rounded-md">
              <a href="{ route('usertransactions.investments.list') }" class="button text-white bg-theme-1 shadow-md mr-2">Invest Now</a>
            </div>
          </div>
          {#if ! current_plan?.investment_plan}
             <div class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-6 text-white"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon w-6 h-6 mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg> You have not selected a trading plan yet. </div>
          {/if}

          <div class="grid grid-cols-12 gap-6 mt-5">
              <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                  <div class="report-box zoom-in">
                      <div class="box p-5">
                          <div class="flex">
                              <i data-feather="activity" class="report-box__icon text-theme-11"></i>
                          </div>
                          <div class="text-3xl font-bold leading-8 mt-10" class:text-theme-6={authuser.current_user_balance < 0}>{ to_currency(authuser.current_user_balance, authuser.currency) }</div>
                          <div class="text-base text-gray-600 mt-4">Account Balance</div>
                      </div>
                  </div>
              </div>
              {#if has_user_bonus}
                 <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                     <div class="report-box zoom-in">
                         <div class="box p-5">
                             <div class="flex">
                                 <i data-feather="credit-card" class="report-box__icon text-theme-9"></i>
                             </div>
                             <div class="text-3xl font-bold leading-8 mt-10">{ to_currency(authuser.user_bonus, authuser.currency) }</div>
                             <div class="text-base text-gray-600 mt-4">Bonus Earned</div>
                         </div>
                     </div>
                 </div>
              {/if}
              {#if current_plan?.investment_plan}
                <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                  <div class="report-box zoom-in">
                      <div class="box p-5">
                          <div class="flex">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase report-box__icon text-theme-9"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>

                              {#if current_plan.is_pending}
                                <div class="ml-auto">
                                    {#if ! current_plan.pop_url && can_upload_pop}
                                      <a on:click="{() => {transaction = current_plan; details.amount = current_plan.amount;}}" class="report-box__indicator bg-theme-11 mt-2 mb-3 pl-2 flex items-center text-theme-11" href="javascript:;" data-toggle="modal" data-target="#upload-pop-modal">
                                        <i data-feather="pocket" class="w-4 h-4 mr-1"></i> Upload POP
                                      </a>
                                    {:else}
                                      <div class="report-box__indicator bg-theme-6 tooltip cursor-pointer" title="Contact your account manager">Plan Not Activated</div>
                                    {/if}
                                </div>
                              {:else}
                                <div class="ml-auto">
                                  <div class="flex items-center justify-center" class:text-theme-9={current_plan.is_active || ! can_suspend_investments} class:text-theme-11={! current_plan.is_active && can_suspend_investments}>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square w-4 h-4 mr-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                                      {#if ! current_plan.is_active && can_suspend_investments}
                                        SUSPENDED
                                      {:else}
                                        Active
                                      {/if}
                                  </div>
                                </div>
                              {/if}
                          </div>
                          <div class="text-3xl font-bold leading-8 mt-10">{ current_plan.investment_plan }</div>
                          <div class="text-base text-gray-600 mt-4">Current Plan</div>
                      </div>
                  </div>
                </div>
              {/if}
          </div>
      </div>

      <div class="col-span-12 lg:col-span-12 mt-2">
          <div class="intro-y flex items-center h-10">
              <h2 class="text-lg font-medium truncate mr-5">
                  Advanced Real-Time Chart
              </h2>
          </div>
          <ForexChart chart_data={forex_charts.advanced_real_time_charts} />
      </div>
      <!-- END: General Report -->
      <div class="col-span-12 lg:col-span-12 mt-2">
          <div style="width: 100%;">
            <ForexChart chart_data={forex_charts.nasdac_aapl} />
          </div>
      </div>
  </div>
  <div class="col-span-12 xxl:col-span-3 xxl:border-l border-theme-5 mb-10 pb-10">
      <div class="xxl:pl-6 grid grid-cols-12 gap-6">
          <!-- BEGIN: Transactions -->
          <div class="col-span-12 md:col-span-6 xl:col-span-4 xxl:col-span-12 mt-3 xxl:mt-8">
              <div class="intro-x flex items-center h-10">
                  <h2 class="text-lg font-medium truncate mr-5">
                      EURUSD Rates
                  </h2>
              </div>
              <div class="mt-5">
                <ForexChart chart_data={forex_charts.eurusd_rates} />
              </div>
          </div>
          <!-- END: Transactions -->
          <!-- BEGIN: Transactions -->
          <div class="col-span-12 md:col-span-6 xl:col-span-4 xxl:col-span-12 xxl:mt-3">
              <div class="intro-x flex items-center h-10">
                  <h2 class="text-lg font-medium truncate mr-5">
                      Market Activity
                  </h2>
              </div>
              <div class="mt-5">
                <ForexChart chart_data={forex_charts.market_activity} />
              </div>
          </div>
          <!-- END: Transactions -->
      </div>
  </div>
</div>



{#if can_upload_pop && transaction}
  <Modal id="upload-pop-modal" modalTitle="Upload Proof of Payments">

    <div class="p-5 text-center">
        <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
        <div class="text-2xl mt-5">Upload POP for this investment</div>
        <form on:submit|preventDefault|stopPropagation="{uploadPOP}" class="border-gray-200 border-dashed">
          <div class="fallback"> <input name="file" type="file" bind:files on:change="{() => details.pop = files[0]}" class="input w-full mt-2"/> </div>

          <div class="px-5 pb-8 text-center mt-5">
          <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">Cancel</button>
          <button type="submit" data-dismiss="modal" class="button w-40 bg-theme-1 text-white">Upload POP</button>
          </div>
        </form>
    </div>
  </Modal>
{/if}
