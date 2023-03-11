@isset($bank)
<form action="{{ route('bankDetailsUpdate', $bank) }}" method="POST">
@else
    <form action="{{ route('bankDetailsPost') }}" method="POST">
    @endisset
    @csrf
    <div class="row match-height">
        <div class="col-md-6">

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>BANK CODE</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" id="" class="form-control" name=""
                                    value="{{ isset($cc) ? $cc : '' }}"
                                    placeholder="Bank Name" disabled readonly>
                            </div>
                            <div class="col-md-4">
                                <label>Bank Name</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" id="bank_name" class="form-control" name="bank_name"
                                    value="{{ isset($bank) ? $bank->bank_name : '' }}"
                                    placeholder="Bank Name" required>

                                    @error('bank_name')

                                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label>Branch Name</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" id="branch" class="form-control"
                                    value="{{ isset($bank) ? $bank->branch : '' }}" name="branch"
                                    placeholder="Branch Name" required>

                                    @error('branch')

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
                                <label>Account Number</label>
                            </div>
                            <div class="col-md-8 form-group ">
                                    <input type="number" id="ac_no" class="form-control"
                                        name="ac_no" value="{{ isset($bank) ? $bank->ac_no : '' }}"
                                        placeholder="Account Number" required>
                                        @error('ac_no')

                                        <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="col-md-4">
                                <label>Authorized Signatory</label>
                            </div>
                            <div class="col-md-8 form-group">
                                    <input type="text" id="signatory" class="form-control"
                                        name="signatory"
                                        value="{{ isset($bank) ? $bank->signatory : '' }}"
                                        placeholder="Authorized Signatory" required>

                                        @error('signatory')

                                        <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="col-12 d-flex justify-content-end ">
                                <button class="btn btn-info bank-form-btn mr-1"
                                data_target="{{ route('bankForm') }}" disabled>New</button>
                                <button type="submit" class="btn btn-primary mr-1">Submit</button>
                                <button type="reset" class="btn btn-light-secondary">Reset</button>

                            </div>
                        </div>
                    </div>
        </div>
    </div>
</form>
