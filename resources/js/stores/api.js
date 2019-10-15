import axios from 'axios';

const $axios = axios.create({
    baseURL: BaseUrl('api/v1/'),
    headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Authorization': 'Bearer ' + AccessToken
    }
});

export default $axios;
