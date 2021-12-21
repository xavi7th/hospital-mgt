<script>
  export let id;
</script>

<div class="modal" id="{id}">
  <div class="modal__content relative">
    <a data-dismiss="modal" href="javascript:;" class="absolute right-0 top-0 mt-3 mr-3"> <i data-feather="x" class="w-8 h-8 text-gray-500"></i> </a>

    <slot />
  </div>
</div>
