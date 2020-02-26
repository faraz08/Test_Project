<table class="table table-condensed"  id="myPatientTable">
    <thead>
    <tr>
        <th>Revision #</th>
        <th>No. of Upper Aligners</th>
        <th>No. of Lower Aligners</th>
        <th>Operator</th>
        <th>Portal</th>
{{--        <th>Status</th>--}}
        <th>Actions</th>
    </tr>
    </thead>
    <tbody class="panel">

        @foreach($patients as $patient)
            <div id="{{$patient->id}}" class="collapse">
                <tr>

                    <td class="hiddenRow"><div>Rev{{$patient->revisions}}</div></td>
                    <td class="hiddenRow"><div>{{$patient->upper_aligner}}</div></td>
                    <td class="hiddenRow"><div>{{$patient->lower_aligner}}</div></td>
                    <td class="hiddenRow"><div>{{$patient->operator->name}}</div></td>
                    <td class="hiddenRow"><div>{{$portal->name}}</div></td>
{{--                    <td class="hiddenRow"><div>{{$patient->status}} </div></td>--}}
                    <td class="hiddenRow">
                        <div>
                        <a class="case_edit" href="{{url('patient-case-edit'.'/'.$patient->id)}}" id="{{$patient->id}}"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        |
                         <a href="" data-toggle="modal" data-target=".bs-show-modal-lg" class="show-modal" data-backdrop="static" data-keyboard="false" id="{{$patient->id}}"> <i class="fa fa-fw fa-list" aria-hidden="true"></i> </a> | <a href="" data-toggle="modal" data-target=".bs-example-modal-lg" class="model_img" id="{{$patient->id}}"></a>  <a href="" class="delete" id="{{$patient->id}}"> <i class="fa fa-trash-o" aria-hidden="true"></i> </a></div></td>

                </tr>
            </div>
        @endforeach


    </tbody>
</table>
