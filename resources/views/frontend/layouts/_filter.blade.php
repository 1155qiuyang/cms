
@if (@isset($category_lists))
    
<ul class="nav nav-tabs" id="myTab" role="tablist">
    @foreach ($category_lists as $category)

    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#hello" role="table">{{$category->title}}</a>
    </li>
        
    @endforeach
</ul>
    
@endif
