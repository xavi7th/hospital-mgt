<script>
  import { fade, fly } from 'svelte/transition';
  import { onDestroy, onMount } from 'svelte';

  export let className = '', countDownTime = 0, // in seconds
  hideOnFinish = false, hideZeroValues = false, showTimerText = true, showContantAfterCountdown=false,
  onFinish = () => console.log('-----===== Timer Ended! =====------');



  let timerText, hideElem = false, intervalId, millis, days, hours, minutes, seconds, countdown = parseInt( countDownTime, 10 );

  function resetInterval() {
    if ( intervalId ) {
      clearInterval( intervalId );
      intervalId = null;
    }
  }

  function stop() {
    resetInterval();
    if (hideOnFinish) {
      hideElem = true;
    }
    // elem.children('p').html('Your time is up!');
    // $emit('timer-stopped', { intervalId: intervalId, millis: millis });
  };

  function updateTimerText() {
    seconds = Math.floor( ( millis / 1000 ) % 60 );
    minutes = Math.floor( ( ( millis / ( 1000 * 60 ) ) % 60 ) );
    hours = Math.floor( ( ( millis / ( 1000 * 60 * 60 ) ) % 24 ) );
    days = Math.floor( ( ( millis / ( 1000 * 60 * 60 ) ) / 24 ) );

    let text = '';

    if (hideZeroValues) {
      if (days > 0) text += ` ${days > 9 ? '' : 0}${days} ${days > 1 ? "days" : "day"}`;
      if (hours > 0) text += ` ${hours > 9 ? '' : 0}${hours} ${hours > 1 ? "hours" : "hour"}`;
      if (minutes > 0) text += ` ${minutes > 9 ? '' : 0}${minutes} ${minutes > 1 ? "minutes" : "minute"}`;
      if (seconds >= 0) text += ` ${seconds > 9 ? '' : 0}${seconds} ${seconds > 1 ? "seconds" : "second"}`;
    }
    else{
      text = ` ${days > 9 ? '' : 0}${days} ${days > 1 ? "days" : "day"}
               ${hours > 9 ? '' : 0}${hours} ${hours > 1 ? "hours" : "hour"}
               ${minutes > 9 ? '' : 0}${minutes} ${minutes > 1 ? "minutes" : "minute"}
               ${seconds > 9 ? '' : 0}${seconds} ${seconds > 1 ? "seconds" : "second"}`;
    }

    return text;

  }

  function tick() {
    //The default time that the timer will be reset to after count down expires.
    millis = 0;
    // console.log(countdown);

    if ( countdown > 0 ) {
      millis = countdown * 1000;
      countdown--;
    } else if ( countdown <= 0 ) {
      stop();
      onFinish();
    }

    timerText = updateTimerText();
  }

  function start() {
    resetInterval();
    intervalId = setInterval( tick, 1000); // make the interval fire every 1000ms = 1s
  }

  onMount(() => {
    start();
  });

  onDestroy(()=>{
    return resetInterval();
  })
</script>

<style lang="scss">
  .d-none{
    display: none !important;
  }

  .timer-wrapper{
    min-height: 1.5rem;
    text-align: center;
    position: relative;

    p{
      color: inherit;
      margin-bottom: 0;
      position: absolute;
      white-space: nowrap;
    }
  }
</style>

<!-- EXAMPLE USAGE -->
<!-- <CountdownTimer countDownTime=10 onFinish={() => alert('time up!')} hideOnFinish={true} hideZeroValues={true}/> -->
<!-- <CountdownTimer className="text-light text-center px-10" countDownTime=15 onFinish={() => timeUp = true} hideZeroValues={true} hideOnFinish={true} showContantAfterCountdown={timeUp} transitionKey={2}>
        <svelte:fragment slot="beforeTimer">
          <span>Validating withdrawal in </span>
        </svelte:fragment>
        <svelte:fragment slot="contentAfterCountdown">
          <span transition:fade>Time Up</span>
        </svelte:fragment>
      </CountdownTimer> -->
<!-- TODO: Implement seconds only counter e.g. 300 seconds ... -->
<!-- TODO: Implement minutes and seconds only counter eg 73 minutes 59 seconds -->
<!-- TODO: Implement hours, minutes and seconds only counter eg 27 hours 59 minutes 59 seconds -->

<div class="timer-wrapper {className}">
  {#if millis !== undefined && ! hideElem && showTimerText}
    <p class="timer-display" in:fly="{{ x: 200, duration: 2000 }}" out:fly="{{ x: -50, duration: 200 }}">
      <slot name="beforeTimer" />
      {timerText}
      {#if $$slots.afterTimer}
        <slot name="afterTimer" />
      {/if}
    </p>
    <slot />
  {/if}
  {#if $$slots.contentAfterCountdown && showContantAfterCountdown}
    <p class="timer-display" in:fly="{{ x: 200, duration: 2000 }}" out:fly="{{ x: -200, duration: 2000 }}">
      <slot name="contentAfterCountdown" />
    </p>
  {/if}
</div>
