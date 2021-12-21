<script>
  export let perc, theme = '', animated = true;

  $: props = (({perc, theme, animated, ...rest}) => rest)($$props);
</script>

<style>
  .bar{
    color: white;
    font-size: 0.5rem;
    font-weight: bold;
    text-align: center;
  }
  .animated-progress-bar {
    position: relative;
    overflow: hidden;
  }
  .animated-progress-bar::after {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    transform: translateX(-100%);
    background-image: linear-gradient(
      90deg,
      rgba(233, 233, 233, 1) 0,
      rgba(233, 233, 233, 0.9) 50%,
      rgba(233, 233, 233, 0.8) 100%
    );
    animation: shimmer 2s ease-out infinite;
    content: "";
  }

  @keyframes shimmer {
    100% {
      transform: translateX(0%);
      opacity: 0;
    }
  }
</style>

<!-- Example Usage -->
<!-- <AnimatedProgressBar perc=57 theme='bg-theme-6' /> -->


<div class="relative h-3 w-full xl:w-5/6 bg-gray-400 dark:bg-dark-5 rounded-full">
  <div style="width: {perc}%;" class="w-1/2 h-full rounded-full {theme} bar" class:animated-progress-bar={animated} {...props}>{perc}%</div>
</div>

<!-- <div class="relative h-2 w-full sm:w-1/2 bg-gray-400 dark:bg-dark-1 rounded-full">
  <div style="width: 60%" class="absolute top-0 h-4 rounded shim-green" />
</div> -->
