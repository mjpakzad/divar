@if ($product->special)
    <del class="text-red clearfix">{{ number_format($product->price, 0) }}</del>
    <ins class="text-green">{{ number_format($product->special, 0) }}</ins>
@else
    <span>{{ number_format($product->price, 0) }}</span>
@endif