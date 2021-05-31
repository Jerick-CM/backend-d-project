<p>
    <table align="left" cellspacing="0" cellpadding="5" border="0" width="100%" style="padding: 0px 20px 0px 20px;">
      <tr>
        <td class="one-col-mobile" style="width: 45%; float: left; border: 1px solid #999999; padding: 0px;">
          <table align="left" cellspacing="0" cellpadding="0" border="0" width="100%">
            <tr>
              <td style="padding: 10px 10px 10px 10px;">
                <b style="font-family: Calibri, Geneva, Tahoma, sans-serif">Received badges this month </b>
              </td>
            </tr>

            <tr style="border-top: 1px solid #999999;">
              <td>
                <table align="left" cellspacing="0" cellpadding="0" border="0" width="100%">
                  
                  @if ($badgesTotalReceived)
                    @foreach ($badges as $badge)
                      @if ($badge->received)
                        <tr style="border-bottom: 1px solid #999999;">
                          <td class="one-col-mobile-l" width="25%" style="float: left;padding: 10px;">
                            <img class="one-col-mobile-l-img" src="{{$badge->image_url}}" width="75" style="width: 75px;" />
                          </td>
                          <td class="one-col-mobile-r" width="55%" style="float: right;padding: 20px 10px 0px 10px;">

                            @if (strtolower($badge->name) == 'worldclass citizen')
                              World<em>Class</em> Citizen
                            @else
                            {{ $badge->name }}
                            @endif
                            <br>
                            Count: {{ $badge->received ? $badge->received : 0 }}
                          </td>
                        </tr>
                      @endif
                    @endforeach
                  @else
                    <tr style="border-bottom: 1px solid #999999;">
                      <td class="one-col-mobile-l" width="25%" style="float: left;padding: 10px;">0</td>
                    </tr>
                  @endif
                </table>
              </td>
            </tr>
          </table>
        </td>

        <td class="one-col-mobile" style="width: 45%; float: right; border: 1px solid #999999; padding: 0px;">
          <table style="font-family: Calibri, Geneva, Tahoma, sans-serif" align="left" cellspacing="0" cellpadding="0" border="0" width="100%">
            <tr>
              <td style="padding: 10px 10px 10px 10px;">
                <b style="font-family: Calibri, Geneva, Tahoma, sans-serif">Shared badges this month</b>
              </td>
            </tr>

            <tr style="border-top: 1px solid #999999;">
              <td>
                <table style="font-family: Calibri, Geneva, Tahoma, sans-serif" align="left" cellspacing="0" cellpadding="0" border="0" width="100%">
                  @if ($badgesTotalSent)
                    @foreach ($badges as $badge)
                      @if ($badge->sent)
                        <tr style="border-bottom: 1px solid #999999;">
                          <td class="one-col-mobile-l" width="25%" style="float: left;padding: 10px;">
                            <img class="one-col-mobile-l-img" src="{{$badge->image_url}}" width="75" style="width: 75px;" />
                          </td>
                          <td class="one-col-mobile-r" width="55%" style="float: right;padding: 20px 10px 0px 10px;">
                            @if (strtolower($badge->name) == 'worldclass citizen')                            
                              World<em>Class</em> Citizen
                            @else
                            {{ $badge->name }}
                            @endif
                            <br>
                            Count: {{ $badge->sent ? $badge->sent : 0 }}
                          </td>
                        </tr>
                      @endif
                    @endforeach
                  @else
                    <tr style="border-bottom: 1px solid #999999;">
                      <td class="one-col-mobile-l" width="25%" style="float: left;padding: 10px;">0</td>
                    </tr>
                  @endif
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

  </p>