<form action="{{ route('backend.sender') }}" method="post">
	{{ csrf_field() }}

	admin_id : <input type="text" name="admin_id"><br>
	<input type="submit">