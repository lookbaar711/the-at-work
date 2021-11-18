<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link href="/css/bootstrap-4.0.0/bootstrap.min.css" rel="stylesheet">
    <style>
      .text-right{
  			text-align: right;
  		}
  		.text-center{
  			text-align: center;
  		}
  		.text-left {
  			text-align: left;
  		}
  		.three thead{
  			font-size: 16px;
  			font-weight: 900;
  			border-bottom:1px solid #000000;
  			border-top:1px solid #000000;
  		}
  	</style>
</head>

<body>
  <div class="row">
  	<div class="col-xs-4">
  		<h2>{{ $subject }}</h2>
  		<table class="w-100" style="width:100% border: 1px solid black">
  			<tbody>
          <tr>
  					<td><h2>Password :</h2></td>
  					<td><h2>{{$password}}</h2></td>
  				</tr>
  			</tbody>
  		</table>

  </div>

</body>

</html>
