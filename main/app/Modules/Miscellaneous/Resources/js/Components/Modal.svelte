<script>
  export let id, modalTitle;
</script>

<div class="modal" id="{id}">
  <div class="modal__content relative">
    <a data-dismiss="modal" href="javascript:;" class="absolute right-0 top-0 mt-3 mr-3"> <i data-feather="x" class="w-8 h-8 text-gray-500"></i> </a>


    {#if modalTitle}
      <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
        <h2 class="font-medium text-base mr-auto text-center">
            {modalTitle}
        </h2>
      </div>
    {/if}

    <slot />
  </div>
</div>
