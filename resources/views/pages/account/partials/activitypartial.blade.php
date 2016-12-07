@foreach($activities as $activity)
    <tr>
        <td><p>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $activity->created_at)->toDateString()}}</p></td>
        <td><p>{{$activity->merchant_name}}</p></td>
        <td><p>Rs. {{$activity->estimated_cashback}}</p></td>
        <td><p><span class="badge @if($activity->status === 'pending')warning
                                            @elseif($activity->status === 'completed')success
                                            @else danger @endif">{{ucfirst($activity->status)}}</span></p></td>
    </tr>
@endforeach

{{-- Generate Hidden Pagination Link --}}
<tr>
    <td class="hidden"><a class="prev-link" href="{{$activities->previousPageUrl()}}"></a></td>
    <td class="hidden"><a class="next-link" href="{{$activities->nextPageUrl()}}"></a></td>
</tr>
