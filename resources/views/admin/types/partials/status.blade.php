@if($commercial->status == 0)
<span class="label label-primary">منتظر تایید</span>
@elseif($commercial->status == 1)
<span class="label label-success">تایید شده</span>
@elseif($commercial->status == 2)
<span class="label label-danger">رد شده</span>
@endif