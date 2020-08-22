@extends('layouts.main')

@section('contents')
        <div>
            <div class="card card-chart">
                <div class="card-header">
                    <h4 class="card-title">Form Data</h4>
                </div>
                <div class="card-body">
                    <div class = "table-responsive">
{{--                        <table class="table">--}}
{{--                            <thead>--}}
{{--                            <th>First Name</th>--}}
{{--                            <th>Email</th>--}}
{{--                            <th>Address</th>--}}
{{--                            <th>Resume link</th>--}}
{{--                            <th>Image</th>--}}
{{--                            <th>Image</th>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            @foreach($results as $result)--}}
{{--                            <tr>--}}
{{--                                <td>{{$result->firstname}}</td>--}}
{{--                                <td>{{$result->email}}</td>--}}
{{--                                <td>{{$result->address}}</td>--}}
{{--                                <td><a href="{{url('/uploads/'.$result->resume)}}">Click to View</a></td>--}}
{{--                                <td><img src="{{url('/uploads/'.$result->image)}}" alt="Image" width="50px" height="50px"/></td>--}}
{{--                                <td><b></td>--}}
{{--                            </tr>--}}
{{--                            @endforeach--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
                        <table id="user_table" class="table">
                            <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Resume link</th>
                                <th>Image</th>
                                <th>Notes</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div id="formModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <span id="form_result"></span>
                        <form method="post" id="sample_form" class="form-horizontal">
                            @csrf
                            <div class="form-group">
                                <label class="control-label col-md-4" >ADD NOTE : </label>
                                <div class="col-md-8">
                                    <input type="text" name="note" id="note" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4" >ADD TAGS : </label>
                                <div class="col-md-8">
                                    <input type="text" name="tags" id="tags" class="form-control" placeholder="Add tags like  apple,mango,banana" />
                                </div>
                            </div>
                            <div class="form-group" align="center">
                                <input type="hidden" name="action" id="action" value="Add" />
                                <input type="hidden" name="hidden_id" id="hidden_id" />
                                <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('scripts')
    <script>
    $(document).ready(function() {

        var id;
        $(document).on('click', '.add-note', function(){
            id = $(this).attr('id');
            $('#hidden_id').val(id);
            $('#formModal').modal('show');
        });

        $('#user_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('sample.index') }}",
            },
            columns: [
                {
                    data: 'firstname',
                    name: 'firstname'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'resume',
                    name: 'resume',
                    render: function (data) {
                        return "<a href=\"" + "uploads/"+data + "\" >Click to View </>";
                    },
                },
                {
                    data: 'image',
                    name: 'image',
                    render: function (data) {
                        return "<img src=\"" + "uploads/"+data + "\" height=\"50\"/>";
                    },
                },
                {
                    data: 'notesString',
                    name: 'notesString'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                }
            ]
        });
    });

    $('#action_button').click(function(e){
        e.preventDefault();
        var note = $('input[name=note]').val();
        var tags = $('input[name=tags]').val();
        var id = $('input[name=hidden_id]').val();
        $.ajax({
            url:"/addNote",
            method:"POST",
            data:{
                "id" : id,
                "note" : note,
                "tags" : tags,
                "_token" : "{{ csrf_token() }}"
            },
            dataType:"json",
            beforeSend:function(){
                $('#action_button').text('saving...');
            },
            success:function(data)
            {
                alert('Note Added');
                $('#formModal').modal('hide');
                $('#user_table').DataTable().ajax.reload();
            }
        })
    });
    </script>
@endsection

