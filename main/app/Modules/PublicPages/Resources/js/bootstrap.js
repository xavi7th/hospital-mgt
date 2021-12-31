import { createInertiaApp } from '@inertiajs/inertia-svelte'
import { InertiaProgress } from '@inertiajs/progress'
import { Inertia } from "@inertiajs/inertia";
import { getErrorString } from "@miscellaneous-shared/utils";

window.swal = require('sweetalert2')
window._ = {
	isString: require('lodash/isString'),
	size: require('lodash/size'),
	split: require('lodash/split'),
	reduce: require('lodash/reduce'),
	truncate: require('lodash/truncate'),
}
window.Toast = swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 5000,
	icon: "success",
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', swal.stopTimer)
    toast.addEventListener('mouseleave', swal.resumeTimer)
  }
});

window.ToastLarge = swal.mixin({
	icon: "success",
	title: 'To be implemented!',
	html: 'I will close in <b></b> milliseconds.',
  showConfirmButton: false,
	timer: 10000,
  timerProgressBar: true,
	willOpen: () => {
		swal.showLoading()
	},
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', swal.stopTimer)
    toast.addEventListener('mouseleave', swal.resumeTimer)
  },
	// onClose: () => {}
})

window.BlockToast = swal.mixin({
  willOpen: () => {
    swal.showLoading()
	},
  showConfirmButton: false,
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
	// console.log(event);
})

Inertia.on('progress', (event) => {
  // console.log(event);
})

Inertia.on('success', (e) => {
  if (e.detail.page.props.flash.success) {
    ToastLarge.fire( {
      title: "Success",
      html: e.detail.page.props.flash.success,
      icon: "success",
      timer: 5000,
      allowEscapeKey: true
    } );
  }
  else {
    swal.close();
  }
})

Inertia.on('error', (e) => {
  console.log(`There were errors on your visit`)
  // console.log(e)
  ToastLarge.fire( {
    title: "Error",
    html: getErrorString( e.detail.errors ),
    icon: "error",
    timer:10000, //milliseconds
    allowEscapeKey: true,
  } );
})

Inertia.on('invalid', (event) => {
  console.log(`An invalid Inertia response was received.`)

  console.log(event);

  event.preventDefault()
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
})

Inertia.on('finish', (e) => {
  // console.log(e);
})

createInertiaApp({
  resolve: name => {

    let [module, component] = _.split(name, '::');

    return import(
      /* webpackChunkName: "js/[request]" */
      /* webpackPrefetch: true */
      `../../../${module}/Resources/js/Pages/${component}.svelte`)
  },
  setup({ el, App, props }) {
    // console.log(props);
    if (Object.entries(props.initialPage.props.errors).length) {
      ToastLarge.fire( {
        title: "Error",
        html: getErrorString( props.initialPage.props.errors ),
        icon: "error",
        timer:10000, //milliseconds
      } );
    }
    else if (props.initialPage.props.flash.success) {
      ToastLarge.fire( {
        title: "Success",
        html: props.initialPage.props.flash.success,
        icon: "success",
        timer: 2000,
        allowEscapeKey: true
      } );
    }
    new App({ target: el, props })
  },
})
