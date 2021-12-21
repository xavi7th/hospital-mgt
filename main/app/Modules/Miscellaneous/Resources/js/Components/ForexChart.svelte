<script>
  import { onMount } from "svelte";

  export let chart_data = {};

  let chartContainer, frag;

  onMount(() => {

    if ($$slots.chart_content) {
      frag = document.createRange().createContextualFragment(chartContainer.innerHTML);
    } else{
      frag = document.createRange().createContextualFragment(chart_data.chart_content);
    }

      let clearInt = setInterval(() => {
        try {
          chartContainer.replaceWith(frag);
          clearInterval(clearInt);
        } catch (e) {
          console.log(e);
        }
      }, 300);
  });
</script>

<!-- REQUIRED IN PAGE -->
<!-- <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script> -->

<!-- {#if $$slots.chart_content} -->
  <div bind:this={chartContainer} >
    <slot name="chart_content"></slot>
  </div>
<!-- {:else} -->
  <!-- <div bind:this={chartContainer} /> -->
<!-- {/if} -->
