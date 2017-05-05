@extends('mails.layout')
@section('body')
<h2>Hola, {{{ $user->name }}}</h2>
<p>Ha habido cambios en la configuración de tu cuenta en {{{ config('app.name') }}} y debes realizar el proceso de activación nuevamente.</p>
<p>Sigue el enlace para terminar el proceso:  <a href="{{ route('user.account_activation',['token'=>$token]) }}">{{ route('user.account_activation',['token'=>$token]) }}</a></p>
@stop