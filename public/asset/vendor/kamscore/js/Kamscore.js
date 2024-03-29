
var getRandomId = function (tipe = 'string', length = 5, between = null) {

    if (tipe == 'number' && between)
        return Math.random().toString(between).substr(2, length);
    else
        return Math.random().toString(20).substr(2, length)
};

var waktu = function (time = null, format = 'mysqltimestamp') {
    if (format == 'mysqltimestamp')
        format = 'YYYY-MM-DD HH:mm:ss';
    if (!time)
        time = new Date();

    return moment(time).format(format);
};

String.prototype.capitalize = function (tipe = 'first') {
    if (tipe != 'first') {
        var strings = this.split(' ');
        var text = [];

        strings.forEach(s => {
            text.push(s.charAt(0).toUpperCase() + s.slice(1));
        });
        return text.join(' ');
    }
    else
        return this.charAt(0).toUpperCase() + this.slice(1);

}
String.prototype.replaceAll = function (awal, baru) {
    var strings = this.split(awal);
    return strings.join(baru);
}
String.prototype.rupiahFormat = function () {
    var bilangan = this;
    var number_string = bilangan.toString(),
        sisa = number_string.length % 3,
        rupiah = number_string.substr(0, sisa),
        ribuan = number_string.substr(sisa).match(/\d{3}/g);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.') + ',00';
    }
    return rupiah;
}

String.prototype.isEmail = function (text) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(text);
}

var detectDeviceType = function(){
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? 'Mobile' : 'Desktop';
}
var wait = function (ms) {
    return new Promise((resolve) => setTimeout(resolve, ms));
}
var asyncFunc = async function(callback, ms){
    wait(ms).then(callback);
}
var queryParams = function(key){
    var urlParams = new URLSearchParams(window.location.search);
    if (key)
        return urlParams.get(key);
    return urlParams;
}
var fixedFloat = (nilai, pembulatan) {
    var n = nilai.toFixed(pembulatan);
    var arr = /(\d+)\.0+$/.exec(n);
    if (arr) return arr[1];
    return n;
}
var ucwords = function(str) {
    if (!str) return str;
    str = str.toLowerCase();
    return str.replace(/(^([a-zA-Z\p{M}]))|([ -][a-zA-Z\p{M}])/g,
        function(s){
            return s.toUpperCase();
        });
}, 
Date.prototype.toLocalISOString = function(){
    var date  = this;
    var tzo = - date.getTimezoneOffset(),
      dif = tzo >= 0 ? '+' : '-',
      pad = function(num) {
          return (num < 10 ? '0' : '') + num;
      };

    return date.getFullYear() +
      '-' + pad(date.getMonth() + 1) +
      '-' + pad(date.getDate()) +
      'T' + pad(date.getHours()) +
      ':' + pad(date.getMinutes()) +
      ':' + pad(date.getSeconds()) +
      dif + pad(Math.floor(Math.abs(tzo) / 60)) +
      ':' + pad(Math.abs(tzo) % 60);
},
