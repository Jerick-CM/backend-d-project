<p>
  <table align="left" cellspacing="0" cellpadding="0" border="0" width="100%" >
      @if($RO_deduct != 0 )
      <tr>
        <td class="one-col-mobile-l" width="50%" style="border: 1px solid #ddd;float: left;padding: 10px;">
          Recognize Others Token Deduct
        </td>
        <td class="one-col-mobile-r" width="20%" style="border: 1px solid #ddd;float: left;padding: 10px;">
          {{$RO_deduct}}
        </td>
      </tr>
      @endif
      @if($RO_add != 0 )
      <tr>
        <td class="one-col-mobile-l" width="50%" style="border: 1px solid #ddd;float: left;padding: 10px;">
          Recognize Others Token Add
        </td>
        <td class="one-col-mobile-r" width="20%" style="border: 1px solid #ddd;float: left;padding: 10px;">
            {{$RO_add}}
        </td>
      </tr>
      @endif
      @if($MR_deduct != 0 )
      <tr>
        <td class="one-col-mobile-l" width="50%" style="border: 1px solid #ddd;float: left;padding: 10px;">
          My Rewards Token Deduct
        </td>
        <td class="one-col-mobile-r" width="20%" style="border: 1px solid #ddd;float: left;padding: 10px;">
            {{$MR_deduct}}
        </td>
      </tr>
      @endif
      @if($MR_add != 0 )
      <tr>
        <td class="one-col-mobile-l" width="50%" style="border: 1px solid #ddd;float: left;padding: 10px;">
          My Rewards Token Add
        </td>
        <td class="one-col-mobile-r" width="20%" style="border: 1px solid #ddd;float: left;padding: 10px;">
            {{$MR_add}}
        </td>
      </tr>
      @endif
  </table>
  <br clear="all" />
</p>
