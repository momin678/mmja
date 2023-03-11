
@isset($profitCenter)
<form action="{{ route('profitCentersUpdate', $profitCenter) }}" method="POST">
@else
    <form action="{{ route('profitCenterPost') }}" method="POST">
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
                        <input type="text" id="" class="form-control" name="" value="{{ isset($pc) ? $pc : '' }}"
                            placeholder="Profit Center Code" disabled readonly>

                    </div>

                    <div class="col-md-4">
                        <label>Profit Center Name</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text" id="pc_name" class="form-control" name="pc_name"
                            value="{{ isset($profitCenter) ? $profitCenter->pc_name : '' }}"
                            placeholder="Profit Center Name" required>


                        @error('pc_name')
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
                        <label>Activities</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text" id="activity" class="form-control" name="activity"
                            value="{{ isset($profitCenter) ? $profitCenter->activity : '' }}" placeholder="Activity"
                            required>


                        @error('activity')
                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Person responsible</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text" id="prsn_responsible" class="form-control" name="prsn_responsible"
                            value="{{ isset($profitCenter) ? $profitCenter->prsn_responsible : '' }}"
                            placeholder="Person responsible" required>


                        @error('prsn_responsible')
                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
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
