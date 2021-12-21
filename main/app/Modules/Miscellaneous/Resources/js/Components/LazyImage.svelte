<script>
  export let className='uk-margin-small-right in-margin-top-30-s';
  export let imgSrc = '/img/forexbot-v-logo-dark.png';
  export let altText = null;
  export let height = 23;
  export let width = 134;

  $: props = (({ width, height, alt, src, imgSrc, className, ...rest }) => rest)($$props);
</script>

<img class={className} src="/img/in-lazy.gif" data-src="{imgSrc}" alt="{altText}" width="{width}" height="{height}" data-uk-img {...props}/>
