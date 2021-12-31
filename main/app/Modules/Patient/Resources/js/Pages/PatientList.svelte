<script context="module">
  import FrontDeskUserPagesLayout from "@frontdeskuser-pages/Layouts/FrontDeskUserPagesLayout.svelte";
  export const layout = FrontDeskUserPagesLayout
</script>

<script>
  import FileInput from '@miscellaneous-components/FileInput.svelte';
  import TextInput from '@miscellaneous-components/TextInput.svelte';
  import Modal from '@miscellaneous-components/Modal.svelte';
  import { page, InertiaLink } from '@inertiajs/inertia-svelte';
  import { Inertia } from '@inertiajs/inertia';
  import { onMount } from 'svelte';

  $: ({ authuser, errors } = $page.props);

  export let patients;

  let details={}, searchQuery = '';

  $: filteredUsers = patients.filter(x => x.name.toLowerCase().includes(searchQuery.toLowerCase()));

  let createPatientRecord = () => {
    BlockToast.fire({text:'Creating record. Please wait ...'})

    Inertia.post(route('patients.create'), details,{
      onSuccess: () => {
        filteredUsers = patients
      }
    });
  }

  onMount(() => filteredUsers = patients);
</script>


<div class="grid grid-cols-12 gap-6">
  <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
    <div class="col-span-12 mt-8">
      <div class="intro-y flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-auto">
            List of Patients
        </h2>
        <div class="w-auto rounded-md mr-auto">
          <a href="javascript:;" data-toggle="modal" data-target="#create-patient-record"  class="button text-white bg-theme-1 shadow-md mr-2">Create Patient Record</a>
        </div>

        <div class="intro-x relative mr-3 sm:mr-6">
          <div class="search">
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
              <th class="border border-b-2 dark:border-dark-5 whitespace-no-wrap">Full Name</th>
              <th class="border border-b-2 dark:border-dark-5 whitespace-no-wrap">Email/Phone</th>
              <th class="border border-b-2 dark:border-dark-5 whitespace-no-wrap">DOB</th>
              <th class="border border-b-2 dark:border-dark-5 whitespace-no-wrap">Image</th>
              <th class="border border-b-2 dark:border-dark-5 whitespace-no-wrap">Next of Kin / Phone</th>
              <th class="border border-b-2 dark:border-dark-5 whitespace-no-wrap">Actions</th>
            </tr>
          </thead>
          <tbody>
            {#each filteredUsers as patient, idx}
              <tr class="{idx%2 == 0 ? 'hover:bg-dark-5 bg-gray-200 dark:bg-dark-1' : ''}">
                <td class="border-b dark:border-dark-5">{patient.name}</td>
                <td class="border-b dark:border-dark-5">{patient.email} <br> {patient.phone}</td>
                <td class="border-b dark:border-dark-5">{new Date(patient.date_of_birth).toDateString()}</td>
                <td class="border-b dark:border-dark-5">
                  <a href="{patient.avatar_url}" target="_blank"><img style="height:100px;" src="{patient.avatar_url}" alt="Patient pic"></a>
                </td>
                <td class="border-b dark:border-dark-5">{patient.next_of_kin} <br> {patient.next_of_kin_phone}</td>
                <td class="border-b dark:border-dark-5">
                  <InertiaLink href="{ route('patients.show', patient) }" class="button btn--xs bg-theme-1 text-white">Details</InertiaLink>
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
  <div class="p-5 pt-10">
    <form on:submit|preventDefault|stopPropagation="{createPatientRecord}" class="border-gray-200 border-dashed">
      <div class="grid grid-cols-12 gap-4 row-gap-3">
        <div class="col-span-12 sm:col-span-6">
          <TextInput flat={true} label="Patient Full Name" className="input w-full border mt-2 flex-1" required placeHolder="Patient Full Name" name="name" type="text" errors={errors.name} value={details.name} bind:val={details.name}/>
        </div>
        <div class="col-span-12 sm:col-span-6">
          <TextInput flat={true} label="Patient Phone Number" className="input w-full border mt-2 flex-1" required placeHolder="Patient Phone Number" name="phone" type="text" errors={errors.phone} value={details.phone} bind:val={details.phone}/>
        </div>
        <div class="col-span-12 sm:col-span-6">
          <TextInput flat={true} label="Patient Email" className="input w-full border mt-2 flex-1" required placeHolder="Patient Email" name="email" type="text" errors={errors.email} value={details.email} bind:val={details.email}/>
        </div>
        <div class="col-span-12 sm:col-span-6">
          <TextInput flat={true} label="Patient Date of Birth" className="input w-full border mt-2 flex-1" required placeHolder="Patient Date of Birth" name="date_of_birth" type="date" errors={errors.date_of_birth} value={details.date_of_birth} bind:val={details.date_of_birth}/>
        </div>
        <div class="col-span-12 sm:col-span-6">
          <TextInput flat={true} label="Patient Next of Kin" className="input w-full border mt-2 flex-1" required placeHolder="Patient Next of Kin" name="next_of_kin" type="text" errors={errors.next_of_kin} value={details.next_of_kin} bind:val={details.next_of_kin}/>
        </div>
        <div class="col-span-12 sm:col-span-6">
          <TextInput flat={true} label="Next of Kin Phone" className="input w-full border mt-2 flex-1" required placeHolder="Next of Kin Phone" name="next_of_kin_phone" type="text" errors={errors.next_of_kin_phone} value={details.next_of_kin_phone} bind:val={details.next_of_kin_phone}/>
        </div>
        <div class="col-span-12">
          <FileInput className="rounded" height=70 allowedFileTypes="png jpg jpeg gif bmp" label="Patient Image" name="avatar" accept="image/*" errors={errors.avatar} onChange={file => details.avatar = file}/>
        </div>
      </div>

      <div class="px-5 pb-8 text-center mt-5">
      <!-- <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">Cancel</button> -->
      <button type="submit" class="button w-40 bg-theme-1 text-white">Create Record</button>
      </div>
    </form>
  </div>
</Modal>
