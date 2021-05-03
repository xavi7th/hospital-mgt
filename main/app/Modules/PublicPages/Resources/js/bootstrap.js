import { App } from '@inertiajs/inertia-svelte'
import { InertiaProgress } from '@inertiajs/progress'
import { Inertia } from "@inertiajs/inertia";
import { getErrorString, mediaHandler } from "@PublicShared/helpers";

window.swal = require('sweetalert2')
window._ = {
	split: require('lodash/split'),
}
window.Toast = swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 2000,
	icon: "success"
});

window.ToastLarge = swal.mixin({
	icon: "success",
	title: 'To be implemented!',
	html: 'I will close in <b></b> milliseconds.',
	timer: 3000,
  timerProgressBar: true,
	onBeforeOpen: () => {
		swal.showLoading()
	},
	// onClose: () => {}
})

window.BlockToast = swal.mixin({
	showConfirmButton: true,
	onBeforeOpen: () => {
		swal.showLoading()
	},
	showCloseButton: false,
	allowOutsideClick: false,
	allowEscapeKey: false
});

window.swalPreconfirm = swal.mixin({
	title: 'Are you sure?',
	text: "Implement this when you call the mixin",
	icon: 'question',
	showCloseButton: false,
	allowOutsideClick: () => !swal.isLoading(),
	allowEscapeKey: false,
	showCancelButton: true,
	focusCancel: true,
	cancelButtonColor: '#d33',
	confirmButtonColor: '#3085d6',
	confirmButtonText: 'To be implemented',
	showLoaderOnConfirm: true,
	preConfirm: () => {
		/** Implement this when you call the mixin */
	},
})

InertiaProgress.init({
  // The delay after which the progress bar will
  // appear during navigation, in milliseconds.
  delay: 250,

  // The color of the progress bar.
  color: '#29d',

  // Whether to include the default NProgress styles.
  includeCSS: true,

  // Whether the NProgress spinner will be shown.
  showSpinner: true,
})

Inertia.on('start', (event) => {
	console.log(event);
	jQuery('#page-loader')
		.fadeIn()
})

Inertia.on('progress', (event) => {
  console.log(event);
})

Inertia.on('success', (e) => {
  if (e.detail.page.props.flash.success) {
    ToastLarge.fire( {
      title: "Success",
      html: e.detail.page.props.flash.success,
      icon: "success",
      timer: 1000,
      allowEscapeKey: true
    } );
  }
  else {
    swal.close();
  }
  jQuery('#page-loader')
  	.fadeOut()
})

Inertia.on('error', (e) => {
  console.log(`There were errors on your visit`)
  console.log(e)
  jQuery('#page-loader')
  	.fadeOut()
  ToastLarge.fire( {
    title: "Error",
    html: getErrorString( e.detail.errors ),
    icon: "error",
    timer:10000, //milliseconds
    footer:
    	`Our support email: &nbsp;&nbsp;&nbsp; <a target="_blank" href="mailto:${process.env.MIX_APP_EMAIL}">${process.env.MIX_APP_EMAIL}</a>`,
  } );
})

Inertia.on('invalid', (event) => {
  console.log(`An invalid Inertia response was received.`)

  console.log(event);

  event.preventDefault()
  jQuery('#page-loader')
  	.fadeOut()
  Toast.fire({
    position: 'top',
    title: 'Oops!',
    text: event.detail.response.statusText,
    icon:'error'
  })
})

Inertia.on('exception', (event) => {
  console.log(event);
  console.log(`An unexpected error occurred during an Inertia visit.`)
  console.log(event.detail.error)
  jQuery('#page-loader')
  	.fadeOut()
})

Inertia.on('finish', (e) => {
  // console.log(e);
})

let { isMobile, isDesktop } = mediaHandler();

const app = document.getElementById('app')
new App({
	target: app,
	props: {
		initialPage: JSON.parse(app.dataset.page),
		resolveComponent: str => {
			let [module, page] = _.split(str, '::');

			return import(
					/* webpackChunkName: "js/[request]" */
					/* webpackPrefetch: true */
					`../../../${module}/Resources/js/Pages/${page}.svelte`)
		},
    resolveErrors: page => ((page.props.flash.error || page.props.errors) || {}),
		transformProps: props => {
			return {
				...props,
				isMobile,
				isDesktop
			}
		}
	},
})

/**
 *! Cause back() and forward() buttons of the browser to refresh the browser state
 */
// if (!('onpopstate' in window)) {
// window.addEventListener('popstate', () => {
// 	Inertia.reload({ preserveScroll: true, preserveState: false })
// })
// }

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
