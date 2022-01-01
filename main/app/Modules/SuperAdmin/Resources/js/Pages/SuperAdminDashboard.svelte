<script context="module">
  import FrontDeskUserPagesLayout from "@frontdeskuser-pages/Layouts/FrontDeskUserPagesLayout.svelte";
  export const layout = FrontDeskUserPagesLayout
</script>

<script>
  export let statistics = {};
</script>

<div class="grid grid-cols-12 gap-6">
  <div class="col-span-12 mt-8">
      <div class="intro-y flex items-center h-10">
          <h2 class="text-lg font-medium truncate mr-5">
              Account Summary
          </h2>
      </div>
      <div class="grid grid-cols-12 gap-6 mt-5">

          <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
              <div class="report-box zoom-in">
                  <div class="box p-5">
                      <div class="text-3xl font-bold leading-8 mt-4">{statistics.total_users_count}</div>
                      <div class="text-base text-gray-600 mt-4">Total Registered Clients</div>
                  </div>
              </div>
          </div>

          <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
              <div class="report-box zoom-in">
                  <div class="box p-5">
                      <div class="text-3xl font-bold leading-8 mt-4">{statistics.unverified_users_count}</div>
                      <div class="text-base text-gray-600 mt-4">Total Unverified Clients</div>
                  </div>
              </div>
          </div>

      </div>

      <!-- <div class="grid grid-cols-12 gap-6 mt-5">

        <div class="col-span-12 xl:col-span-6 mt-6">
          <div class="intro-y flex items-center h-10">
              <h2 class="text-lg font-medium truncate mr-5">
                  Site Notifications
              </h2>
          </div>
          <div class="mt-5">
              <div class="intro-y">
                  <div class="box px-4 py-4 mb-3 flex items-center zoom-in">
                      <div class="w-10 h-10 flex-none image-fit rounded-md overflow-hidden">
                          <img alt="Midone Tailwind HTML Admin Template" src="dist/images/profile-5.jpg">
                      </div>
                      <div class="ml-4 mr-auto">
                          <div class="font-medium">Denzel Washington</div>
                          <div class="text-gray-600 text-xs">11 June 2021</div>
                      </div>
                      <div class="py-1 px-2 rounded-full text-xs bg-theme-9 text-white cursor-pointer font-medium">137 Sales</div>
                  </div>
              </div>
              <a href="" class="intro-y w-full block text-center rounded-md py-4 border border-dotted border-theme-15 dark:border-dark-5 text-theme-16 dark:text-gray-600">View More</a>
          </div>
      </div>
    </div> -->
  </div>
</div>
