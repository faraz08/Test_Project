<div class="box-body form-element">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group clearfix">

                <div class="col-sm-12">
                    <label for="example-text-input" class="col-sm-10 padding">Portal ID</label>
                    <input class="form-control" type="text" name="portal" id="portal"
                           value="{{$patient['cases']->case_number}}" readonly>
                    <div id="caseNumberList"></div>
                </div>
            </div>
            <div class="form-group clearfix">

                <div class="col-sm-12">
                    <label for="example-text-input" class="col-sm-10 padding">Case ID</label>
                    <input class="form-control" type="text" name="case_number" id="case_number"
                           value="{{$patient['cases']->case_number}}" readonly>
                    <div id="caseNumberList"></div>
                </div>
            </div>
            <div class="form-group clearfix">

                <div class="col-sm-12">
                    <label for="example-text-input" class="col-sm-10 padding">Doctor</label>
                    <input class="form-control" type="text" name="doctor_name" id="doctor_name"
                           value="{{$patient['cases']->doctor_name}}" readonly>
                </div>
            </div>

            <div class="form-group clearfix">

                <div class="col-sm-12">
                    <label for="example-text-input" class="col-sm-10 padding">Patient</label>
                    <input class="form-control" type="text" name="patient_name" id="patient_name"
                           value="{{$patient['cases']->patient_name}}" readonly>
                </div>
            </div>


        </div>
        <div class="col-md-6">

            <div class="form-group clearfix">

                <div class="col-sm-12">
                    <label for="example-text-input" class="col-sm-10 padding">Portal</label>
                    <input class="form-control" type="text" name="portal" id="portal" value="{{$patient['cases']->portal->name}}" readonly>
                </div>
            </div>

            <div class="form-group clearfix">
                <div class="col-md-6">
                    <label class="col-form-label padding">Upper Aligner:
                        <span>
                            <input class="form-control" type="text" name="" id="" value="{{$patient->upper_aligner}}"
                                   readonly>
                        </span>
                    </label>
                </div>

                <div class="col-md-6">
                    <label class="col-form-label padding" style="display: block">Lower Aligner : <span>
                            <input class="form-control" type="text" name="" id="" value="{{$patient->lower_aligner}}"
                                   readonly>
                        </span>
                    </label>
                </div>
            </div>

            <div class="form-group clearfix">

                <div class="col-sm-12">
                    <label for="example-text-input" class="col-sm-10 padding">Operator name</label>
                    <input class="form-control" type="text" name="operator_name" value="{{$patient->operator->name}}"
                           readonly>
                </div>
            </div>

            <div class="form-group clearfix">

                <div class="col-sm-12">
                    <label for="example-text-input" class="col-sm-10 padding">URL</label>
                    <input type="text" class="form-control" value="{{$patient->url}}">
                </div>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-md-12">
            <div class="col-md-4">

                <div class="input-group input-group-sm">
                    <label for="example-text-input" class="padding">Files Before</label>

                    @foreach($beforeFiles as $key => $value)
                        <a href="{{url($pathToStoreFileBefore.'/'.str_replace('"', "", $value))}}"><p
                                class="text-aqua">{{str_replace('"', "", $value)}}</p></a>
                    @endforeach

                </div>

            </div>

            <div class="col-md-4">

                <div class="input-group input-group-sm">

                    <label for="example-text-input" class="padding">Files After</label>
                    @foreach($afterFiles as $key => $value)
                        <a href="{{url($pathToStoreFileAfter.'/'.str_replace('"', "", $value))}}"><p
                                class="text-aqua">{{str_replace('"', "", $value)}}</p></a>
                    @endforeach

                </div>

            </div>

            <div class="col-md-4">

                <div class="input-group input-group-sm">

                    <label for="example-text-input" class="padding">IPR Form</label>
                    <a href="{{url('public/cases/'.$patient['cases']->case_number.'/ipr_form/'.$patient->revisions.'/'.$patient->ipr_form)}}"
                       target="_blank"><p class="text-aqua">IPR From</p></a>

                </div>

            </div>
        </div>

    </div>
    <!-- /.row -->
</div>

<!-- /.box-body -->



