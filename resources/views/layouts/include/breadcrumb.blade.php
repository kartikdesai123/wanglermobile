<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        
        <h2>{{$header['title']}}</h2>

        <ol class="breadcrumb">
            @php 
            $count = count($header['breadcrumb']); 
            $temp = 1;
            @endphp 
            @foreach($header['breadcrumb'] as $key => $value)

            @php $value = (empty($value)) ? 'javascript:;' : $value; @endphp
            @if($temp!=$count)
            <li><a href="{{ $value }}" class=""> @if($temp == 1)<i class="fa fa-book"></i>@endif {{ $key }} </a></li>
            @else
            <li class="active"> {{ $key }} </li>
            @endif

            @php $temp = $temp+1; @endphp
            @endforeach
        </ol>  
    </div>
    <div class="col-lg-2">

    </div>
</div>