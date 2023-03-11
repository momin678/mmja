@extends('layouts.backend.app')

@push('css')
    
@endpush

@section('content')

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="breadcrumbs-top">
                        <h5 class="content-header-title float-left pr-1 mb-0">Input</h5>
                        <div class="breadcrumb-wrapper d-none d-sm-block">
                            <ol class="breadcrumb p-0 mb-0 pl-1">
                                <li class="breadcrumb-item"><a href="index.html"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Form Elements</a>
                                </li>
                                <li class="breadcrumb-item active">Input
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic Inputs start -->
                <section id="basic-input">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Basic Inputs</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="basicInput">Basic Input</label>
                                                <input type="text" class="form-control" id="basicInput" placeholder="Enter email" />
                                            </fieldset>

                                            <fieldset class="form-group">
                                                <label for="helpInputTop">Input text with help</label>
                                                <small class="text-muted">eg.<i>someone@example.com</i></small>
                                                <input type="text" class="form-control" id="helpInputTop" />
                                            </fieldset>

                                            <fieldset class="form-group">
                                                <label for="helperText">With Helper Text</label>
                                                <input type="text" id="helperText" class="form-control" placeholder="Name" />
                                                <p>
                                                    <small class="form-text">Find helper text here for given textbox.</small>
                                                </p>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="disabledInput">Disabled Input</label>
                                                <input type="text" class="form-control" id="disabledInput" placeholder="Disabled Text" disabled />
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="disabledInput">Readonly Input</label>
                                                <input type="text" class="form-control" id="readonlyInput" readonly="readonly" value="You can't update me :P" />
                                            </fieldset>

                                            <fieldset class="form-group">
                                                <label for="disabledInput">Static Text</label>
                                                <p class="form-control-static" id="staticInput">
                                                    email@pixinvent.com
                                                </p>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Basic Inputs end -->

                <!-- Input Style start -->
                <section id="input-style">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Input Styles</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <p>
                                                To set rounded border to input box, use
                                                <code>.round</code> class and to set square border to input box,
                                                use <code>.sqaure</code> class along with
                                                <code>.form-control</code> class.
                                            </p>
                                        </div>
                                        <div class="col-sm-6">
                                            <fieldset class="form-group">
                                                <label for="roundText">Rounded Input</label>
                                                <input type="text" id="roundText" class="form-control round" placeholder="Rounded Input" />
                                            </fieldset>
                                        </div>
                                        <div class="col-sm-6">
                                            <fieldset class="form-group">
                                                <label for="squareText">Square Input</label>
                                                <input type="text" id="squareText" class="form-control square" placeholder="Square Input" />
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Input Style end -->

                <!-- Horizontal Input start -->
                <section id="horizontal-input">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Horizontal Input</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <p>
                                                To make label in center of form-control, use
                                                <code>.col-form-label</code> class with
                                                <code>&lt;label&gt;</code> element. This is default bootstrap
                                                class.
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-2 col-3">
                                                    <label for="first-name" class="col-form-label">First Name</label>
                                                </div>
                                                <div class="col-lg-10 col-9">
                                                    <input type="text" id="first-name" class="form-control" name="fname" placeholder="First Name" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-2 col-3">
                                                    <label for="last-name" class="col-form-label">Last Name</label>
                                                </div>
                                                <div class="col-lg-10 col-9">
                                                    <input type="text" id="last-name" class="form-control" name="fname" placeholder="Last Name" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Horizontal Input end -->

                <!-- Basic File Browser start -->
                <section id="input-file-browser">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">File Input</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <fieldset class="form-group">
                                                <label for="basicInputFile">Simple File Input</label>
                                                <input type="file" class="form-control-file" id="basicInputFile" />
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            <fieldset class="form-group">
                                                <label for="basicInputFile">With Browse button</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="inputGroupFile01" />
                                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Basic File Browser end -->

                <!-- Floating Label Inputs start -->
                <section id="floating-label-input">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Floating Label Inputs</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="mb-2">
                                                For Flating Label Inputs, need to use
                                                <code>.form-label-group</code> class & add attribute
                                                <code>disabled</code> for disabled Floating Label Input.
                                            </p>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <fieldset class="form-label-group">
                                                <input type="text" class="form-control" id="floating-label1" placeholder="Label-placeholder" />
                                                <label for="floating-label1">Label-placeholder</label>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <fieldset class="form-label-group form-group position-relative has-icon-left">
                                                <input type="text" class="form-control" id="iconLabelLeft" placeholder="Icon Left, Default Input" />
                                                <div class="form-control-position">
                                                    <i class="bx bx-user"></i>
                                                </div>
                                                <label for="iconLabelLeft">Icon Left, Default Input</label>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <fieldset class="form-label-group">
                                                <input type="text" class="form-control" id="floating-label-disable" placeholder="Label-placeholder" disabled />
                                                <label for="floating-label-disable">Disabled-placeholder</label>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Floating Label Inputs end -->

                <!-- Input with Icons start -->
                <section id="input-with-icons">
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Input with Icons</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <p>
                                                For Input Box with icon use
                                                <code>.position-relative</code> class with
                                                <code>.form-group</code> and use class
                                                <code>.has-icon-left</code> class for icon on left side. Wrap
                                                your icon element with
                                                <code>.form-control-position</code> class.
                                            </p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="iconLeft">Left Icon</label>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="text" class="form-control" id="iconLeft" placeholder="Icon Left, Default Input" />
                                                <div class="form-control-position">
                                                    <i class="bx bx-user"></i>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="iconRight">Right Icon</label>
                                            <fieldset class="form-group position-relative">
                                                <input type="text" class="form-control" id="iconRight" placeholder="Icon Right, Default Input" />
                                                <div class="form-control-position">
                                                    <i class="bx bx-file-blank"></i>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Input with Icons end -->

                <!-- Input Sizing start -->
                <section id="input-sizing">
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Control Sizing Option</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <p>
                                                For different sizes of Input, Use classes like
                                                <code>.form-control-lg</code> &amp;
                                                <code>.form-control-sm</code> for Large, Small input box.
                                            </p>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="sizeLarge">Large</label>
                                            <input class="form-control form-control-lg" id="sizeLarge" type="text" placeholder="Large Input" />
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="sizeDefault">Default</label>
                                            <input class="form-control" id="sizeDefault" type="text" placeholder="Default Input" />
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="sizeSmall">Small</label>
                                            <input class="form-control form-control-sm" id="sizeSmall" type="text" placeholder="Small Input" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Input Sizing end -->

                <!-- validations start -->
                <section id="input-validation">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Input Validation States</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <p>
                                                You can indicate invalid and valid form fields with
                                                <code>.is-invalid</code> and <code>.is-valid</code>. Note that
                                                <code>.invalid-feedback</code> is also supported with these
                                                classes.
                                            </p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="valid-state">Valid State</label>
                                            <input type="text" class="form-control is-valid" id="valid-state" placeholder="Valid" value="Valid" required />
                                            <div class="valid-feedback">
                                                <i class="bx bx-radio-circle"></i>
                                                This is valid state.
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="invalid-state">Invalid State</label>
                                            <input type="text" class="form-control is-invalid" id="invalid-state" placeholder="Invalid" value="Invalid" required />
                                            <div class="invalid-feedback">
                                                <i class="bx bx-radio-circle"></i>
                                                This is invalid state.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- validations end -->

                <!-- Tooltip validations start -->
                <section id="tooltip-validation">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Input Validation States with Tooltips</h4>
                                </div>
                                <div class="card-body">
                                    <p>
                                        Use <code>.needs-validation</code> with
                                        <code>&lt;form&gt;</code> for Input Validation states with tooltip,
                                        <code>.{valid/invalid}-feedback</code> classes for
                                        <code>.{valid/invalid}-tooltip</code> classes to display validation
                                        feedback in a styled tooltip.
                                    </p>
                                    <form class="needs-validation" novalidate>
                                        <div class="form-row">
                                            <div class="col-md-4 mb-3">
                                                <label for="validationTooltip01">First name</label>
                                                <input type="text" class="form-control" id="validationTooltip01" placeholder="First name" value="Mark" required />
                                                <div class="valid-tooltip">Looks good!</div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="validationTooltip02">Last name</label>
                                                <input type="text" class="form-control" id="validationTooltip02" placeholder="Last name" value="Otto" required />
                                                <div class="valid-tooltip">Looks good!</div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="validationTooltip03">City</label>
                                                <input type="text" class="form-control" id="validationTooltip03" placeholder="City" required />
                                                <div class="invalid-tooltip">Please provide a valid city.</div>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Tooltip validations end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('js')

@endpush
