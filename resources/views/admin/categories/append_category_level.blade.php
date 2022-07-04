<div class="form-group">
    <label>Select Category Level</label>
    <select class="form-control select2" name="parent_id" id="parent_id" style="width: 100%;">
        <option value="0">Main Category</option>
        @if(!empty($categories))
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                @if(!empty($category->sub_categories))
                    @foreach($category->sub_categories as $subCat)
                        <option value="{{ $subCat->id }}">&nbsp;&raquo;&nbsp;{{ $subCat->category_name }}</option>
                    @endforeach
                @endif
            @endforeach
        @endif
    </select>
</div>
