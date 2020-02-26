<form method="post" enctype="multipart/form-data" id="case-form" action="">
    @csrf

    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group clearfix">
                    <label for="example-text-input" class="col-sm-2 col-form-label">Case ID</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="case_number" id="case_number"
                               value="{{$patient['cases']->case_number}}" readonly>
                        <div id="caseNumberList"></div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label for="example-text-input" class="col-sm-2 col-form-label">Patient</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="patient_name" id="patient_name"
                               value="{{$patient['cases']->patient_name}}" readonly>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label for="example-text-input" class="col-sm-2 col-form-label">Doctor</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="doctor_name" id="doctor_name"
                               value="{{$patient['cases']->doctor_name}}" readonly>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label for="example-text-input" class="col-sm-2 col-form-label">Portal</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="portal" id="portal" value="no column in database">
                    </div>
                </div>
                <div class="form-group">
                    <label for="example-text-input" class="col-sm-2 col-form-label">File Before</label>
                    <div class="col-sm-3">
                        <input type="file" id="exampleInputFile" name="file_before[]" multiple>
                    </div>
                </div>
                <div class="form-group">
                    <label for="example-text-input" class="col-sm-2 col-form-label">File After</label>
                    <div class="col-sm-3">
                        <input type="file" id="exampleInputFile" name="file_after[]" multiple>
                    </div>
                </div>
            </div>
            <div class="col-md-6">

                <div class="form-group clearfix">
                    <label for="example-text-input" class="col-sm-2 col-form-label">Operator name</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="operator_name"
                               value="{{$patient->operator_name}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="example-text-input" class="col-sm-2 col-form-label">Upper Aligner</label>
                    <div class="col-sm-3">
                        <input type="number" id="exampleInputFile" name="upper_aligner"
                               value="{{$patient->upper_aligner}}">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label for="example-text-input" class="col-sm-2 col-form-label">Lower Aligner</label>
                    <div class="col-sm-3">
                        <input type="number" id="exampleInputFile" name="lower_aligner"
                               value="{{$patient->lower_aligner}}">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label for="example-text-input" class="col-sm-2 col-form-label">IPR Form</label>
                    <div class="col-sm-10">
                        <input type="file" id="exampleInputFile" name="ipr_form">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label for="example-month-input" class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-3">
                        <select class="form-control" name="status">
                            <option
                                value="Pending for approval" {{($patient->status == 'Pending for approval') ? 'active': ''}}>
                                Pending for approval
                            </option>
                            <option
                                value="Request for modification" {{($patient->status == 'Pending for approval') ? 'active': ''}}>
                                Request for modification
                            </option>
                            <option
                                value="Modification uploaded" {{($patient->status == 'Pending for approval') ? 'active': ''}}>
                                Modification uploaded
                            </option>
                        </select>
                    </div>
                </div>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>

    <div class="box-footer">
        <button type="submit" class="btn btn-info pull-right">Submit Case</button>
    </div>
    <!-- /.box-body -->
</form>



