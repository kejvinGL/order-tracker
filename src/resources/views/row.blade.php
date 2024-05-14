<tr>
    <td class="text-[10px] text-nowrap">
        {{ $order->name}}
    </td>
    <td class="text-[10px] text-nowrap">
        {{ $order->email}}
    </td>
    <td class="text-[10px] text-nowrap">
        {{ $order->product}}
    </td>
    <td class="text-[10px] text-nowrap">
        {{ $order->external_id}}
    </td>
    <td class="text-[10px] text-nowrap">
        {{ $order->price}}
</td>
    <td class="text-[10px] text-nowrap">
        {{ $order->status}}
    </td>
    <td class="text-[10px] text-nowrap">
        {{ $order->error_message ?? '_'}}
    </td>
    <td class="text-[10px] text-nowrap">
        {{$order->updated_at->format('d/m/y@H:i')}}
    </td>
    <td class="text-[10px] text-nowrap">
        {{$order->updated_at->format('d/m/y @ H:i')}}
    </td>
</tr>
