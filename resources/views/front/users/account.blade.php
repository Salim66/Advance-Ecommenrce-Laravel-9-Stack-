@extends('layouts.front_layout.front_layout')

@section('content')
<div class="span9">
    <ul class="breadcrumb">
        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
        <li class="active">Login</li>
    </ul>
    <h3> My Account</h3>
    <hr class="soft"/>
    @if(session()->has('success_message'))
    <div class="alert alert-success" role="alert">
        {{ session()->get('success_message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if(session()->has('error_message'))
    <div class="alert alert-danger" role="alert">
        {{ session()->get('error_message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger mt-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="span4">
            <div class="well">
            <h5>Account Details</h5><br/>
            Enter your details to update an account.<br/><br/>
            <form id="accountForm" action="{{ url('account') }}" method="POST">
                @csrf
                <div class="control-group">
                    <label class="control-label" for="name">Name</label>
                    <div class="controls">
                        <input class="span3"  type="text" id="name" name="name" placeholder="Name" value="{{ $userDetails->name }}" pattern="[A-Za-z ]+">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="address">Address</label>
                    <div class="controls">
                        <input class="span3"  type="text" id="address" name="address" placeholder="Address" value="{{ $userDetails->address }}">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="city">City</label>
                    <div class="controls">
                        <input class="span3"  type="text" id="city" name="city" placeholder="City"  value="{{ $userDetails->city }}">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="state">State</label>
                    <div class="controls">
                        <input class="span3"  type="text" id="state" name="state" placeholder="State"  value="{{ $userDetails->state }}">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="country">Country</label>
                    <div class="controls">
                        <select class="span3" id="country" name="country">
                            <option selected disabled>Select Country</option>
                            @foreach($countries as $country)
                            <option value="{{ $country->country_name }}" @if($country->country_name == $userDetails->country) selected @endif>{{ $country->country_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="pincode">Pincode</label>
                    <div class="controls">
                        <input class="span3"  type="text" id="pincode" name="pincode" placeholder="Pincode" value="{{ $userDetails->pincode }}">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="mobile">Mobile</label>
                    <div class="controls">
                        <input class="span3" type="text" id="mobile" name="mobile" placeholder="Mobile" value="{{ $userDetails->mobile }}">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="email">Email address</label>
                    <div class="controls">
                        <input class="span3"  value="{{ $userDetails->email }}" readonly>
                    </div>
                </div>
                <div class="controls">
                <button type="submit" class="btn block">Update</button>
                </div>
            </form>
        </div>
        </div>
        <div class="span1"> &nbsp;</div>
        <div class="span4">
            <div class="well">
            <h5>Update Password</h5>
            <form id="updatePasswordForm" action="{{ url('update-user-password') }}" method="POST">
                @csrf
                <div class="control-group">
                    <label class="control-label" for="current_password">Current Password</label>
                    <div class="controls">
                        <input class="span3"  type="password" id="current_password" name="current_password"><br>
                        <span id="ckPass"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="new_password">New Password</label>
                    <div class="controls">
                        <input class="span3"  type="password" id="new_password" name="new_password">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="confirm_password">Confirm Password</label>
                    <div class="controls">
                        <input class="span3"  type="password" id="confirm_password" name="confirm_password">
                    </div>
                </div>
            <div class="control-group">
                <div class="controls">
                <button type="submit" class="btn">Update</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
