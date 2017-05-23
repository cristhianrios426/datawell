@extends('mails.layout')
@section('body')
<h2 >Has recibido un nuevo mensaje de contacto</h2>
<table>	
	<tbody>
		<tr>
			<td>
				<strong>De:</strong>
			</td>
			<td>
				{{{ $user->name }}}
			</td>
		</tr>
		<tr>
			<td>
				<strong>Email:</strong>
			</td>
			<td>
				{{{ $user->email }}}
			</td>
		</tr>
		<tr>
			<td>
				<strong>Telefono:</strong>
			</td>
			<td>
				{{{ $user->phone }}}
			</td>
		</tr>
		<tr>
			<td>
				<strong>Celular:</strong>
			</td>
			<td>
				{{{ $user->cell }}}
			</td>
		</tr>
		<tr>
			<td>
				<strong>Asunto:</strong>
			</td>
			<td>
				{{{ $subject_m }}}
			</td>
		</tr>
		<tr>
			<td>
				<strong>Mensaje:</strong>
			</td>
			<td>
				{{{ $message_m }}}
			</td>
		</tr>
	</tbody>
</table>
@stop