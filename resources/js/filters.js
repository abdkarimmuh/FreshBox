Vue.filter('toIDR', function (value) {
    if (!value) return '';
    return value.toLocaleString("id-ID", {
        minimumFractionDigits: 2
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
