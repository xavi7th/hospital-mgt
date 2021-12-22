export function filesize(size) {
  const i = Math.floor(Math.log(size) / Math.log(1024));
  return (
    (size / Math.pow(1024, i)).toFixed(2) * 1 +
    ' ' +
    ['B', 'kB', 'MB', 'GB', 'TB'][i]
  );
}

export function to_currency(amount, currency = '$') {
	// return currency + Number(amount)
	// 	.toFixed(2)
  //   .toLocaleString()

  return currency + Number(amount).toFixed(2)
		.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")

   var p = Number(amount).toFixed(2).split(".");
    return currency + p[0].split("").reverse().reduce(function(acc, amount, i, orig) {
        return  amount=="-" ? acc : amount + (i && !(i % 3) ? "," : "") + acc;
    }, "") + "." + p[1];
}

export function sleep(milliseconds) {
  const date = Date.now();
  let currentDate = null;
  do {
    currentDate = Date.now();
  } while (currentDate - date < milliseconds);
}

/**
 * Transforms an error object into HTML string
 *
 * @param {String|Array|null} errors The errors to transform
 */
 export const getErrorString = errors => {

	if (_.isString(errors)) {
		var errs = errors;
	} else if (_.size(errors) == 1) {
		var errs = _.reduce(errors, function(val, n) {
			return val.join("<br>") + "<br>" + n;
		});
	} else {
		var errs = _.reduce(errors, function(val, n) {
			return (_.isString(val) ? val : val.join("<br>")) + "<br>" + n;
		});
	}
	return errs
}

export const toCurrency = (amount, currencySymbol = '₦') => {
	if (isNaN(amount)) {
		console.log(amount);
		return 'Invalid Amount';
	}
	return currencySymbol + Number(amount).toFixed(2)
		.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")

	var p = Number(amount)
		.toFixed(2)
		.split(".");
	return currency + p[0].split("")
		.reverse()
		.reduce(function(acc, amount, i, orig) {
			return amount == "-" ? acc : amount + (i && !(i % 3) ? "," : "") + acc;
		}, "") + "." + p[1];
}

export const mediaHandler = () => {

	let isMobile, isDesktop;

	if (window.matchMedia('(max-width: 767px)')
		.matches) {
		isMobile = true;
		isDesktop = false;
	} else {
		isMobile = false;
		isDesktop = true;
	}
	/**
	 * To set up a watcher
	 */
	// window.matchMedia('(min-width: 992px)')
	// 	.addEventListener("change", () => {
	// 		if (window.matchMedia('(max-width: 767px)')
	// 			.matches) {
	// 			isMobile = true;
	// 			isDesktop = false;
	// 		} else {
	// 			isMobile = false;
	// 			isDesktop = true;
	// 		}
	// 	})

	return { isMobile, isDesktop }
}
