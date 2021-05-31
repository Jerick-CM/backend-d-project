@extends('tpl.mail')

@section('content')
<h1>Welcome Aboard!</h1>
    <p class="title">
        Dear {{ $user->name }},
    </p>
    <p>
        <div>We would like to formally welcome you to the ACE Store!</div>
        <div>As a welcome gift, we sent you 10 black tokens to get you started :)</div>
    </p>
    <a href="#" class="sig-btn">SEE YOUR WELCOME GIFT</a>
@endsection