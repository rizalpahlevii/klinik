<div id="editProfileModal" class="modal fade px-0" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content   ">
            <div class="modal-header">
                <h5 class="modal-title">Edit Profile</h5>
                <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
            </div>
            {{ Form::open(['id'=>'editProfileForm','files'=>true]) }}
            <div class="modal-body">
                <div class="alert alert-danger display-none" id="editProfileValidationErrorsBox"></div>
                {{ Form::hidden('user_id',null,['id'=>'editUserId']) }}
                {{csrf_field()}}
                <div class="row">
                    <div class="form-group col-sm-6">
                        {{ Form::label('fullname', 'Full Name:') }}<span class="required">*</span>
                        {{ Form::text('fullname', null, ['id'=>'fullname','class' => 'form-control','required']) }}
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('username', 'Username:') }}<span class="required">*</span>
                        {{ Form::text('username', null, ['id'=>'username','class' => 'form-control','required']) }}
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="gender">Gender :</label><span class="required">*</span>
                        <select name="gender" id="gender" required class="form-control">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('phone', 'Phone:') }}
                        {{ Form::text('phone', null, ['id'=>'phone','class' => 'form-control']) }}
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="address">Address</label>
                        <textarea name="address" id="address" required cols="30" rows="5"
                            class="form-control"></textarea>
                    </div>
                </div>

                <div class="text-right">
                    {{ Form::button('Save', ['type'=>'submit','class' => 'btn btn-primary','id'=>'btnPrEditSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                    <button type="button" class="btn btn-light left-margin" data-dismiss="modal">Cancel
                    </button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div id="changeLanguageModal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content left-margin">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.profile.change_language')}}</h5>
                <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
            </div>
            {{ Form::open(['id'=>'changeLanguageForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger display-none" id="editProfileValidationErrorsBox"></div>
                {{csrf_field()}}
                <div class="row">
                    <div class="form-group col-12">
                        {{ Form::label('language',__('messages.profile.language').':') }}<span class="required">*</span>
                        {{ Form::select('language', \App\Models\User::LANGUAGES, Auth::user()->language, ['id'=>'language','class' => 'form-control','required']) }}
                    </div>
                </div>
                <div class="text-right">
                    {{ Form::button('Save', ['type'=>'submit','class' => 'btn btn-primary','id'=>'btnLanguageChange','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                    <button type="button" class="btn btn-light left-margin" data-dismiss="modal">Cancel
                    </button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
