<script>
  import { onMount } from 'svelte';

  let logoImg;
  export let url = '/'
  export let imgSrc = '/img/forexbot-v-logo-dark.png';

  onMount(() => {
    setTimeout(() => {
      if (logoImg.src.includes('lazy.gif')) {
        logoImg.src = imgSrc;
      }
    }, 1000);
    // !(!w(t, "uk-") && !w(t, "data-uk-")) && f(t.replace("data-uk-", "").replace("uk-", ""))
  })
</script>

<style>
a{background-color:transparent;}
*,:after,:before{border:0 solid #e2e8f0;box-sizing:border-box;}
a{color:inherit;text-decoration:inherit;}
a:active,a:hover{outline:0;}
a{color:#c99c3b;cursor:pointer;text-decoration:none;}
a:hover{color:#b88e33;text-decoration:underline;}
img{vertical-align:middle;}
img{box-sizing:border-box;height:auto;max-width:100%;}
::-moz-selection{background:#39f;color:#fff;text-shadow:none;}
::selection{background:#39f;color:#fff;text-shadow:none;}
.uk-logo{color:#666;font-family:Rubik,sans-serif;font-size:24px;font-size:1.5rem;font-weight:500;text-decoration:none;}
.uk-logo:focus,.uk-logo:hover{color:#666;outline:0;text-decoration:none;}
.uk-margin-small-right{margin-right:10px!important;}
@media print{
*,:after,:before{background:0 0!important;box-shadow:none!important;color:#000!important;text-shadow:none!important;}
a,a:visited{text-decoration:underline;}
img{page-break-inside:avoid;}
img{max-width:100%!important;}
}
.uk-logo{margin-top:5px;}
.in-offset-top-10{margin-top:-10px;}
/*! CSS Used fontfaces */
@font-face{font-display:swap;font-family:Rubik;font-style:normal;font-weight:300;src:local("Rubik Light"),local("Rubik-Light"),url(http://puma-br.test/fonts/rubik-v9-latin-300.woff2) format("woff2"),url(http://puma-br.test/fonts/rubik-v9-latin-300.woff) format("woff");}
@font-face{font-display:swap;font-family:Rubik;font-style:normal;font-weight:400;src:local("Rubik"),local("Rubik-Regular"),url(http://puma-br.test/fonts/rubik-v9-latin-regular.woff2) format("woff2"),url(http://puma-br.test/fonts/rubik-v9-latin-regular.woff) format("woff");}
@font-face{font-display:swap;font-family:Rubik;font-style:normal;font-weight:500;src:local("Rubik Medium"),local("Rubik-Medium"),url(http://puma-br.test/fonts/rubik-v9-latin-500.woff2) format("woff2"),url(http://puma-br.test/fonts/rubik-v9-latin-500.woff) format("woff");}
</style>

<a class="uk-logo" href="{url}" {...$$props}>
  <img bind:this={logoImg} class="uk-margin-small-right in-offset-top-10" src="/img/in-lazy.gif" data-src="{imgSrc}" alt="wave" width="134" height="23" data-uk-img/>
</a>
