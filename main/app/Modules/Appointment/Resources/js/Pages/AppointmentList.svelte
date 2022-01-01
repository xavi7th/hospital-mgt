<script context="module">
  import FrontDeskUserPagesLayout from "@frontdeskuser-pages/Layouts/FrontDeskUserPagesLayout.svelte";
  export const layout = FrontDeskUserPagesLayout
</script>

<script>
  import ConfirmModal from '@miscellaneous-components/ConfirmModal.svelte';
  import TextInput from '@miscellaneous-components/TextInput.svelte';
  import { InertiaLink } from '@inertiajs/inertia-svelte';
  import { Inertia } from '@inertiajs/inertia';


  export let total_appointment_count, pending_appointments = { data:[] };

  $: filteredUsers = pending_appointments.data.filter(x => x.patient.name.toLowerCase().includes(searchQuery.toLowerCase()));

  let searchDate, actionUrl, actionMethod, searchQuery = '';

  let filterAppointmentsByDate = () => {
    BlockToast.fire({text:'Searching by date. Please wait ...'})

    Inertia.get(route('appointments.index', searchDate), undefined, {
      only: ['pending_appointments'],
      onSuccess: () => searchDate = ''
    });
  }

</script>

<div class="grid grid-cols-12 gap-6">
  <div class="col-span-12 grid grid-cols-12 gap-6">
    <div class="col-span-12 mt-8">
      <div class="intro-y flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-auto">
          Pending Appointments
        </h2>
        <div class="w-auto rounded-md mr-auto">
          <button type="button" on:click="{filterAppointmentsByDate}"  class="button text-white bg-theme-1 shadow-md mr-2">View All Appointments</button>
        </div>
        <TextInput flat={true} className="input w-auto border mt-2" required placeHolder="Select Date" name="appointment_date" type="date" value={searchDate} bind:val={searchDate} onChange={filterAppointmentsByDate}/>
      </div>

      <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
          <div class="report-box zoom-in">
            <div class="box p-5">
                <div class="flex">
                  <i data-feather="activity" class="report-box__icon text-theme-11"></i>
                </div>
                <div class="text-3xl font-bold leading-8 mt-10">{ total_appointment_count }</div>
                <div class="text-base text-gray-600 mt-4">Total Pending Appointments</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-span-12 lg:col-span-12 mt-2">
      <div class="intro-y flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-auto">
          Patients With Booked Appointments
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
              <th class="border border-b-2 dark:border-dark-5 whitespace-no-wrap">Appointment Date</th>
              <th class="border border-b-2 dark:border-dark-5 whitespace-no-wrap">Booked By</th>
              <th class="border border-b-2 dark:border-dark-5 whitespace-no-wrap">Actions</th>
            </tr>
          </thead>
          <tbody>
            {#each filteredUsers as apt, idx (apt.id)}
               <tr class="hover:bg-dark-5 bg-gray-200 dark:bg-dark-1">
                 <td class="border-b dark:border-dark-5">{idx + 1}</td>
                 <td class="border-b dark:border-dark-5">{apt.patient.name}</td>
                 <td class="border-b dark:border-dark-5">{apt.doctor.name}</td>
                 <td class="border-b dark:border-dark-5">{ new Date(apt.appointment_date).toDateString() }</td>
                 <td class="border-b dark:border-dark-5">{apt.booked_by.name}</td>
                 <td class="border-b dark:border-dark-5 whitespace-no-wrap">
                    <InertiaLink href="{ route('patients.show', apt.patient.id) }" class="rounded w-24 zoom-in button button--md mx-auto text-white bg-theme-1">Patient's Details</InertiaLink>
                    {#if ! apt.posted_at}
                      <a href="javascript:;" data-toggle="modal" data-target="#confirm-action-modal" class="rounded w-40 zoom-in button button--md mx-auto text-white bg-theme-11" on:click="{() => {actionUrl = route('appointments.post_for_vitals', apt); actionMethod = 'PUT'}}">
                        Send for Vitals
                      </a>
                    {:else}
                      <span class="button bg-black w-40 rounded button--md mx-auto">ALREADY SENT FOR VITALS</span>
                    {/if}
                 </td>
               </tr>
            {/each}
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<ConfirmModal {actionUrl} {actionMethod} />
