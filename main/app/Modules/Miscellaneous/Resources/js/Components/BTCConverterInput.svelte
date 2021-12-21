<script>
  import { createEventDispatcher } from 'svelte'
  import axios from 'axios';

  export let label;
  export let placeHolder;
  export let name;
  export let className = '';
  export let errors = [];
  export let controlValue;

  const dispatch = createEventDispatcher();
  let val = '0.000000';

  $: props = (({ onChange, label, name, className, errors, flat, ...rest }) => rest)($$props);


  $:  {
    console.log(controlValue);
    if (controlValue) {
      dispatch('loading');

      val = 'Updating value. Please wait';

      let link = "https://api.coindesk.com/v1/bpi/currentprice/BTC.json";

      axios
        .get(link)
        .then((rsp) => {
          console.log(rsp);

          val = (controlValue / parseFloat(rsp.data.bpi.USD.rate.replace(",", ""))).toFixed(5);
        })
        .catch((e) => {
          console.log(e);
          let data = JSON.parse(e.responseText);
          Toast.fire(data);
        })
        .finally(() => dispatch('completed'))
    }
  }


  /**
   * ! Whatever you export like this can be bound to in the component eg bind:checked:{details.property}
   */
   export { val };
</script>

<!-- Example Usage -->
<!-- <BtcConverterInput className="input w-full border mt-2" controlValue={details.amount} label="Amount (₿)" name="btc-amount" bind:val={details.amount_in_btc} on:loading={() => details.loading = true} on:completed={() => details.loading = false}/> -->

{#if label}
  <label for="">Amount (₿)</label>
{/if}
  <input id={name} name={name} {...props} bind:value="{val}" class={className} {placeHolder} class:error={errors && errors.length} readonly="readonly"/>
