@extends('mails.layout')
@section('body')
<h2>Hola, {{{ $user->name }}}</h2>
<p>Has sido invitado a hacer parte de {{{ config('app.name') }}}.</p>
<p>Para activar tu cuenta cuenta  sigue el enlace:  <a href="{{ route('user.account_activation',['token'=>$token]) }}">{{ route('user.account_activation',['token'=>$token]) }}</a></p>
@stop