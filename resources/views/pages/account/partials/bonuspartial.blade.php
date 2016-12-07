{{-- The bonus partial --}}
@if ($bonuses)
@foreach($bonuses as $bonus)
    <tr>
        <td><p>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $bonus->created_at)->toDateString()}}</p></td>
        <td><p>{{$bonus->bonus_type}}</p></td>
        <td><p>Rs. {{$bonus->bonus_amount}}</p></td>
        <td><p><span class="badge @if($bonus->status === 'pending')warning
                                            @elseif($bonus->status === 'completed')success
                                            @else danger @endif">{{ucfirst($bonus->status)}}</span></p></td>
    </tr>
@endforeach
    @else
<div>Nothing to show</div>
    @endif