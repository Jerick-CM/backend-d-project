<p>
  <table align="left" cellspacing="0" cellpadding="0" border="0" width="100%">
    @foreach ($orderItems as $item)
        <tr>
          <td class="one-col-mobile-l" width="25%" style="float: left;padding: 10px;">
            <img class="one-col-mobile-l-img" src="{{$item['inventory']->primary_photo->file}}" width="120" style="width: 120px;" />
          </td>
          <td class="one-col-mobile-r" width="65%" style="float: right;padding: 15px 10px 0px 10px;">
            Product: {{ $item['inventory']->name }}
            <br>
            Quantity: {{ $item['quantity'] }}
            <br>
            Tokens used: {{ $item['tokens'] }}
          </td>
        </tr>
    @endforeach
  </table>
  <br clear="all" />
</p>
