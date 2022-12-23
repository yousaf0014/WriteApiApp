<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="http://backend.writeme.ai/backend/storage/LOGO_FINAL.png"  class="logo" alt="Writeme.ai Logo" style="width:200px!important;height:40px !important">
@else
<img src="http://backend.writeme.ai/backend/storage/LOGO_FINAL.png" class="logo" alt="Writeme.ai Logo" style="width:200px !important;height:40px !important">
<?php $slot ?>
@endif
</a>
</td>
</tr>
