@php
    $prefix = [
        '1' => '',
        '2' => '\____',
        '3' => '\________',
    ];
@endphp

<tr>
    <td>{{ $prefix[$category->level] }} {{ $category->title }}</td>
    <td>{{$category->slug}}</td>
    <td>{{(($category->is_parent==1)? 'Có': 'Không')}}</td>
    <td>
        {{ $category->parent_info->title ?? '' }}
    </td>
    <td>
        @if($category->status=='active')
            <span class="badge badge-success">{{ __('adm.active') }}</span>
        @else
          <span class="badge badge-warning">{{ __('adm.inactive') }}</span>
        @endif
    </td>
    <td>
        <a href="{{route('category.edit', $category->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
        <form method="POST" action="{{route('category.destroy',[$category->id])}}">
            @csrf
            @method('delete')
            <button class="btn btn-danger btn-sm dltBtn" data-id={{$category->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
        </form>
    </td>
</tr>

@if($category->child_cat->count() > 0)
    @foreach($category->child_cat as $category)
        @include('backend.category.includes.loop', ['category' => $category])
    @endforeach
@endif