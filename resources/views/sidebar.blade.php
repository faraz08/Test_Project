<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <div class="sidebar-form">
            <div class="" id="">
                <div class="input-group">
                    <input type="text" name="typeahead" class="form-control typeahead" id="typeahead"
                           placeholder="Search...">

                    <span class="input-group-btn">
                    <button type="button" name="search" id="srchTxt_btn1" class="btn btn-flat"><i
                            class="fa fa-search"></i>
                    </button>
                    </span>
                </div>

            </div>
            <div id="searchResult"></div>
        </div>

        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>

            <li class="{{route('dashboard') == Request::url() ? 'active' : ''}}">
                <a href="{{route('dashboard')}}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>

            </li>
            @role(['admin', 'operator'])
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-edit"></i> <span>Cases</span>
                    <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>

                <ul class="treeview-menu">

                    {{--                    @permission('create')--}}
                    {{--                    <li class="{{route('create-case') == Request::url() ? 'active' : ''}}"><a--}}
                    {{--                            href="{{route('create-case')}}"><i class="fa fa-circle-o"></i> Create Case</a></li>--}}
                    {{--                    @endpermission--}}
                    @can('create-case')
                        <li class="{{route('create-case') == Request::url() ? 'active' : ''}}"><a
                                href="{{route('create-case')}}"><i class="fa fa-circle-o"></i> Create Case</a></li>
                    @endcan
                    @permission('read')
                    <li class="{{route('case-list') == Request::url() ? 'active' : ''}}"><a
                            href="{{route('case-list')}}"><i class="fa fa-circle-o"></i> Case List</a></li>
                    @endpermission

                </ul>

            </li>
            @endrole
            <li class="{{route('users') == Request::url() ? 'active' : ''}}">
                <a href="{{route('users')}}">
                    <i class="fa fa-user"></i> <span>Users</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
    <div class="sidebar-footer">
        <!-- item-->
        <a href="" onClick="window.location.href=window.location.href" class="link" data-toggle="tooltip" title=""
           data-original-title="Settings"><i class="fa fa-cog fa-spin"></i></a>
        <!-- item-->
        <a href="{{ route('logout') }}" onclick="event.preventDefault();
         document.getElementById('logout-form').submit();" class="link" data-toggle="tooltip" title=""
           data-original-title="Logout"><i class="fa fa-power-off"></i></a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</aside>



@section('typeahead-script')

    <script type="text/javascript">


        //        $(document).ready(function(){
        //
        //            // Defining the local dataset
        //            var cars = ['Audi','Audgi','Aufdi','Aufdgdi', 'BMW', 'Bugatti', 'Ferrari', 'Ford', 'Lamborghini', 'Mercedes Benz', 'Porsche', 'Rolls-Royce', 'Volkswagen'];
        //
        //            // Constructing the suggestion engine
        //            var cars = new Bloodhound({
        //                datumTokenizer: Bloodhound.tokenizers.whitespace,
        //                queryTokenizer: Bloodhound.tokenizers.whitespace,
        //                local: cars
        //            });
        //
        //            // Initializing the typeahead
        //            $('#bloodhound .typeahead').typeahead({
        //                        hint: true,
        //                            highlight: true, /* Enable substring highlighting */
        //                            minLength: 1 /* Specify minimum characters required for showing suggestions */
        //                },
        //                    {
        //                        name: 'cars',
        //                        source: cars
        //                    });
        //
        //        });


        {{--var path = "{{ route('search-case-by-number') }}";--}}

        {{--$('input.typeahead').typeahead({--}}
        {{----}}
        {{--hint: true,--}}
        {{--highlight: true, /* Enable substring highlighting */--}}
        {{--minLength: 1, /* Specify minimum characters required for showing suggestions */--}}


        {{--source:  function (query, process) {--}}
        {{--console.log(query);--}}
        {{--return $.get(path, { query: query }, function (data) {--}}

        {{--console.log(data);--}}
        {{--return process(data);--}}
        {{--});--}}
        {{--}--}}
        {{--});--}}




        {{--$(document).ready(function(){--}}

        {{--function getData(callback){--}}

        {{--$('#typeahead').keyup(function(event ) {--}}

        {{--var input = this.value;--}}
        {{--event.preventDefault();--}}
        {{--$.ajaxSetup({--}}
        {{--headers: {--}}
        {{--'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')--}}
        {{--}--}}
        {{--});--}}
        {{--$.ajax({--}}
        {{--url: "{{ url('search-case-by-number') }}",--}}
        {{--method: 'POST',--}}
        {{--data: {"_token": "{{ csrf_token() }}", input: input},--}}
        {{--success: callback--}}
        {{--});--}}
        {{--});--}}
        {{--}--}}

        {{--getData(function(response){--}}
        {{--var cars = ['Audi', 'BMW', 'Bugatti', 'Ferrari', 'Ford', 'Lamborghini', 'Mercedes Benz', 'Porsche', 'Rolls-Royce', 'Volkswagen'];--}}
        {{--console.log(cars);--}}
        {{--console.log(response);--}}

        {{--var cases = new Bloodhound({--}}
        {{--datumTokenizer: Bloodhound.tokenizers.whitespace,--}}
        {{--queryTokenizer: Bloodhound.tokenizers.whitespace,--}}
        {{--//                    local: response--}}
        {{--prefetch: '{{ url('search-case-by-number') }}'--}}
        {{--});--}}

        {{--$('#typeahead').typeahead({--}}
        {{--hint: true,--}}
        {{--highlight: true,--}}
        {{--minLength: 1--}}
        {{--},--}}
        {{--{--}}
        {{--name: 'typeahead',--}}
        {{--source: response--}}
        {{--});--}}
        {{--});--}}

        {{--});--}}



        {{--$(document).ready(function(){--}}


        {{--// Constructing the suggestion engine--}}
        {{--var typeahead = new Bloodhound({--}}

        {{--datumTokenizer: Bloodhound.tokenizers.whitespace,--}}
        {{--queryTokenizer: Bloodhound.tokenizers.whitespace,--}}
        {{--prefetch: '{{ url('search-case-by-number') }}'--}}
        {{--});--}}

        {{--alert('hi');--}}
        {{--// Initializing the typeahead--}}
        {{--$('#typeahead').typeahead({--}}
        {{--hint: true,--}}
        {{--highlight: true,--}}
        {{--minLength: 1--}}
        {{--},--}}
        {{--{--}}
        {{--name: 'typeahead',--}}
        {{--source: typeahead--}}
        {{--});--}}

        {{--});--}}


    </script>
@endsection
