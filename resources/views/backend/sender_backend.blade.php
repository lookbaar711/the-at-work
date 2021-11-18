<form action="{{ route('backend.sender') }}" method="post">
	{{ csrf_field() }}
	{{-- หมายเลข : <input type="text" name="queue"><br>
	ช่องบริการ : <input type="text" name="counter"><br> --}}

	email : <input type="text" name="send_to_email"><br>

	<input type="submit">