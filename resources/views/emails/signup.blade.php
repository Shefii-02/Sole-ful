@extends('layouts.email')
@section('content')
    <table width="100%">
	<tbody>
		<tr>
			<td style="padding-bottom: 15px; text-align: center;"><img style="width: 100px; height: auto; vertical-align: middle;" src="{{url('assets/images/mail-logo.png')}}" /><br /><br /><span style="color: #F993C3;">MySweetiePie.ca</span></td>
		</tr>
		<tr>
			<td>
				<h3>Thank you for registered at MySweetiepie!. </h3>
                <p>
                	Name: {{$register['firstname'] }} {{ $register['lastname'] }}
                </p>
                 
                <p>
                Email: {{ $register['email'] }}
                </p>
                <p>
                	 Phone: {{ $register['phone'] }}
                </p>
               
                <p>
                Address: {{ $register['address'] }}
                </p>
                <p>
                	City: {{ $register['city'] }}
                </p>
                <p>
                	Province/State: {{ $register['province'] }}
                </p>
                <p>
                	Country: {{ $register['country'] }}
                </p>
                <p>
                	Postalcode: {{ $register['postalcode'] }}
                </p>
			</td>
		</tr>
		<tr style="background: #F993C3;">
		</tr>
	</tbody>
</table>
@endsection