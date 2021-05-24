<form method="post" action="{{ route('admin.products.destroy', $product->slug) }}" style="display: inline-block;">
    @csrf
    @method('DELETE')
    <a href="{{ route('admin.products.edit', $product->slug) }}" class="btn btn-primary btn-xs">
        <span class="fa fa-pencil"></span> ویرایش
    </a>
    <button type="submit" name="delete" class="btn btn-danger btn-xs" onclick="return confirm('آیا از حذف این محصول اطمینان دارید؟');">
        <span class="fa fa-trash"></span> حذف
    </button>
</form>
