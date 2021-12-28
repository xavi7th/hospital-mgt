<script context="module">
  import FrontDeskUserPagesLayout from "@frontdeskuser-pages/Layouts/FrontDeskUserPagesLayout.svelte";
  export const layout = FrontDeskUserPagesLayout
</script>

<script>
  import { page } from '@inertiajs/inertia-svelte';
  import { Inertia } from '@inertiajs/inertia';

  $: ({ authuser } = $page.props);

</script>
