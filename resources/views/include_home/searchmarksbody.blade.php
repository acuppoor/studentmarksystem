@php ($courseCount = count($courses))
<h4>Results: {{$courseCount <= 0? 'None Found!':''}}</h4>
@php ($counter = 0)
@for($j = 0; $j < $courseCount; $j++)
    <div class="row">
        @php($counter++)
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <div class="row">
                        <div class="col-md-8">
                            <h2><?=($j+1) . '. ' . $courses[$j]['courseName']. ' (' . $courses[$j]['year'] .')'?></h2>
                        </div>
                        <div class="col-md-3" style="text-align: right">
                            <h4><i>Final Grade: {{$courses[$j]['final_mark']}}</i></h4>
                        </div>
                        <div class="col-md-1">
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content collapse">
                    <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                        @php ($courseworks = $courses[$j]['courseworks'])

                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel">
                                    <a class="panel-heading collapsed" role="tab" id="headingOne{{$counter}}" data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{$counter}}" aria-expanded="false" aria-controls="collapseOne{{$counter}}">
                                        {{--<h4 class="panel-title">Final Mark <i class="fa fa-angle-double-down" style="text-align: right"></i></h4>--}}
                                        <h4 class="panel-title">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    Final Mark
                                                </div>
                                                <div class="col-md-6" style="text-align: right">
                                                    <i class="fa fa-angle-double-down" style="text-align: right"></i>
                                                </div>
                                            </div>
                                        </h4>
                                    </a>
                                    <div id="collapseOne{{$counter}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne{{$counter}}" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <h3>Result: {{$courses[$j]['final_mark']}}</h3>
                                            <br>
                                            <h5>Marks Breakdown:</h5>
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Coursework</th>
                                                    <th>Marks</th>
                                                    <th>Marks(%)</th>
                                                    <th>Weighted Marks</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($courseworks as $coursework)
                                                    <tr>
                                                        <td>{{$coursework['name']}}</td>
                                                        <td>{{$coursework['total_marks']}} / 100</td>
                                                        <td>{{$coursework['total_marks']}}</td>
                                                        <td>{{$coursework['weighted_mark_year']}} / {{$coursework['weighting_yearmark']}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel">
                                    <a class="panel-heading collapsed" role="tab" id="headingTwo{{$counter}}" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo{{$counter}}" aria-expanded="false" aria-controls="collapseTwo{{$counter}}">
                                        {{--<h4 class="panel-title">DP Status</h4>--}}
                                        <h4 class="panel-title">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    DP Status
                                                </div>
                                                <div class="col-md-6" style="text-align: right">
                                                    <i class="fa fa-angle-double-down" style="text-align: right"></i>
                                                </div>
                                            </div>
                                        </h4>
                                    </a>
                                    <div id="collapseTwo{{$counter}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo{{$counter}}" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <h3>Result: {{$courses[$j]['dp_status']}}</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel">
                                    <a class="panel-heading collapsed" role="tab" id="headingThree{{$counter}}" data-toggle="collapse" data-parent="#accordion" href="#collapseThree{{$counter}}" aria-expanded="false" aria-controls="collapseThree{{$counter}}">
                                        {{--<h4 class="panel-title">Class Record</h4>--}}
                                        <h4 class="panel-title">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    Class Record
                                                </div>
                                                <div class="col-md-6" style="text-align: right">
                                                    <i class="fa fa-angle-double-down" style="text-align: right"></i>
                                                </div>
                                            </div>
                                        </h4>
                                    </a>
                                    <div id="collapseThree{{$counter}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree{{$counter}}" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <h3>Result: <?=$courses[$j]['class_mark']?></h3>
                                            <br>
                                            <h5>Marks Breakdown:</h5>
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Coursework</th>
                                                    <th>Marks</th>
                                                    <th>Marks(%)</th>
                                                    <th>Weighted Marks</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($courseworks as $coursework)
                                                    <tr>
                                                        <td>{{$coursework['name']}}</td>
                                                        <td>{{$coursework['total_marks']}} / 100</td>
                                                        <td>{{$coursework['total_marks']}}</td>
                                                        <td>{{$coursework['weighted_mark_class']}} / {{$coursework['weighting_classrecord']}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                @foreach($courseworks as $key=>$coursework)
                                    <div class="panel">
                                        <a class="panel-heading collapsed" role="tab" id="headingFour{{$counter.str_replace(' ', '', $coursework['name'])}}" data-toggle="collapse" data-parent="#accordion" href="#collapseFour{{$counter.str_replace(' ', '', $coursework['name'])}}" aria-expanded="false" aria-controls="collapseFour{{$counter.str_replace(' ', '', $coursework['name'])}}">
                                            <h4 class="panel-title">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        {{$coursework['name']}}
                                                    </div>
                                                    <div class="col-md-6" style="text-align: right">
                                                        <i class="fa fa-angle-double-down" style="text-align: right"></i>
                                                    </div>
                                                </div>
                                            </h4>

                                        </a>
                                        <div id="collapseFour{{$counter.str_replace(' ', '', $coursework['name'])}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour{{$counter.str_replace(' ', '', $coursework['name'])}}" aria-expanded="false" style="height: 0px;">
                                            <div class="panel-body">
                                                <h3>Result: <?=$coursework['total_marks']?></h3>
                                                <br>
                                                <h5>Marks Breakdown:</h5>
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Marks</th>
                                                        <th>Weighted Marks</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($coursework['subcourseworks'] as $subcoursework)
                                                        <tr>
                                                            <td scope="row">{{$subcoursework['name']}}</td>
                                                            <td>
                                                                <table>
                                                                    <tr>
                                                                        <td><strong>Total:</strong> </td>
                                                                        <td>{{$subcoursework['numerator']}} / {{$subcoursework['denominator']}}</td>
                                                                    </tr>
                                                                    @foreach($subcoursework['sections'] as $section)
                                                                        <tr>
                                                                            <td><strong>{{$section['name']}}:&nbsp;</strong></td>
                                                                            <td>{{$section['marks']}} / {{$section['max_marks']}}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </table>
                                                            </td>
                                                            <td>{{$subcoursework['weighted_marks']}} / {{$subcoursework['weighting']}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endfor