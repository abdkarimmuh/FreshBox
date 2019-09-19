
function BaseUrl(path = '') {
    return '{!! url('/') !!}/' + path;
}

const AuthUser = {!! Auth::check() ? Auth::user()->toJson() : 'false' !!};

const UserID = {!! Auth::check() ? Auth::user()->id : 'false' !!}


const UriSegment2 = {!! request()->segment(2) ? request()->segment(2) : 'false' !!}
const UriSegment3 = {!! request()->segment(3) ? request()->segment(3) : 'false' !!}
const UriSegment4 = {!! request()->segment(4) ? request()->segment(4) : 'false' !!}
const UriSegment5 = {!! request()->segment(5) ? request()->segment(5) : 'false' !!}
