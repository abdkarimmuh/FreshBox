function BaseUrl(path = '') {
return '{!! url('/') !!}/' + path;
}

const AuthUser = {!! Auth::check() ? Auth::user()->toJson() : 'false' !!}
const UserID = {!! Auth::check() ? Auth::user()->id : 'false' !!}
const AccessToken = '{!! request()->session()->get('accessToken')  !!}';
const bootstrap = '{{ asset('assets/css/bootstrap.min.css') }}'
