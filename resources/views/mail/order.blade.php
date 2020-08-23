<table style="border-collapse:collapse;">
<tr><td style="{{ $td_style }}">Order #:</td><td style="{{ $td_style }}">{{ $id }}</td></tr>
<tr><td style="{{ $td_style }}">Name:</td><td style="{{ $td_style }}">{{ $name }}</td></tr>
<tr><td style="{{ $td_style }}">Email:</td><td style="{{ $td_style }}">{{ $email }}</td></tr>
<tr><td style="{{ $td_style }}">Phone:</td><td style="{{ $td_style }}">{{ $phone }}</td></tr>
<tr><td style="{{ $td_style }}">Address:</td><td style="{{ $td_style }}">{{ $address }}</td></tr>
</table>
<br>
<table style="border-collapse:collapse;">
	<tr>
		<td style="{{ $td_style }}">Items:</td>
		<td style="{{ $td_style }}">Quantity:</td>
		<td style="{{ $td_style }}">Price:</td>
		<td style="{{ $td_style }}">Cost:</td>
	</tr>
@foreach($items as $item)
<tr>
	<td style="{{ $td_style }}">{{ $item->product->title }}<br>
		<small>{{ strip_tags($item->product->description) }}</small>
	</td>
	<td style="{{ $td_style }}">{{ $item->qnt }}</td>
	<td style="{{ $td_style }}">{{ $currency }} {{ $item->price }}</td>
	<td style="{{ $td_style }}">{{ $currency }} {{ $item->cost }}</td>
</tr>
@endforeach
<tr>
	<td style="{{ $td_style }}" colspan="3">Total</td>
	<td style="{{ $td_style }}">{{ $currency }} {{ $total }}</td>
</tr>
</table>