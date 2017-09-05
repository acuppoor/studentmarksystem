<div class="main-panel">
    @include('include.dashboard.nav')
    <div class="row" style="background-color: whitesmoke">
        <div class="card">
            <div class="col-md-12">
                / <a href="">Courses List</a>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="content">
                    <div class="row">
                        {{--<div style="padding-left: 2%">
                            <p>
                                <strong><h5>Filters</h5></strong>
                            </p>
                        </div>--}}
                        <div class="col-lg-3 col-sm-6">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <div class="numbers" style="text-align: left">
                                            <p>Select Year</p>
                                            <select class="form-control" style="border: 1px solid black">
                                                <option selected><?php echo(date("Y"));?></option>
                                                <?php
                                                $currentYear = (int) date("Y");
                                                for ($i = $currentYear-1; $i >= 2010; $i--){
                                                    echo('<option>'.$i.'</option>');
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <div class="numbers" style="text-align: left">
                                            <p>Select Faculty</p>
                                            <select class="form-control" style="border: solid 1px black" disabled>
                                                <option selected>Faculty of Science</option>
                                                <option>Faculty of Humanities</option>
                                                <option>Faculty of Engineering</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <div class="numbers" style="text-align: left">
                                            <p>Select Department</p>
                                            <select class="form-control" style="border: solid 1px black" disabled>
                                                <option selected>Computer Science</option>
                                                <option>Biochemistry</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-8">
                                        <div class="numbers" style="text-align: center">
                                            <p>&nbsp;</p>
                                            <button class="btn btn-danger btn-xl" type="submit">Apply Filters</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <a href="/courseconvenor/courseedit">
                            <div class="header">
                                <h4 class="title">1. CSC1016S</h4>
                                <p class="category">First Year Second Semester Computer Science</p>
                            </div>
                        </a>
                        <div class="content">
                            Some info about the course here!
                            <div class="footer">
                                <hr>
                                <table>
                                    <tr>
                                        <td>
                                            Year:
                                        </td>
                                        <td>
                                            2017
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Number of students:
                                        </td>
                                        <td>
                                            120
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Start Date:
                                        </td>
                                        <td>
                                            14th August 2017
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            End Date:
                                        </td>
                                        <td>
                                            10th November 2017
                                        </td>
                                    </tr>
                                </table>
                                <hr>
                                <div class="stats">
                                    Updated 3 minutes ago
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('include.dashboard.footer')
</div>