<script context="module">
  import FrontDeskUserPagesLayout from "@frontdeskuser-pages/Layouts/FrontDeskUserPagesLayout.svelte";
  export const layout = FrontDeskUserPagesLayout
</script>

<script>
  import ForexChart from '@miscellaneous-components/ForexChart.svelte';
  import Modal from '@miscellaneous-components/Modal.svelte';
  import { to_currency } from '@miscellaneous-shared/utils';
  import { page } from '@inertiajs/inertia-svelte';
  import { Inertia } from '@inertiajs/inertia';

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

<div class="grid grid-cols-12 gap-6 mt-5">
  <div class="intro-y col-span-12 lg:col-span-6">
      <!-- BEGIN: Form Layout -->
      <div class="intro-y box p-5">
          <div class="mt-3">
            <label for="name">Full Name</label>
            <div class="mt-2">
              <input type="text" name="name" class="input w-full border mt-2" placeholder="e.g Mike Rex">
            </div>
          </div>
          <div class="mt-3">
            <label for="name">Phone Number</label>
            <div class="mt-2">
              <input type="text" name="number" class="input w-full border mt-2" placeholder="e.g +2348183452673">
            </div>
          </div>
          <div class="mt-3">
            <label for="name">Email</label>
            <div class="mt-2">
              <input type="text" name="email" class="input w-full border mt-2" placeholder="e.g abx@gmail.com">
            </div>
          </div>
          <div class="mt-3">
            <label for="name">Profile Image</label>
            <div class="mt-2">
              <div class="p-5" id="single-file-upload">
                <div class="preview">
                    <form data-single="true" action="/file-upload" class="dropzone border-gray-200 border-dashed dz-clickable">

                        <div class="dz-message" data-dz-message="">
                            <div class="text-lg font-medium">Drop files here or click to upload.</div>
                            <div class="text-gray-600"> This is just a demo dropzone. Selected files are <span class="font-medium">not</span> actually uploaded. </div>
                        </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
          <div class="text-right mt-5">
              <button type="button" class="button w-24 bg-theme-1 text-white">Save</button>
          </div>
      </div>
      <!-- END: Form Layout -->
  </div>
</div>
