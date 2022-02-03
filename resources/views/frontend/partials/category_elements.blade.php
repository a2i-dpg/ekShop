<ul class="sub-menu-ul">
    @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($category->id) as $key => $first_level_id)
    <li class="sub-menu-ul-li border hover-shadow">
        <a class="sub-menu-ul-li-a text-truncate text-reset py-2 px-3 d-block" href="{{ route('products.category', \App\Models\Category::find($first_level_id)->slug) }}">{{ \App\Models\Category::find($first_level_id)->getTranslation('name') }}</a>
    </li>
    @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($first_level_id) as $key => $second_level_id)
        <li class="sub-menu-ul-li border hover-shadow">
            <a class="sub-menu-ul-li-a text-truncate text-reset py-2 px-3 d-block" href="{{ route('products.category', \App\Models\Category::find($second_level_id)->slug) }}">{{ \App\Models\Category::find($second_level_id)->getTranslation('name') }}</a>
        </li>
    @endforeach
    @endforeach
</ul>
