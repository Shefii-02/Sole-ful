@extends('layouts.email')

@section('content')

<h2 style="font-size:170%;font-weight:bolder;text-align:center;letter-spacing:-1px; margin-bottom:30px; color:#666;"><span>Enquiry Inquiry</span></h2>
            
<table cellpadding="8" cellspacing="0" align="center">
    <tr>
        <th align="left" style="font-weight:normal;border-bottom:1px solid #DDD; ">Event Name</th>
        <td style="font-weight:bold;border-bottom:1px solid #DDD;">{{ $contact->event_name }}</td>
    </tr>
    <tr>
        <th align="left" style="font-weight:normal;border-bottom:1px solid #DDD;">Company Name</th>
        <td style="font-weight:bold;border-bottom:1px solid #DDD;">{{ $contact->company_name }}</td>
    </tr>
    <tr>
        <th align="left" style="font-weight:normal;border-bottom:1px solid #DDD; ">Contact Person</th>
        <td style="font-weight:bold;border-bottom:1px solid #DDD;">{{ $contact->contact_person }} </td>
    </tr>
    <tr>
        <th align="left" style="font-weight:normal;border-bottom:1px solid #DDD;">Email</th>
        <td style="font-weight:bold;border-bottom:1px solid #DDD;">{{ $contact->email }}</td>
    </tr>
    <tr>
        <th align="left" style="font-weight:normal;border-bottom:1px solid #DDD;">Phone</th>
        <td style="font-weight:bold;border-bottom:1px solid #DDD;">{{ $contact->phone }}</td>
    </tr>
   
    <tr>
        <th align="left" style="font-weight:normal;border-bottom:1px solid #DDD;">How many people</th>
        <td style="font-weight:bold;border-bottom:1px solid #DDD;">{{ $contact->how_many_people }}</td>
    </tr>
  
    <tr>
        <th align="left" style="font-weight:normal;border-bottom:1px solid #DDD;">Interested in..</th>
        <td style="font-weight:bold;border-bottom:1px solid #DDD;">
            <ul>
                @if($contact->interested)
                    @foreach($contact->interested as $interest)
                      <li>{{ $interest }}</li>
                    @endforeach
                @endif
            </ul>
        </td>
    </tr>
    <tr>
        <td colspan="2"><p>{{ $contact->message }}</p></td>
    </tr>
</table>

@endsection
