Vue.filter('toIDR', function (value) {
    if (!value) return '';
    let number =  value.toLocaleString("id-ID", {
        minimumFractionDigits: false
    });
    return  number.replace(".",",");
});
Vue.filter('toDate', function (value) {
    if (!value) return '';
    return value.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
});
