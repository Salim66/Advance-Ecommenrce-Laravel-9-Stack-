<div class="form-group">
    <label>Select Category Level</label>
    <select class="form-control select2" name="parent_id" id="parent_id" style="width: 100%;">
        <option value="0" @if(isset($category_data->parent_id) && $category_data->parent_id == 0) selected @endif>Main Category</option>
        @if(!empty($categories))
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @if(isset($category_data->parent_id) && $category_data->parent_id == $cat->id) selected @endif>{{ $cat->category_name }}</option>
                @if(!empty($cat->sub_categories))
                    @foreach($cat->sub_categories as $subCat)
                        <option value="{{ $subCat->id }}">&nbsp;&raquo;&nbsp;{{ $subCat->category_name }}</option>
                    @endforeach
                @endif
            @endforeach
        @endif
    </select>
</div>
