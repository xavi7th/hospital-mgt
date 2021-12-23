<script context="module">
  import FrontDeskUserPagesLayout from "@frontdeskuser-pages/Layouts/FrontDeskUserPagesLayout.svelte";
  export const layout = FrontDeskUserPagesLayout
</script>

<script>
  import FileInput from '@miscellaneous-components/FileInput.svelte';
  import { page } from '@inertiajs/inertia-svelte';
import { Inertia } from '@inertiajs/inertia';

$: ({ authuser, errors } = $page.props);

let details = {}

let updateProfileImage = () => {
  BlockToast.fire({text: 'Uploading profile image ...'})

  console.log(details);

  Inertia.post(route('frontdeskusers.profile'), details);
}
</script>

<div class="intro-y flex items-center mt-8">
  <h2 class="text-lg font-medium mr-auto">
      Patient List
  </h2>
</div>
