@foreach($referrals as $referral)
    <tr>
        <td><p>{{$referral->user_id}}</p></td>
        <td><p>{{$referral->referred_user_name}}</p></td>
        <td><p>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $referral->created_at)->toDateString()}}</p></td>
        <td><p><span class="badge @if($referral->status) success @else danger @endif">@if($referral->status) Verified @else Unverified @endif</span></p></td>
    </tr>
@endforeach