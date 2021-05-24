@forelse($fields as $field)
    @switch($field->type)
        @case('text')
            <div class="form-group">
                <label for="field{{ $loop->iteration }}" class="control-label col-md-3 col-sm-3 col-xs-12">{{ $field->label }}</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="fields[{{ $field->id }}]" id="field{{ $loop->iteration }}" class="form-control" placeholder="{{ $field->placeholder }}" value="{{ old('fields.' . $field->id, $field->value ?? '') ?? '' }}">
                </div>
            </div>
            @break
        @case('select')
            <div class="form-group">
                <label for="field{{ $loop->iteration }}" class="control-label col-md-3 col-sm-3 col-xs-12">{{ $field->label }}</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="fields[{{ $field->id }}]" id="field{{ $loop->iteration }}" class="form-control" dir="rtl">
                    @foreach($field->options as $option)
                        <option value="{{ $option }}"{{ old('fields.' . $field->id, $field->value ?? '') == $option ? ' selected' : '' }}>{{ $option }}</option>
                    @endforeach
                    </select>
                </div>
            </div>
            @break
        @case('checkbox')
            <div class="form-group">
                <label for="featured" class="control-label col-md-3 col-sm-3 col-xs-12">{{ $field->label }}</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="fields[{{ $field->id }}]" id="field{{ $loop->iteration }}" value="1" class="flat"{{ (old('fields' . $field->id) ? ' checked' : '') }}>
                        </label>
                    </div>
                </div>
            </div>
            @break
        @endswitch
@empty
    <span class="text-info">این دسته‌بندی فاقد فیلد است.</span>
@endforelse