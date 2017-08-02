<script type="text/template" id="poup-template">
		<table style="min-width: 250px;">
			<tr>
				<td colspan="2" style="text-align: center;"><strong><h5>@{{ name }}</h5></strong></td>
			</tr>
			<tr>
				<td style="padding: 0px 8px; width: 140px"><strong>Ubicaci&oacute;n</strong></td>
				<td>@{{ location.stringFullName }}</td>
			</tr>
			<tr>
				<td style="padding: 0px 8px;"><strong>Profundidad TVD (ft)</strong></td>
				<td>@{{ profundidad_tvd }}</td>
			</tr>
			<tr>
				<td style="padding: 0px 8px;"><strong>Profundidad MD (ft)</strong></td>
				<td>@{{ profundidad_md }}</td>
			</tr>			
			<tr>
				<td style="padding: 0px 8px;"><strong>Campo</strong></td>
				<td>@{{ camp.name }}</td>
			</tr>
			<tr>
				<td style="padding: 0px 8px;"><strong>Cuenca</strong></td>
				<td>@{{ cuenca.name }}</td>
			</tr>
			<tr>
				<td style="padding: 0px 8px;"><strong>Operador</strong></td>
				<td>@{{ operator.name }}</td>
			</tr>
			<tr>
				<td style="padding: 0px 8px;"><strong>Desviaci&oacute;n</strong></td>
				<td>@{{ deviation.name }}</td>
			</tr>
			<tr>
				<td style="padding: 0px 8px;"><strong>Tipo de pozo</strong></td>
				<td>@{{ type.name }}</td>
			</tr>
			<tr>
				<td style="padding: 0px 8px;"><strong>Tipos de servicio</strong></td>
				<td>@{{#join}}serviceTypesNames@{{/join}}
				</td>
			</tr>
		</table>
	</script>