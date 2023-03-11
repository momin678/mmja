@isset($costCenter)
<form action="{{ route('partyInfoUpdate', $costCenter) }}" method="POST">
@else
    <form action="{{ route('partyInfoPost') }}" method="POST">
    @endisset
    @csrf
    <div class="row match-height">



        <div class="col-md-6">

            <div class="form-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Party Info Code</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text" id="" class="form-control"
                            name=""
                            value="{{ $cc }}"
                            placeholder="Party Info Code" disabled readonly>

                    </div>
                    <div class="col-md-4">
                        <label>Party Info Name</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text" id="pi_name" class="form-control"
                            name="pi_name"
                            value="{{ isset($costCenter) ? $costCenter->pi_name : '' }}"
                            placeholder="Party Info Name" required>


                        @error('pi_name')
                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label>Cost Type</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <select name="pi_type" class="form-control" id=""
                            required>
                            <option value="">Select...</option>
                            @foreach ($costTypes as $item)
                                <option value="{{ $item->title }}"
                                    {{ isset($costCenter) ? ($costCenter->pi_type == $item->title ? 'selected' : '') : '' }}>
                                    {{ $item->title }}</option>
                            @endforeach
                        </select>

                        @error('pi_type')
                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="col-md-4">
                        <label>TRN</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text" id="trn_no" class="form-control"
                            name="trn_no"
                            value="{{ isset($costCenter) ? $costCenter->trn_no : '' }}"
                            placeholder="TRN Number" required>


                        @error('trn_no')
                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label>Address</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text" id="address" class="form-control"
                            name="address"
                            value="{{ isset($costCenter) ? $costCenter->address : '' }}"
                            placeholder="Address">


                        @error('address')
                            <div class="btn btn-sm btn-danger">{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Contact Person</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text" id="con_person" class="form-control"
                            name="con_person"
                            value="{{ isset($costCenter) ? $costCenter->con_person : '' }}"
                            placeholder="Contact Person">


                        @error('con_person')
                            <div class="btn btn-sm btn-danger">{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label>Mobile Phone No</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="number" id="con_no" class="form-control"
                            name="con_no"
                            value="{{ isset($costCenter) ? $costCenter->con_no : '' }}"
                            placeholder="Mobile No">


                        @error('con_no')
                            <div class="btn btn-sm btn-danger">{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label>Phone No</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="number" id="phone_no" class="form-control"
                            name="phone_no"
                            value="{{ isset($costCenter) ? $costCenter->phone_no : '' }}"
                            placeholder="Phone No">


                        @error('phone_no')
                            <div class="btn btn-sm btn-danger">{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label>Email</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text" id="email" class="form-control"
                            name="email"
                            value="{{ isset($costCenter) ? $costCenter->email : '' }}"
                            placeholder="Email">


                        @error('email')
                            <div class="btn btn-sm btn-danger">{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12 d-flex justify-content-end ">
                        <button class="btn btn-info project-form-btn mr-1"
                            data_target="{{ route('projectForm') }}" disabled>New</button>
                        <button type="submit" class="btn btn-primary mr-1"
                            >Submit</button>
                        <button type="reset" class="btn btn-light-secondary"
                            >Reset</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
