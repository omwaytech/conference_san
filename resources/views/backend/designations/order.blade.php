<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('plugin-links')}}/bootstrap.min.css"/>
    <link rel="stylesheet" href="{{asset('backend')}}/dist-assets/css/plugins/datatables.min.css"/>
    <link rel="stylesheet" href="{{asset('plugin-links')}}/font-awesome-4.7.0/css/font-awesome.min.css"/>
    <title>Dashboard | Update Order </title>
</head>

<body>
<div class="row mt-5">
    <div class="col-md-10 offset-md-1">
        <h3 class="text-center mb-4">Update Designation Order Number</h3>
        {{-- <h5>Drag and Drop the table rows and <button class="btn btn-success btn-sm" onclick="window.location.reload()">REFRESH</button></h5>
        <a href="{{route('designation.index')}}" class="btn btn-danger btn-sm">Go Back</a> --}}
        <div class="d-flex justify-content-between align-items-center">
            <h5>Drag and Drop the table rows and <button class="btn btn-success btn-sm" onclick="window.location.reload()">REFRESH</button></h5>
            <a href="{{ route('designation.index') }}" class="btn btn-danger btn-sm">Go Back</a>
        </div>
        <table id="table" class="table table-bordered">
            <thead>
            <tr>
                <th width="30px">#</th>
                <th>Title</th>
                <th>Order No</th>
            </tr>
            </thead>
            <tbody id="tablecontents">
            @foreach($designations as $post)
                <tr class="row1" data-id="{{ $post->id }}">
                    <td class="pl-3"><i class="fa fa-sort"></i></td>
                    <td>{{ $post->designation }}</td>
                    <td>{{ $post->order_no }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <hr>
    </div>
</div>

<script src="{{asset('backend')}}/dist-assets/js/plugins/jquery-3.3.1.min.js"></script>
<script src="{{asset('plugin-links')}}/jquery-ui.min.js"></script>
<script src="{{asset('backend')}}/dist-assets/js/plugins/datatables.min.js"></script>
<script type="text/javascript">
    $(function () {
        $("#table").DataTable();

        $( "#tablecontents" ).sortable({
            items: "tr",
            cursor: 'move',
            opacity: 0.6,
            update: function() {
                sendOrderToServer();
            }
        });

        function sendOrderToServer() {
            var order = [];
            var token = $('meta[name="csrf-token"]').attr('content');
            $('tr.row1').each(function(index,element) {
                order.push({
                    id: $(this).attr('data-id'),
                    position: index+1
                });
            });

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('designation.orderSubmit') }}",
                data: {
                    order: order,
                    _token: token
                },
                success: function(response) {
                    if (response.status == "success") {
                        console.log(response);
                    } else {
                        console.log(response);
                    }
                }
            });
        }
    });
</script>
