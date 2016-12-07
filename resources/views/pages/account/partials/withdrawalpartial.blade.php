@foreach($withdrawals as $withdrawal)
    <tr>
        <td><p>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $withdrawal->created_at)->toDateString()}}</p></td>
        <td><p>{{strtoupper($withdrawal->withdrawal_channel)}}</p></td>
        <td><p>Rs. {{$withdrawal->amount}}</p></td>
        <td><p>@if ($withdrawal->bank_reference_number) {{strtoupper($withdrawal->bank_reference_number)}} @else Pending @endif</p></td>
        <td><p><span class="badge @if($withdrawal->status === 'pending')warning
                                            @elseif($withdrawal->status === 'completed')success
                                            @else danger @endif">{{ucfirst($withdrawal->status)}}</span></p></td>
    </tr>
@endforeach

{{-- Generate Hidden Pagination Link --}}
<tr>
    <td class="hidden"><a class="prev-link" href="{{$withdrawals->previousPageUrl()}}"></a></td>
    <td class="hidden"><a class="next-link" href="{{$withdrawals->nextPageUrl()}}"></a></td>
</tr>