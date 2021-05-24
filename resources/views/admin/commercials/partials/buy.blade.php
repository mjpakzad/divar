@if($commercial->buy)
<span class="label label-success">{{ $commercial->category->sell ?? 'فروش' }}</span>
@else
<span class="label label-primary">{{ $commercial->category->buy ?? 'خرید' }}</span>
@endif