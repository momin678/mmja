<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Account Head Details</h4>
        </div>
        <div class="card-body ">
                <form action="{{ route('accHeahEditPost', $account_head) }}" method="POST">
                    @csrf
                    <div class="row match-height ">
                        <div class="col-md-6">
                            <h5>Account Details</h5>

                            <div class="form-body">
                                <div class="row">

                                    <div class="col-md-4">
                                        <label>A/C Code</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <div class="row">
                                            <input type="text" id="MA_Code" class="form-control" name="MA_Code"
                                                value="{{ isset($account_head) ? $account_head->fld_ac_code : '' }}"
                                                placeholder="Master A/C Code" readonly disabled>
                                        </div>

                                        @error('MA_Code')
                                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label>A/C Head</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <div class="row">
                                            <input type="text" id="fld_ac_head" class="form-control" name="fld_ac_head" value="{{ isset($account_head) ? $account_head->fld_ac_head : '' }}"

                                                placeholder="A/C Head" required>


                                        </div>

                                        @error('fld_ac_head')
                                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>Mapped To Master Account</h5>
                            <div class="form-body">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Master A/C Head</label>
                                        </div>
                                        <div class="col-md-8 form-group ">
                                            <input type="text" name="fld_Master_ACHead" class="form-control"
                                            value="{{ isset($account_head) ? $account_head->fld_ms_ac_head : '' }}" id=""
                                                readonly disabled>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Definition</label>
                                        </div>
                                        <div class="col-md-8 form-group ">
                                            <input type="text" name="fld_Defination" class="form-control"
                                            value="{{ isset($account_head) ? $account_head->fld_definition : '' }}" id=""
                                                readonly disabled>
                                        </div>



                                        <div class="col-12 d-flex justify-content-end ">
                                            <button type="submit" class="btn btn-primary mr-1">Submit</button>
                                            <button type="reset" class="btn btn-light-secondary">Reset</button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
    </div>
</div>
