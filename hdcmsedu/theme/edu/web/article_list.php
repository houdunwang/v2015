<tag action="article.pagelist" row="1" sub_category="1">
    <li class="list-group-item">
        [<a href="{{$field['category']['url']}}">{{$field['category']['catname']}}</a>]
        <a href="{{$field['url']}}">
            {{mb_substr($field['title'],0,20,'utf8')}}
        </a>
    </li>
</tag>
<tag action="article.pagination"></tag>