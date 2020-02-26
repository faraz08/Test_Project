<ul class="" id="myUL">
    @foreach($case_numbers as $case_number)
        <li class="autocomplete" name="autocomplete">{{$case_number->case_number}}</li>
    @endforeach
</ul>
