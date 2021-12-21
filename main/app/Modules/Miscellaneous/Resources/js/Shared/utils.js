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
