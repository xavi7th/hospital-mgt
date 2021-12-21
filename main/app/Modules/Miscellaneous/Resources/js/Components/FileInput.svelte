<script>
  import { filesize } from "@miscellaneous-shared/utils";
  import { onMount } from "svelte";

  export let label;
  export let className = "";
  export let name;
  export let errors = [];
  export let onChange;
  export let height = 100; // px
  export let maxHeight = 5000;
  export let maxWidth = 5000;
  export let minHeight;
  export let minWidth;
  export let maxFileSize = "3M"; // e.g. 3M, 3G, 3K
  export let allowedFileTypes = "jpg jpeg gif webp png bmp";

  function handleFileChange(e) {
    onChange(e.target.files[0]);
  }

  onMount(() => {
    if (!name) {
      alert("File input init without a name.");
      return;
    }

    let clearInt = setInterval(() => {
      try {
        jQuery("#" + name).dropify({
          messages: {
            default: label,
            replace: "Drag and drop or click to replace ID card",
            remove: "Remove",
            error: "Ooops! Something wrong happened.",
          },
        });
        clearInterval(clearInt);
      } catch (e) {
        console.log(e);
      }
    }, 300);
  });

  $: props = (({
    label,
    className,
    name,
    errors,
    onChange,
    height,
    maxHeight,
    maxWidth,
    minHeight,
    minWidth,
    maxFileSize,
    allowedFileTypes,
    ...rest
  }) => rest)($$props);
</script>

<style lang="scss">
  :global(.rounded .dropify-wrapper){
    border-radius: 10px;
  }
  :global(.rounded.has-error .dropify-wrapper){
    border-color: #db3847!important;
  }

  :global(html.dark .dropify-wrapper){
    background-color: #293146;
    color: #cbd5e0;

    &:hover{
      background-image: linear-gradient(-45deg,rgba(246, 246, 246, 0.129) 25%,transparent 0,transparent 50%,rgba(246, 246, 246, 0.129) 0,rgba(246, 246, 246, 0.129) 75%,transparent 0,transparent)
    }

    & :global(.dropify-preview){
      background-color: #293146;
      color: #cbd5e0;
    }
  }

  :global(.no-icon .file-icon){
    display: none;
  }

</style>

<!-- Example Usage -->
<!-- @see https://github.com/JeremyFagis/dropify -->
<!-- <FileInput className="mb-20 rounded" height=70 allowedFileTypes="pdf png psd" label="Upload your ID card" name="id-card" accept="image/*" errors={errors.id_card} onChange={file => details.id_card = file}/> -->
<!-- <FileInput label="Photo" name="photo" minHeight=400 maxHeight=1000 allowedFileTypes="pdf png psd" errors={errors.photo} onChange={handleFileChange}/> -->

<div class="form-group {className}" class:has-error={errors && errors.length}>
  <div>
    <input
      id={name}
      type="file"
      class="dropify"
      on:change={handleFileChange}
      data-allowed-file-extensions={allowedFileTypes}
      data-max-height={maxHeight}
      data-min-height={minHeight}
      data-max-width={maxWidth}
      data-min-width={minWidth}
      data-max-file-size={maxFileSize}
      data-height={height}
      {...props}
    />
  </div>

  {#if errors && errors.length > 0 && false}
    <label for="" class="error">{errors}</label>
  {/if}
</div>
