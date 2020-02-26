<section class="content">

    <div class="col-md-12">

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Search Results For "{{$cases->case_number}}"</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th>Case no.</th>
                        <th>Patient name</th>
                        <th>Create at</th>
                        <th>Doctor</th>
                        <th>Details</th>
                    </tr>
                    <tr>

                        <td>{{$cases->case_number}}</td>
                        <td>{{$cases->patient_name}}</td>
                        <td>{{$cases->created_at}}</td>
                        <td>{{$cases->doctor_name}}</td>

                        <td><a href="" id="{{$cases->id}}" data-toggle="modal"
                               data-target=".bs-patientt-modal-lg"
                               class="show-patient-modal">
                                <i class="fa fa-fw fa-list" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>


</section>
