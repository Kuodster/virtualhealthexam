@extends('layouts.default')

@push('scripts')
    <script type="text/javascript">
		$(function () {
			$('.show-entries').bind('click', function (e) {
				e.preventDefault();
				var ele = $(this);
				var entries = ele.next('.entries');
				if (entries !== undefined) {
					entries.slideToggle(function () {
						if (entries.is(':visible'))
							ele.parents('tr').addClass('bg-orange-100');
						else
							ele.parents('tr').removeClass('bg-orange-100');
					});
				}
			});
		});
    </script>
@endpush

@section('content')
    @if( empty($data) )
        <div>No items to display</div>
    @else
        <table class="table-auto w-full table-bordered">
            <thead>
            <tr class="border-b border-gray-400">
                @foreach(array_keys($data[0]) as $title)
                    <th>
                        @if( isset($sort) && $sort->hasSort($title) )
                            @php
                                /* @var $sort \App\Models\Sort */
                                $order = $sort->isSorting($title);

                                $query = [];
                                if( $order === 'desc' ) {
                                // unset sort after ASC
                                    $query['sort'] = null;
                                    $query['order'] = null;
                                } else {
                                    $query['sort'] = $title;
                                    $query['order'] = $order === null?'asc': ($order === 'asc'?'desc':'asc');
                                }
                            @endphp
                            <a href="{{request()->fullUrlWithQuery(array_merge(request()->query(), $query))}}"
                               class="text-blue-500">
                                {{$title}}
                                {!! $order === null ? '&varr;': ($order === 'asc'?'&darr;':'&uarr;') !!}
                            </a>
                        @else
                            {{$title}}
                        @endif
                    </th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach( $data as $item )
                <tr class="text-center border-b border-gray-200 align-top">
                    @foreach( $item as $value )
                        <td>
                            @if( is_array($value) )
                                @if( !count($value) )
                                    ---
                                @else
                                    <a href="javascript:;" class="text-blue-500 show-entries">{{count($value)}}
                                        entry</a>
                                    <div class="entries hidden">
                                        @foreach( $value as $val )
                                            {{$val}}<br/>
                                        @endforeach
                                    </div>
                                @endif
                            @else
                                {{$value}}
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="paginator">
            {{$paginator->appends(\Illuminate\Support\Facades\Input::except('page'))->links()}}
        </div>
    @endif
@stop