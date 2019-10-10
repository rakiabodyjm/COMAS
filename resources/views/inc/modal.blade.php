<div class="modal fade" id="employee">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add Employee</h3>
            </div>
            <div class="modal-body">
                <form method="post" action="{{action('EmployeesController@store')}}">
                    @csrf
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" placeholder="Last Name" value=""
                                    name="lastname">
                            </div>

                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" placeholder="First Name" value=""
                                    name="firstname">
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" placeholder="Address" value="" name="address">
                            </div>

                            <div class="form-group">
                                <label>Contact Number</label>
                                <input type="text" class="form-control" placeholder="Contact Number" value=""
                                    name="phoneno">
                            </div>

                            <div class="form-group">
                                <label>Skill Assignment</label>
                                <select class="form-control" name="skill" id="skill">
                                    @foreach($skills as $skill)
                                    <option value="{{$skill->skillid}}">{{$skill->description}}</option>
                                    @endforeach
                                </select>
                            </div>


                            <button type="submit" class="btn btn-primary btn-fill col-xs-12"
                                style="text-align: center">Add New
                                Employee</button>



                        </div>

                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <div class="col-xs-5">

                </div>
                <button type="button" class="btn btn-secondary btn-fill col-xs-2" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>