
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