<section class="content">
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Seacrh for "{{$search_term}}" total {{count($cases)}} results found</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body no-padding">
        <table class="table table-striped">
            <tr>
                <th>Case #</th>
                <th>Patient name</th>
                <th>Doctor name</th>
                <th>Case Register</th>
                <th>Action</th>
            </tr>
            @foreach($cases as $case)
            <tr>
                <td>{{$case->case_number}}</td>
                <td>{{$case->patient_name}}</td>
                <td>{{$case->doctor_name}}</td>
                <td>{{$case->created_at->format('Y-m-d')}}</td>
                <td class=""><a class="case_delete" id="{{$case->id}}"> <i class="fa fa-trash-o" aria-hidden="true"></i></a> | <a href="" id="{{$case->id}}" data-toggle="modal" data-target=".bs-patient-modal-lg" class="show-patient-modal"><i class="fa fa-fw fa-list" aria-hidden="true"></i></a> </td>

            </tr>
            @endforeach

        </table>
    </div>
    <!-- /.box-body -->
</div>
    </section>