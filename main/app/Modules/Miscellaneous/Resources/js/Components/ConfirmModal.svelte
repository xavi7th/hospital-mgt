<script>
  import { inertia } from '@inertiajs/inertia-svelte';

  export let  actionMethod = 'PUT', actionUrl, details ={};

  $: console.log(actionUrl);

  let fireBloackToast = () => {
    BlockToast.fire({
      text: "Please wait ..."
    });
  }

</script>

<!-- <a href="javascript:;" data-toggle="modal" data-target="#confirm-action-modal"  on:click="{() => {actionUrl = route('nurses.delete', user);}}" class=" button button--sm flex items-center text-white rounded bg-purple-500">
  <i data-feather="check-square" class="w-3 h-3 mr-1"></i> Approve
</a> -->
<!-- <ConfirmModal {actionUrl} {actionMethod} /> -->


{#if actionUrl}
<div class="modal" id="confirm-action-modal">
  <div class="modal__content">
    <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
      <div class="text-3xl mt-5">Are you sure?</div>
    </div>
    <div class="px-5 pb-8 text-center">
      <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
      <a href="{actionUrl}" data-dismiss="modal" class="button w-24 bg-theme-6 text-white" use:inertia={{ method: actionMethod, preserveState:true, preserveScroll:true, onBefore: fireBloackToast, onSuccess:() => details={} }}>Confirm</a>
    </div>
  </div>
</div>
{/if}
