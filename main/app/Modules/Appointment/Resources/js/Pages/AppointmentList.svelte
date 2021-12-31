<script context="module">
  import FrontDeskUserPagesLayout from "@frontdeskuser-pages/Layouts/FrontDeskUserPagesLayout.svelte";
  export const layout = FrontDeskUserPagesLayout
</script>

<script>
  import ConfirmModal from '@miscellaneous-components/ConfirmModal.svelte';
  import Modal from '@miscellaneous-components/Modal.svelte';
  import { page, InertiaLink } from '@inertiajs/inertia-svelte';
  import { Inertia } from '@inertiajs/inertia';

  $: ({ authuser } = $page.props);

  export let total_num_of_reg_patients, due_appointments = [];

  $: filteredUsers = due_appointments.filter(x => x.patient.name.toLowerCase().includes(searchQuery.toLowerCase()));

  let files, details={}, actionUrl, actionMethod, searchQuery = '';

  let createPatientRecord = () => {
    BlockToast.fire({text:'Creating record. Please wait ...'})

    Inertia.post(route('auth.login'), details);
  }

</script>

<div class="grid grid-cols-12 gap-6">
  <div class="col-span-12 grid grid-cols-12 gap-6">
    <div class="col-span-12 mt-8">
        <div class="intro-y flex items-center h-10">
          <h2 class="text-lg font-medium truncate mr-auto">
              Pending Appointments
          </h2>
          <div class="w-auto rounded-md">
            <a href="javascript:;" data-toggle="modal" data-target="#create-patient-record"  class="button text-white bg-theme-1 shadow-md mr-2">Create Patient Record</a>
          </div>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                <div class="report-box zoom-in">
                    <div class="box p-5">
                        <div class="flex">
                            <i data-feather="activity" class="report-box__icon text-theme-11"></i>
                        </div>
                        <div class="text-3xl font-bold leading-8 mt-10">{ total_num_of_reg_patients }</div>
                        <div class="text-base text-gray-600 mt-4">Total Registered Patients</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-12 mt-2">
      <div class="intro-y flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-auto">
          Patients With Due Appointments Today
        </h2>
        <div class="intro-x relative mr-3 sm:mr-6">
          <div class="search hidden sm:block">
              <input type="text" class="search__input input placeholder-theme-13" placeholder="Search..." bind:value="{searchQuery}">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search search__icon dark:text-gray-300"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
          </div>
        </div>
      </div>
    </div>

    <div class="col-span-12 lg:col-span-12 mt-2">
      <div class="overflow-x-auto">
        <table class="table">
          <thead>
            <tr>
              <th class="border border-b-2 dark:border-dark-5 whitespace-no-wrap">#</th>
              <th class="border border-b-2 dark:border-dark-5 whitespace-no-wrap">Patient Name</th>
              <th class="border border-b-2 dark:border-dark-5 whitespace-no-wrap">Doctor Name</th>
              <th class="border border-b-2 dark:border-dark-5 whitespace-no-wrap">Actions</th>
            </tr>
          </thead>
          <tbody>
            {#each filteredUsers as apt, idx (apt.patient.name)}
               <tr class="hover:bg-dark-5 bg-gray-200 dark:bg-dark-1">
                 <td class="border-b dark:border-dark-5">{idx + 1}</td>
                 <td class="border-b dark:border-dark-5">{apt.patient.name}</td>
                 <td class="border-b dark:border-dark-5">{apt.doctor.name}</td>
                 <td class="border-b dark:border-dark-5 whitespace-no-wrap">
                  <a href="javascript:;" data-toggle="modal" data-target="#confirm-action-modal" class="rounded w-40 zoom-in flex items-center justify-center button button--sm mx-auto text-white bg-theme-11" on:click="{() => {actionUrl = route('appointments.post_for_vitals', apt); actionMethod = 'PUT'}}">
                    <i class="w-3 h-3 mr-1 fill-current" data-feather="zap"></i> Send for Vitals
                  </a>
                  <InertiaLink href="{ route('patients.show', apt.patient.id) }" class="rounded w-24 zoom-in flex items-center justify-center button button--sm mx-auto text-white bg-theme-1">Details</InertiaLink>
                 </td>
               </tr>
            {/each}
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<Modal id="create-patient-record" modalTitle="Create New Patient Record">
  <div class="p-5 text-center">
    <form on:submit|preventDefault|stopPropagation="{createPatientRecord}" class="border-gray-200 border-dashed">
      <div class="fallback"> <input name="file" type="file" bind:files on:change="{() => details.pop = files[0]}" class="input w-full mt-2"/> </div>

      <div class="px-5 pb-8 text-center mt-5">
      <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">Cancel</button>
      <button type="submit" data-dismiss="modal" class="button w-40 bg-theme-1 text-white">Upload POP</button>
      </div>
    </form>
  </div>
</Modal>

<ConfirmModal {actionUrl} {actionMethod} />
