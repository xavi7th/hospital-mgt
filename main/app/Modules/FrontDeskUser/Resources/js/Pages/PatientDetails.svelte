<script context="module">
  import FrontDeskUserPagesLayout from "@frontdeskuser-pages/Layouts/FrontDeskUserPagesLayout.svelte";
  export const layout = FrontDeskUserPagesLayout
</script>

<script>
  import InertiaLink from '@inertiajs/inertia-svelte/src/InertiaLink.svelte';
  import ConfirmModal from '@miscellaneous-components/ConfirmModal.svelte';
  import SelectInput from '@miscellaneous-components/SelectInput.svelte';
  import TextInput from '@miscellaneous-components/TextInput.svelte';
  import Modal from '@miscellaneous-components/Modal.svelte';
  import { page } from '@inertiajs/inertia-svelte';
  import { Inertia } from '@inertiajs/inertia';

$: ({ errors } = $page.props);

let details = {}, appointments=[], val, pending_appointment =  {}, actionUrl, actionMethod;

export let patient = {}, doctors = [];

let bookAppointment = () => {
  BlockToast.fire({text: 'Booking new appointment ...'})

  Inertia.post(route('appointments.create', patient), details);
}

$: {
  appointments = patient.past_appointments || [];
  pending_appointment = patient.pending_appointment;
}
</script>

<div class="intro-y flex items-center mt-8">
  <h2 class="text-lg font-medium mr-auto">

  </h2>
</div>

<div class="intro-y box px-5 pt-5 mt-5">
  <div class="flex flex-col lg:flex-row border-b border-gray-200 dark:border-dark-5 pb-5 -mx-5">
      <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
          <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
              <img alt="{patient.name}" class="rounded-full" src="{patient.avatar_url}">
          </div>
          <div class="ml-5">
              <div class="whitespace-normal font-medium text-lg">{patient.name}</div>
              <div class="text-gray-600">Registered On: {new Date(patient.created_at).toLocaleDateString()} {new Date(patient.created_at).toLocaleTimeString()}</div>
          </div>
      </div>
      <div class="flex mt-6 lg:mt-0 items-center lg:items-start flex-1 flex-col justify-center text-gray-600 dark:text-gray-300 px-5 border-l border-r border-gray-200 dark:border-dark-5 border-t lg:border-t-0 pt-5 lg:pt-0">
        <div class="whitespace-normal flex items-center mt-3"> Full Name: { patient.name } </div>
        <div class="whitespace-normal flex items-center mt-3"> Email: { patient.email } </div>
        <div class="whitespace-normal flex items-center mt-3"> Phone: { patient.phone } </div>
        <div class="whitespace-normal flex items-center"> Date of Birth: { new Date(patient.date_of_birth).toDateString() }</div>
      </div>
      <div class="mt-6 lg:mt-0 flex-1 flex items-center justify-between px-5 border-t lg:border-0 border-gray-200 dark:border-dark-5 pt-5 lg:pt-0">
          <div class="text-center rounded-md py-3">
              <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{patient.next_of_kin}</div>
              <div class="text-gray-600">Next of Kin</div>
          </div>
          <div class="text-center rounded-md py-3">
              <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{patient.next_of_kin_phone}</div>
              <div class="text-gray-600">Next of Kin Phone</div>
          </div>
          <!-- <div class="text-center rounded-md w-20 py-3">
              <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">492</div>
              <div class="text-gray-600">Reviews</div>
            </div> -->
      </div>
  </div>
</div>

<div class="tab-content mt-5">
  <div class="tab-content__pane active" id="profile">
      <div class="grid grid-cols-12 gap-6">
        <!-- BEGIN: Pending Appointment -->
        <div class="intro-y box col-span-12 lg:col-span-6">
          <div class="flex items-center px-5 py-5 sm:py-5 border-b border-gray-200 dark:border-dark-5">
              <h2 class="font-medium text-base mr-auto">
                  Pending Appointment
              </h2>
          </div>
          <div class="p-5">
              <div class="tab-content">
                  <div class="tab-content__pane active" id="latest-tasks-new">
                    {#if pending_appointment}
                      <div class="flex items-center">
                          <div class="border-l-2 border-theme-1 pl-4">
                              <a href="" class="font-medium">
                                Appointment to see {pending_appointment.doctor?.name} booked by {pending_appointment.booked_by?.name}
                                {#if pending_appointment.posted_at}
                                  posted to Nursing unit at {new Date(pending_appointment.posted_at).toLocaleDateString()} {new Date(pending_appointment.posted_at).toLocaleTimeString()}
                                {/if}
                              </a>
                              <div class="text-gray-300">Appointment Date: {new Date(pending_appointment.appointment_date).toDateString() }</div>
                          </div>
                          {#if ! pending_appointment.posted_at}
                            <a href="javascript:;" data-toggle="modal" data-target="#confirm-action-modal" class="ml-auto rounded-full zoom-in flex items-center justify-center button text-white bg-theme-1" on:click="{() => {actionUrl = route('appointments.post_for_vitals', pending_appointment); actionMethod = 'PUT'}}">
                              <i class="w-3 h-3 mr-1 fill-current" data-feather="zap"></i> Send for Vitals
                            </a>
                          {/if}
                      </div>
                    {/if}
                      <!-- <div class="flex items-center mt-5">
                          <div class="border-l-2 border-theme-1 pl-4">
                              <a href="" class="font-medium">Meeting With Client</a>
                              <div class="text-gray-600">02:00 PM</div>
                          </div>
                          <input class="input input--switch ml-auto border" type="checkbox">
                      </div>
                      <div class="flex items-center mt-5">
                          <div class="border-l-2 border-theme-1 pl-4">
                              <a href="" class="font-medium">Create New Repository</a>
                              <div class="text-gray-600">04:00 PM</div>
                          </div>
                          <input class="input input--switch ml-auto border" type="checkbox">
                      </div> -->
                  </div>
              </div>
          </div>
        </div>
        <!-- END: Pending Appointment -->

        <!-- BEGIN: Appointment History -->
        <div class="intro-y box col-span-12 lg:col-span-6">
            <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                  Patient's History
                </h2>
                <a href="javascript:;" data-target="#book-new-appointment" data-toggle="modal"  class="button border relative flex items-center text-gray-700 dark:border-dark-5 dark:text-gray-300 hidden sm:flex">Book Appointment</a>
            </div>
            <div class="p-5">
              {#each appointments as appointment}
                <div class="relative flex items-center border-b border-gray-200 dark:border-dark-5 py-3">
                    <div class="ml-4 mr-auto">
                        <a href="" class="font-medium">Appointment to see {appointment.doctor?.name} on {new Date(appointment.appointment_date).toDateString() }</a>
                        <div class="text-gray-600 mr-5 sm:mr-5">Discharged On {new Date(appointment.discharged_at).toLocaleDateString()}</div>
                    </div>
                    <div class="font-medium text-gray-700 dark:text-gray-600">
                      <InertiaLink href="javascript:;" class="ml-auto rounded zoom-in flex items-center justify-center button button-sm text-white bg-theme-1">
                        Details
                      </InertiaLink>
                    </div>
                </div>
              {/each}
            </div>
        </div>
        <!-- END: Appointment History -->

      </div>
  </div>
</div>


<Modal id="book-new-appointment" modalTitle="Create New Patient Record">
  <div class="p-5 pt-10">
    <form on:submit|preventDefault|stopPropagation="{bookAppointment}" class="border-gray-200 border-dashed">
      <div class="grid grid-cols-12 gap-4 row-gap-3">

        <div class="col-span-12">
          <TextInput flat={true} label="Appointment Date" className="input w-full border mt-2 flex-1" required placeHolder="Appointment Date" name="appointment_date" type="date" errors={errors.appointment_date} value={details.appointment_date} bind:val={details.appointment_date}/>
        </div>

        <div class="col-span-12">
          <SelectInput className="input w-full border mt-2 flex-1" flat={true} name="doctor_id" errors={errors.doctor_id} value={details.doctor_id} bind:val={details.doctor_id}>
            <option value="{undefined}">Select Doctor</option>
            {#each doctors as {id, name} (id)}
                <option value={id}>{name}</option>
            {/each}
          </SelectInput>
        </div>
      </div>

      <div class="px-5 pb-8 text-center mt-5">
        <button type="submit" class="button bg-theme-1 text-white">Book Appointment</button>
      <button type="button" data-dismiss="modal" class="button w-24 border text-gray-100 mr-1">Cancel</button>
      </div>
    </form>
  </div>
</Modal>

<ConfirmModal {actionUrl} {actionMethod} />
