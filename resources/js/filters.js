Vue.filter('toIDR', function (value) {
    if (!value) return '';
    return value.toLocaleString("id-ID", {
        minimumFractionDigits: false
    });
});
Vue.filter('toDate', function (value) {
    if (!value) return '';
    return value.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
});
