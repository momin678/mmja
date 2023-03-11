@isset($costCenter)
<form action="{{ route('costCentersUpdate', $costCenter) }}" method="POST">
    @else
        <form action="{{ route('costCenterPost') }}" method="POST">
        @endisset
        @csrf
        <div class="row match-height">



            <div class="col-md-6">

                <div class="form-body">
                    <div class="row">

                        <div class="col-md-4">
                            <label>Code</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="" class="form-control" name="" value="{{ isset($cc) ? $cc : '' }}"
                                placeholder="Cost Center Code" disabled readonly>

                        </div>

                        <div class="col-md-4">
                            <label>Cost Center Name</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="cc_name" class="form-control" name="cc_name"
                                value="{{ isset($costCenter) ? $costCenter->cc_name : '' }}"
                                placeholder="Cost Center Name" required>


                            @error('cc_name')
                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label>Activities</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="activity" class="form-control" name="activity"
                                value="{{ isset($costCenter) ? $costCenter->activity : '' }}" placeholder="Activity"
                                required>


                            @error('activity')
                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                            @enderror
                        </div>



                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-body">
                    <div class="row">

                        <div class="col-md-4">
                            <label>Person responsible</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="prsn_responsible" class="form-control" name="prsn_responsible"
                                value="{{ isset($costCenter) ? $costCenter->prsn_responsible : '' }}"
                                placeholder="Person responsible" required>


                            @error('prsn_responsible')
                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label>Project</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <select name="project_id" class="form-control" id="" required >
                                <option value="">Select...</option>
                                @foreach ($projects as $item)
                                 <option value="{{ $item->id }}">{{ $item->proj_name }}</option>
                                @endforeach
                            </select>

                            @error('project_id')
                                <div class="btn btn-sm btn-danger">{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 d-flex justify-content-end ">
                            <button class="btn btn-info profit-center-form-btn mr-1"
                            data_target="{{ route('profitCenterForm') }}" disabled>New</button>
                            <button type="submit" class="btn btn-primary mr-1">Submit</button>
                            <button type="reset" class="btn btn-light-secondary">Reset</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
